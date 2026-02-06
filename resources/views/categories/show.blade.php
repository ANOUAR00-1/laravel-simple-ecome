@extends('layouts.app')

@section('title', $category->nom)

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" class="text-muted">Catégories</a></li>
            <li class="breadcrumb-item active"><strong>{{ $category->nom }}</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">{{ $category->nom }}</h2>
        <div class="btn-group">
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-secondary">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-dark">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Category Info Card -->
        <div class="col-md-4">
            <div class="card-minimal" style="height: 100%;">
                @if($category->image)
                    <div style="height: 180px; overflow: hidden; border-radius: 12px 12px 0 0;">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->nom }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @else
                    <div style="height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                border-radius: 12px 12px 0 0; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-tags-fill text-white" style="font-size: 3rem; opacity: 0.8;"></i>
                    </div>
                @endif
                <div style="padding: 24px;">
                    <h5 class="fw-bold mb-2">{{ $category->nom }}</h5>
                    <p class="text-muted mb-3">{{ $category->description ?? 'Aucune description' }}</p>
                    <span class="badge-minimal" style="background: #e8f4fd; color: #0066cc;">
                        {{ $category->produits->count() }} produits
                    </span>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-md-8">
            <div class="card-minimal">
                <div class="card-minimal-header">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Produits ({{ $category->produits->count() }})</h5>
                </div>
                @if($category->produits->count() > 0)
                    <div class="row g-3" style="padding: 20px;">
                        @foreach($category->produits as $produit)
                            <div class="col-sm-6">
                                <div class="product-card-minimal">
                                    <div class="product-img-minimal">
                                        @if($produit->image)
                                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->designation }}">
                                        @else
                                            <i class="bi bi-box-seam"></i>
                                        @endif
                                    </div>
                                    <div class="product-info-minimal">
                                        <strong>{{ Str::limit($produit->designation, 25) }}</strong>
                                        <span class="product-price-minimal">{{ number_format($produit->prix, 2) }} DH</span>
                                    </div>
                                    <a href="{{ route('produits.show', $produit) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 40px; text-align: center;">
                        <i class="bi bi-box text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">Aucun produit dans cette catégorie</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection