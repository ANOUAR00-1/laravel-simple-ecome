@extends('layouts.app')

@section('title', 'Commandes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Commandes</h1>
        <a href="{{ route('commandes.create') }}" class="btn btn-primary">Nouvelle Commande</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Recherche</div>
        <div class="card-body">
            <form action="{{ route('commandes.search') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Client</label>
                    <select class="form-select" name="client_id">
                        <option value="">Tous les clients</option>
                        @isset($clients)
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->prenom }} {{ $client->nom }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Statut</label>
                    <select class="form-select" name="statut">
                        <option value="">Tous</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente
                        </option>
                        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="livree" {{ request('statut') == 'livree' ? 'selected' : '' }}>Livrée</option>
                        <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date début</label>
                    <input type="date" class="form-control" name="date_debut" value="{{ request('date_debut') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date fin</label>
                    <input type="date" class="form-control" name="date_fin" value="{{ request('date_fin') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Rechercher</button>
                    <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Produits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
                <tr>
                    <td>{{ $commande->id }}</td>
                    <td>{{ $commande->client->prenom }} {{ $commande->client->nom }}</td>
                    <td>{{ $commande->date->format('d/m/Y') }}</td>
                    <td>
                        <span
                            class="badge bg-{{ $commande->statut == 'livree' ? 'success' : ($commande->statut == 'annulee' ? 'danger' : 'warning') }}">
                            {{ $commande->statut }}
                        </span>
                    </td>
                    <td>{{ $commande->produits->count() }}</td>
                    <td>
                        <a href="{{ route('commandes.show', $commande) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('commandes.edit', $commande) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('commandes.destroy', $commande) }}" method="POST" class="d-inline">
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

    {{ $commandes->links() }}
@endsection