<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::with('category');

        // Filter by search term
        if ($request->filled('search')) {
            $query->where('designation', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock', '<=', 0);
            }
        }

        $produits = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('produits.index', compact('produits', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'designation' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit = Produit::create($validated);

        return redirect()->route('produits.show', $produit)
            ->with('success', 'Produit créé avec succès.');
    }

    public function show(Produit $produit)
    {
        $produit->load('commandes');
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        $categories = Category::all();
        return view('produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'designation' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($validated);

        return redirect()->route('produits.show', $produit)
            ->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Produit $produit)
    {
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();

        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé avec succès.');
    }

    // Export methods
    public function exportPrint(Request $request)
    {
        $query = Produit::with('category');

        if ($request->filled('search')) {
            $query->where('designation', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock', '<=', 0);
            }
        }

        $produits = $query->latest()->get();
        $filters = $request->only(['search', 'category_id', 'stock_status']);
        $categories = Category::all()->keyBy('id');

        return view('produits.export-print', compact('produits', 'filters', 'categories'));
    }

    public function exportPdf(Request $request)
    {
        return redirect()->route('produits.export.print', $request->all())
            ->with('info', 'Utilisez Ctrl+P puis "Enregistrer en PDF" pour télécharger.');
    }
}
