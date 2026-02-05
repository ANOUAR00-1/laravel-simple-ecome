@extends('layouts.app')

@section('title', $client->nom)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $client->prenom }} {{ $client->nom }}</h1>
        <div>
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Email:</strong> {{ $client->email }}</p>
            <p><strong>Téléphone:</strong> {{ $client->telephone ?? 'Non renseigné' }}</p>
            <p><strong>Adresse:</strong> {{ $client->adresse ?? 'Non renseignée' }}</p>
        </div>
    </div>

    <h3>Commandes ({{ $client->commandes->count() }})</h3>
    @if($client->commandes->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($client->commandes as $commande)
                    <tr>
                        <td>{{ $commande->id }}</td>
                        <td>{{ $commande->date->format('d/m/Y') }}</td>
                        <td>{{ $commande->statut }}</td>
                        <td><a href="{{ route('commandes.show', $commande) }}" class="btn btn-sm btn-info">Voir</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune commande</p>
    @endif
@endsection