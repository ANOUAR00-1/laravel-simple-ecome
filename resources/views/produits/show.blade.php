@extends('layouts.app')

@section('title', $produit->designation)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $produit->designation }}</h1>
        <div>
            <a href="{{ route('produits.edit', $produit) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('produits.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            @if($produit->image)
                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->designation }}" class="img-fluid mb-3"
                    style="max-height: 200px;">
            @endif
            <p><strong>Prix:</strong> {{ number_format($produit->prix, 2) }} €</p>
            <p><strong>Stock:</strong> {{ $produit->stock }}</p>
            <p><strong>Description:</strong> {{ $produit->description ?? 'Aucune description' }}</p>
        </div>
    </div>

    <h3>Commandes contenant ce produit</h3>
    @if($produit->commandes->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Commande #</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produit->commandes as $commande)
                    <tr>
                        <td>{{ $commande->id }}</td>
                        <td>{{ $commande->pivot->quantite }}</td>
                        <td>{{ number_format($commande->pivot->prix, 2) }} €</td>
                        <td><a href="{{ route('commandes.show', $commande) }}" class="btn btn-sm btn-info">Voir</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Ce produit n'est dans aucune commande</p>
    @endif
@endsection