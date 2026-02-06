@extends('layouts.app')

@section('title', 'Produits')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item text-muted">Admin</li>
            <li class="breadcrumb-item active"><strong>Produits</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Produits</h2>
        <a href="{{ route('produits.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg"></i> Nouveau Produit
        </a>
    </div>

    <!-- Filter Panel -->
    <div class="card-minimal mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3" style="padding: 20px 24px 0;">
            <h6 class="mb-0 fw-bold"><i class="bi bi-funnel"></i> Filtres & Export</h6>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanel">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        <div class="collapse show" id="filterPanel">
            <form action="{{ route('produits.index') }}" method="GET" style="padding: 0 24px 20px;">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Rechercher</label>
                        <input type="text" name="search" class="form-control form-control-sm" 
                               placeholder="Nom du produit..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Catégorie</label>
                        <select name="category_id" class="form-select form-select-sm">
                            <option value="">Toutes</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Stock</label>
                        <select name="stock_status" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>En stock</option>
                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Rupture</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-sm btn-dark">
                        <i class="bi bi-search"></i> Filtrer
                    </button>
                    <a href="{{ route('produits.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </a>
                    
                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('produits.export.print', request()->all()) }}" 
                           class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="bi bi-printer"></i> Imprimer
                        </a>
                        <a href="{{ route('produits.export.pdf', request()->all()) }}" 
                           class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">Total Produits</span>
                    <h2 class="stat-value">{{ $produits->total() }}</h2>
                </div>
                <div class="stat-icon-minimal text-blue">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">En stock</span>
                    <h2 class="stat-value">{{ $produits->where('stock', '>', 0)->count() }}</h2>
                </div>
                <div class="stat-icon-minimal text-green">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">Rupture</span>
                    <h2 class="stat-value">{{ $produits->where('stock', '<=', 0)->count() }}</h2>
                </div>
                <div class="stat-icon-minimal text-coral">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-minimal">
                <div class="stat-content">
                    <span class="stat-label">Prix moyen</span>
                    <h2 class="stat-value">{{ number_format($produits->avg('prix') ?? 0, 0) }} DH</h2>
                </div>
                <div class="stat-icon-minimal text-purple">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card-minimal">
        <div class="table-responsive">
            <table class="table table-minimal mb-0">
                <thead>
                    <tr>
                        <th style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">ID</th>
                        <th style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">Produit</th>
                        <th style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">Catégorie</th>
                        <th style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">Prix</th>
                        <th style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">Stock</th>
                        <th style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produits as $produit)
                        <tr>
                            <td><span class="text-muted">#{{ $produit->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="product-img-minimal">
                                        @if($produit->image)
                                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->designation }}">
                                        @else
                                            <i class="bi bi-box-seam"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <strong>{{ Str::limit($produit->designation, 30) }}</strong>
                                        @if($produit->description)
                                            <small class="d-block text-muted">{{ Str::limit($produit->description, 40) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($produit->category)
                                    <span class="badge-minimal" style="background: #e8f4fd; color: #0066cc;">
                                        {{ $produit->category->nom }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><strong class="text-primary">{{ number_format($produit->prix, 2) }} DH</strong></td>
                            <td>
                                @if($produit->stock > 10)
                                    <span class="badge-minimal" style="background: #e6f7ed; color: #00875a;">{{ $produit->stock }}</span>
                                @elseif($produit->stock > 0)
                                    <span class="badge-minimal" style="background: #fff8e6; color: #cc8800;">{{ $produit->stock }}</span>
                                @else
                                    <span class="badge-minimal" style="background: #ffebe6; color: #de350b;">Rupture</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('produits.show', $produit) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('produits.edit', $produit) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Supprimer ce produit?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Aucun produit trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $produits->links() }}
    </div>
@endsection