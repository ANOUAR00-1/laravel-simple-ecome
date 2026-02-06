@extends('layouts.app')

@section('title', 'Modifier Produit')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('produits.index') }}" class="text-muted">Produits</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produits.show', $produit) }}"
                    class="text-muted">{{ Str::limit($produit->designation, 20) }}</a></li>
            <li class="breadcrumb-item active"><strong>Modifier</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-0">Modifier Produit</h2>
    </div>

    <!-- Form Card -->
    <div class="card-minimal" style="max-width: 700px;">
        <div style="padding: 24px;">
            <form action="{{ route('produits.update', $produit) }}" method="POST" enctype="multipart/form-data"
                data-barba-prevent>
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="category_id" class="form-label small text-muted">Catégorie</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                        name="category_id">
                        <option value="">-- Sélectionner une catégorie --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $produit->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label small text-muted">Désignation *</label>
                    <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation"
                        name="designation" value="{{ old('designation', $produit->designation) }}" required>
                    @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="prix" class="form-label small text-muted">Prix (DH) *</label>
                        <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror" id="prix"
                            name="prix" value="{{ old('prix', $produit->prix) }}" required>
                        @error('prix')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="stock" class="form-label small text-muted">Stock *</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
                            name="stock" value="{{ old('stock', $produit->stock) }}" required>
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label small text-muted">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" rows="3">{{ old('description', $produit->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if($produit->image)
                    <div class="mb-3">
                        <label class="form-label small text-muted">Image actuelle</label>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->designation }}"
                                style="max-height: 80px; border-radius: 8px;">
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="image"
                        class="form-label small text-muted">{{ $produit->image ? 'Nouvelle Image' : 'Image' }}</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">
                        <i class="bi bi-check-lg"></i> Enregistrer
                    </button>
                    <a href="{{ route('produits.show', $produit) }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection