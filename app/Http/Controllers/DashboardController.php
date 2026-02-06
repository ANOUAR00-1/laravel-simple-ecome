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
            'commandes' => Commande::whereNull('archived_at')->count(),
            'revenue' => Commande::whereNull('archived_at')
                ->where('statut', 'livree')
                ->get()
                ->sum(fn($c) => $c->calculerTotal()),
            'pending' => Commande::whereNull('archived_at')
                ->where('statut', 'en_attente')
                ->count(),
            'delivered' => Commande::whereNull('archived_at')
                ->where('statut', 'livree')
                ->whereMonth('date', now()->month)
                ->count(),
        ];

        $recentClients = Client::latest()->take(5)->get();
        $recentCommandes = Commande::with('client')->whereNull('archived_at')->latest()->take(5)->get();
        $recentProduits = Produit::latest()->take(6)->get();

        return view('dashboard', compact('stats', 'recentClients', 'recentCommandes', 'recentProduits'));
    }
}
