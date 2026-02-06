@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item text-muted">Admin</li>
                <li class="breadcrumb-item active"><strong>Dashboard</strong></li>
            </ol>
        </nav>
    </div>

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Dashboard</h2>
        <span class="text-muted small">{{ now()->format('d M Y') }}</span>
    </div>

    <!-- Stats Cards - Clean Minimal Style -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">Clients</span>
                    <h2 class="stat-value">{{ $stats['clients'] }}</h2>
                </div>
                <div class="stat-icon-minimal text-teal">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">Ventes</span>
                    <h2 class="stat-value">{{ number_format($stats['revenue'] ?? 0, 0, ',', ' ') }} DH</h2>
                </div>
                <div class="stat-icon-minimal text-blue">
                    <i class="bi bi-cart-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">Produits</span>
                    <h2 class="stat-value">{{ $stats['produits'] }}</h2>
                </div>
                <div class="stat-icon-minimal text-purple">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">Commandes</span>
                    <h2 class="stat-value">{{ $stats['commandes'] }}</h2>
                </div>
                <div class="stat-icon-minimal text-coral">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">Catégories</span>
                    <h2 class="stat-value">{{ $stats['categories'] }}</h2>
                </div>
                <div class="stat-icon-minimal text-orange">
                    <i class="bi bi-tags-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">En attente</span>
                    <h2 class="stat-value">{{ $stats['pending'] ?? 0 }}</h2>
                </div>
                <div class="stat-icon-minimal text-yellow">
                    <i class="bi bi-clock-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">Livrées ce mois</span>
                    <h2 class="stat-value">{{ $stats['delivered'] ?? 0 }}</h2>
                </div>
                <div class="stat-icon-minimal text-green">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables Row -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card-minimal">
                <div class="card-minimal-header">
                    <h5 class="mb-0">Derniers Clients</h5>
                    <a href="{{ route('clients.create') }}" class="btn btn-sm btn-dark">
                        <i class="bi bi-plus"></i> Nouveau
                    </a>
                </div>
                <div class="card-minimal-body">
                    <table class="table table-minimal mb-0">
                        <tbody>
                            @forelse($recentClients as $client)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $client->prenom }} {{ $client->nom }}</strong>
                                            <small class="d-block text-muted">{{ $client->email }}</small>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-outline-secondary">
                                            Voir
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center py-3">Aucun client</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-minimal">
                <div class="card-minimal-header">
                    <h5 class="mb-0">Dernières Commandes</h5>
                    <a href="{{ route('commandes.create') }}" class="btn btn-sm btn-dark">
                        <i class="bi bi-plus"></i> Nouvelle
                    </a>
                </div>
                <div class="card-minimal-body">
                    <table class="table table-minimal mb-0">
                        <tbody>
                            @forelse($recentCommandes as $commande)
                                <tr>
                                    <td>
                                        <strong>#{{ str_pad($commande->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>{{ $commande->client->prenom }} {{ $commande->client->nom }}</td>
                                    <td>
                                        <span class="badge-minimal badge-{{ $commande->statut }}">
                                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('commandes.show', $commande) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            Voir
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted text-center py-3">Aucune commande</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card-minimal">
                <div class="card-minimal-header">
                    <h5 class="mb-0">Produits Récents</h5>
                    <a href="{{ route('produits.create') }}" class="btn btn-sm btn-dark">
                        <i class="bi bi-plus"></i> Nouveau
                    </a>
                </div>
                <div class="card-minimal-body">
                    <div class="row g-3">
                        @foreach($recentProduits ?? [] as $produit)
                            @php /** @var \App\Models\Produit $produit */ @endphp
                            <div class="col-md-4 col-sm-6">
                                <div class="product-card-minimal">
                                    <div class="product-img-minimal">
                                        @if($produit->image)
                                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->designation }}">
                                        @else
                                            <i class="bi bi-box-seam"></i>
                                        @endif
                                    </div>
                                    <div class="product-info-minimal">
                                        <strong>{{ Str::limit($produit->designation, 20) }}</strong>
                                        <span class="product-price-minimal">{{ number_format((float) $produit->prix, 2) }}
                                            DH</span>
                                        <small class="text-muted">Stock: {{ $produit->stock }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection