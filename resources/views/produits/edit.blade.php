@extends('layouts.app')

@section('title', 'Modifier Produit')

@section('content')
    <h1>Modifier Produit</h1>

    <form action="{{ route('produits.update', $produit) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="designation" class="form-label">Désignation</label>
            <input type="text" class="form-control" id="designation" name="designation"
                value="{{ old('designation', $produit->designation) }}" required>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix (€)</label>
            <input type="number" step="0.01" class="form-control" id="prix" name="prix"
                value="{{ old('prix', $produit->prix) }}" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $produit->stock) }}"
                required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description"
                name="description">{{ old('description', $produit->description) }}</textarea>
        </div>

        @if($produit->image)
            <div class="mb-3">
                <label class="form-label">Image actuelle</label>
                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->designation }}" class="d-block"
                    style="max-height: 100px;">
            </div>
        @endif

        <div class="mb-3">
            <label for="image" class="form-label">Nouvelle Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('produits.show', $produit) }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection