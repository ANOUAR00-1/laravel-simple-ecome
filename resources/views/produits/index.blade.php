@extends('layouts.app')

@section('title', 'Produits')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Produits</h1>
        <a href="{{ route('produits.create') }}" class="btn btn-primary">Nouveau Produit</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Désignation</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produits as $produit)
                <tr>
                    <td>{{ $produit->id }}</td>
                    <td>{{ $produit->designation }}</td>
                    <td>{{ number_format($produit->prix, 2) }} €</td>
                    <td>{{ $produit->stock }}</td>
                    <td>
                        <a href="{{ route('produits.show', $produit) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('produits.edit', $produit) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Confirmer?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $produits->links() }}
@endsection