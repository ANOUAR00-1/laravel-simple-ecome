@extends('layouts.app')

@section('title', 'Commande #' . $commande->id)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Commande #{{ $commande->id }}</h1>
        <div>
            <a href="{{ route('commandes.edit', $commande) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Informations</div>
                <div class="card-body">
                    <p><strong>Client:</strong>
                        <a href="{{ route('clients.show', $commande->client) }}">
                            {{ $commande->client->prenom }} {{ $commande->client->nom }}
                        </a>
                    </p>
                    <p><strong>Date:</strong> {{ $commande->date->format('d/m/Y') }}</p>
                    <p><strong>Statut:</strong>
                        <span
                            class="badge bg-{{ $commande->statut == 'livree' ? 'success' : ($commande->statut == 'annulee' ? 'danger' : 'warning') }}">
                            {{ $commande->statut }}
                        </span>
                    </p>
                    <p><strong>Notes:</strong> {{ $commande->notes ?? 'Aucune' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Total</div>
                <div class="card-body">
                    <h2 class="text-primary">{{ number_format($total, 2) }} €</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Ajouter un produit</div>
        <div class="card-body">
            <form action="{{ route('commandes.addProduit', $commande) }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-5">
                    <select class="form-select" name="produit_id" required>
                        <option value="">Sélectionner un produit</option>
                        @foreach($produits ?? \App\Models\Produit::all() as $p)
                            <option value="{{ $p->id }}">{{ $p->designation }} ({{ number_format((float) $p->prix, 2) }} €)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="quantite" placeholder="Qté" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" class="form-control" name="prix" placeholder="Prix" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <h3>Produits</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->produits as $produit)
                <tr>
                    <td><a href="{{ route('produits.show', $produit) }}">{{ $produit->designation }}</a></td>
                    <td>
                        <form action="{{ route('commandes.updateProduit', [$commande, $produit]) }}" method="POST"
                            class="d-flex">
                            @csrf
                            @method('PUT')
                            <input type="number" step="0.01" class="form-control form-control-sm" name="prix"
                                value="{{ $produit->pivot->prix }}" style="width: 80px;" required>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" name="quantite"
                            value="{{ $produit->pivot->quantite }}" style="width: 60px;" min="1" required>
                    </td>
                    <td>{{ number_format($produit->pivot->prix * $produit->pivot->quantite, 2) }} €</td>
                    <td>
                        <button type="submit" class="btn btn-sm btn-primary">Modifier</button>
                        </form>
                        <form action="{{ route('commandes.removeProduit', [$commande, $produit]) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Retirer ce produit?')">Retirer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th>{{ number_format($total, 2) }} €</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
@endsection