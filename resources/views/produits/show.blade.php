@extends('layouts.app')

@section('title', $produit->designation)

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('produits.index') }}" class="text-muted">Produits</a></li>
            <li class="breadcrumb-item active"><strong>{{ Str::limit($produit->designation, 30) }}</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">{{ $produit->designation }}</h2>
        <div class="btn-group">
            <a href="{{ route('produits.edit', $produit) }}" class="btn btn-outline-secondary">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('produits.index') }}" class="btn btn-dark">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Product Info Card -->
        <div class="col-md-4">
            <div class="card-minimal" style="height: 100%;">
                @if($produit->image)
                    <div style="height: 200px; overflow: hidden; border-radius: 12px 12px 0 0;">
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->designation }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @else
                    <div style="height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                border-radius: 12px 12px 0 0; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-box-seam-fill text-white" style="font-size: 3rem; opacity: 0.8;"></i>
                    </div>
                @endif
                <div style="padding: 24px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="text-primary fw-bold mb-0">{{ number_format($produit->prix, 2) }} DH</h3>
                        @if($produit->stock > 10)
                            <span class="badge-minimal" style="background: #e6f7ed; color: #00875a;">
                                Stock: {{ $produit->stock }}
                            </span>
                        @elseif($produit->stock > 0)
                            <span class="badge-minimal" style="background: #fff8e6; color: #cc8800;">
                                Stock: {{ $produit->stock }}
                            </span>
                        @else
                            <span class="badge-minimal" style="background: #ffebe6; color: #de350b;">Rupture</span>
                        @endif
                    </div>
                    @if($produit->category)
                        <div class="mb-3">
                            <small class="text-muted d-block">Catégorie</small>
                            <span class="badge-minimal" style="background: #e8f4fd; color: #0066cc;">
                                {{ $produit->category->nom }}
                            </span>
                        </div>
                    @endif
                    <div>
                        <small class="text-muted d-block">Description</small>
                        <p class="mb-0">{{ $produit->description ?? 'Aucune description' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-8">
            <div class="card-minimal">
                <div class="card-minimal-header">
                    <h5 class="mb-0"><i class="bi bi-cart3"></i> Commandes ({{ $produit->commandes->count() }})</h5>
                </div>
                @if($produit->commandes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-minimal mb-0">
                            <thead>
                                <tr>
                                    <th
                                        style="padding: 12px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                                        Commande</th>
                                    <th
                                        style="padding: 12px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                                        Quantité</th>
                                    <th
                                        style="padding: 12px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                                        Prix unitaire</th>
                                    <th
                                        style="padding: 12px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produit->commandes as $commande)
                                    <tr>
                                        <td><strong>#{{ str_pad($commande->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td>{{ $commande->pivot->quantite }}</td>
                                        <td><strong class="text-primary">{{ number_format($commande->pivot->prix, 2) }} DH</strong>
                                        </td>
                                        <td>
                                            <a href="{{ route('commandes.show', $commande) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="padding: 40px; text-align: center;">
                        <i class="bi bi-cart text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">Ce produit n'est dans aucune commande</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection