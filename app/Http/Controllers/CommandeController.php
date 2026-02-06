<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
        $query = Commande::with(['client', 'produits'])
            ->whereNull('archived_at');

        // Filter by status
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Filter by client name
        if ($request->filled('client_name')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->client_name . '%')
                    ->orWhere('prenom', 'like', '%' . $request->client_name . '%');
            });
        }

        $commandes = $query->latest()->paginate(15)->withQueryString();
        $clients = Client::all();

        return view('commandes.index', compact('commandes', 'clients'));
    }

    public function archived()
    {
        $commandes = Commande::with(['client', 'produits'])
            ->whereNotNull('archived_at')
            ->latest()
            ->paginate(15);
        return view('commandes.archived', compact('commandes'));
    }

    public function create()
    {
        $clients = Client::all();
        $produits = Produit::where('stock', '>', 0)->get();
        return view('commandes.create', compact('clients', 'produits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'statut' => 'nullable|in:en_attente,en_cours,livree,annulee',
            'notes' => 'nullable|string',
            'produits' => 'required|array|min:1',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
            'produits.*.prix' => 'required|numeric|min:0',
        ]);

        $commande = Commande::create([
            'client_id' => $validated['client_id'],
            'date' => $validated['date'],
            'statut' => $validated['statut'] ?? 'en_attente',
            'notes' => $validated['notes'],
        ]);

        foreach ($validated['produits'] as $produit) {
            $commande->produits()->attach($produit['id'], [
                'quantite' => $produit['quantite'],
                'prix' => $produit['prix'],
            ]);
        }

        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Commande créée avec succès.');
    }

    public function show(Commande $commande)
    {
        $commande->load(['client', 'produits']);
        $total = $commande->calculerTotal();
        $tva = $commande->calculerTVA();
        $ttc = $commande->calculerTTC();
        return view('commandes.show', compact('commande', 'total', 'tva', 'ttc'));
    }

    public function edit(Commande $commande)
    {
        if (!$commande->canBeModified()) {
            return redirect()->route('commandes.show', $commande)
                ->with('error', 'Cette commande ne peut plus être modifiée.');
        }

        $clients = Client::all();
        $produits = Produit::all();
        $commande->load('produits');
        return view('commandes.edit', compact('commande', 'clients', 'produits'));
    }

    public function update(Request $request, Commande $commande)
    {
        if (!$commande->canBeModified()) {
            return redirect()->route('commandes.show', $commande)
                ->with('error', 'Cette commande ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'statut' => 'required|in:en_attente,en_cours,livree,annulee',
            'notes' => 'nullable|string',
            'produits' => 'required|array|min:1',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
            'produits.*.prix' => 'required|numeric|min:0',
        ]);

        $commande->update([
            'client_id' => $validated['client_id'],
            'date' => $validated['date'],
            'statut' => $validated['statut'],
            'notes' => $validated['notes'],
        ]);

        $syncData = [];
        foreach ($validated['produits'] as $produit) {
            $syncData[$produit['id']] = [
                'quantite' => $produit['quantite'],
                'prix' => $produit['prix'],
            ];
        }
        $commande->produits()->sync($syncData);

        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Commande mise à jour avec succès.');
    }

    public function destroy(Commande $commande)
    {
        $commande->delete();

        return redirect()->route('commandes.index')
            ->with('success', 'Commande supprimée avec succès.');
    }

    public function search(Request $request)
    {
        $query = Commande::with(['client', 'produits'])->whereNull('archived_at');

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('date', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date', '<=', $request->date_fin);
        }

        $commandes = $query->latest()->paginate(15);
        $clients = Client::all();

        return view('commandes.index', compact('commandes', 'clients'));
    }

    public function addProduit(Request $request, Commande $commande)
    {
        if (!$commande->canBeModified()) {
            return redirect()->route('commandes.show', $commande)
                ->with('error', 'Cette commande ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'prix' => 'required|numeric|min:0',
        ]);

        $commande->produits()->attach($validated['produit_id'], [
            'quantite' => $validated['quantite'],
            'prix' => $validated['prix'],
        ]);

        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Produit ajouté à la commande.');
    }

    public function updateProduit(Request $request, Commande $commande, Produit $produit)
    {
        if (!$commande->canBeModified()) {
            return redirect()->route('commandes.show', $commande)
                ->with('error', 'Cette commande ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'quantite' => 'required|integer|min:1',
            'prix' => 'required|numeric|min:0',
        ]);

        $commande->produits()->updateExistingPivot($produit->id, [
            'quantite' => $validated['quantite'],
            'prix' => $validated['prix'],
        ]);

        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Produit mis à jour.');
    }

    public function removeProduit(Commande $commande, Produit $produit)
    {
        if (!$commande->canBeModified()) {
            return redirect()->route('commandes.show', $commande)
                ->with('error', 'Cette commande ne peut plus être modifiée.');
        }

        $commande->produits()->detach($produit->id);

        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Produit retiré de la commande.');
    }

    // Status management methods
    public function validateOrder(Commande $commande)
    {
        $commande->update(['statut' => 'en_cours']);
        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Commande validée avec succès.');
    }

    public function cancel(Commande $commande)
    {
        $commande->update(['statut' => 'annulee']);
        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Commande annulée.');
    }

    public function deliver(Commande $commande)
    {
        $commande->update(['statut' => 'livree']);
        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Commande marquée comme livrée.');
    }

    public function close(Commande $commande)
    {
        if ($commande->statut !== 'livree') {
            return redirect()->route('commandes.show', $commande)
                ->with('error', 'Seules les commandes livrées peuvent être clôturées.');
        }

        $commande->update(['archived_at' => now()]);
        return redirect()->route('commandes.index')
            ->with('success', 'Commande clôturée et archivée.');
    }

    // Print and export methods
    public function print(Commande $commande)
    {
        $commande->load(['client', 'produits']);
        $total = $commande->calculerTotal();
        $tva = $commande->calculerTVA();
        $ttc = $commande->calculerTTC();
        return view('commandes.print', compact('commande', 'total', 'tva', 'ttc'));
    }

    public function exportPdf(Commande $commande)
    {
        // Redirect to print view - use browser's "Save as PDF" feature
        // To enable actual PDF download, install: composer require barryvdh/laravel-dompdf
        return redirect()->route('commandes.print', $commande)
            ->with('info', 'Utilisez Ctrl+P puis "Enregistrer en PDF" pour télécharger.');
    }

    // Export filtered orders
    public function exportFilteredPrint(Request $request)
    {
        $query = Commande::with(['client', 'produits'])
            ->whereNull('archived_at');

        // Apply same filters as index
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }
        if ($request->filled('client_name')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->client_name . '%')
                    ->orWhere('prenom', 'like', '%' . $request->client_name . '%');
            });
        }

        $commandes = $query->latest()->get();
        $filters = $request->only(['statut', 'date_from', 'date_to', 'client_name']);

        // Calculate totals
        $grandTotal = $commandes->sum(function ($commande) {
            return $commande->calculerTTC();
        });

        return view('commandes.export-print', compact('commandes', 'filters', 'grandTotal'));
    }

    public function exportFilteredPdf(Request $request)
    {
        // Redirect to print view with filters
        return redirect()->route('commandes.export.print', $request->all())
            ->with('info', 'Utilisez Ctrl+P puis "Enregistrer en PDF" pour télécharger.');
    }

    // Archive methods
    public function archive(Commande $commande)
    {
        $commande->update(['archived_at' => now()]);
        return redirect()->route('commandes.index')
            ->with('success', 'Commande archivée avec succès.');
    }

    public function restore(Commande $commande)
    {
        $commande->update(['archived_at' => null]);
        return redirect()->route('commandes.index')
            ->with('success', 'Commande restaurée avec succès.');
    }
}
