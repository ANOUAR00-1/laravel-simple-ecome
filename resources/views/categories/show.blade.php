@extends('layouts.app')

@section('title', $category->nom)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $category->nom }}</h1>
        <div>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->nom }}" class="img-fluid mb-3"
                    style="max-height: 200px;">
            @endif
            <p>{{ $category->description ?? 'Aucune description' }}</p>
        </div>
    </div>

    <h3>Produits ({{ $category->produits->count() }})</h3>
    @if($category->produits->count() > 0)
        <div class="row">
            @foreach($category->produits as $produit)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $produit->designation }}</h5>
                            <p>{{ number_format($produit->prix, 2) }} €</p>
                            <a href="{{ route('produits.show', $produit) }}" class="btn btn-sm btn-info">Voir</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Aucun produit dans cette catégorie</p>
    @endif
@endsection