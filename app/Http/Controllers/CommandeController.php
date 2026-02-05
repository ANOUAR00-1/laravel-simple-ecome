<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['client', 'produits'])->latest()->paginate(15);
        $clients = Client::all();
        return view('commandes.index', compact('commandes', 'clients'));
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
        return view('commandes.show', compact('commande', 'total'));
    }

    public function edit(Commande $commande)
    {
        $clients = Client::all();
        $produits = Produit::all();
        $commande->load('produits');
        return view('commandes.edit', compact('commande', 'clients', 'produits'));
    }

    public function update(Request $request, Commande $commande)
    {
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
        $query = Commande::with(['client', 'produits']);

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
        $commande->produits()->detach($produit->id);

        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Produit retiré de la commande.');
    }
}
