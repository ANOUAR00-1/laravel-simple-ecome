<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Produit;
use App\Models\Category;
use App\Models\Commande;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'clients' => Client::count(),
            'produits' => Produit::count(),
            'categories' => Category::count(),
            'commandes' => Commande::count(),
        ];

        $recentClients = Client::latest()->take(5)->get();
        $recentCommandes = Commande::with('client')->latest()->take(5)->get();
        $recentProduits = Produit::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentClients', 'recentCommandes', 'recentProduits'));
    }
}
