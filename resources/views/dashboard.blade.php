@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h3>{{ $stats['clients'] }}</h3>
                    <p class="mb-0">Clients</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('clients.index') }}" class="text-white">Voir tout →</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h3>{{ $stats['produits'] }}</h3>
                    <p class="mb-0">Produits</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('produits.index') }}" class="text-white">Voir tout →</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h3>{{ $stats['categories'] }}</h3>
                    <p class="mb-0">Catégories</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('categories.index') }}" class="text-white">Voir tout →</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h3>{{ $stats['commandes'] }}</h3>
                    <p class="mb-0">Commandes</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('commandes.index') }}" class="text-dark">Voir tout →</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Derniers Clients</span>
                    <a href="{{ route('clients.create') }}" class="btn btn-sm btn-primary">+ Nouveau</a>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            @foreach($recentClients as $client)
                                <tr>
                                    <td>{{ $client->prenom }} {{ $client->nom }}</td>
                                    <td><a href="{{ route('clients.show', $client) }}"
                                            class="btn btn-sm btn-outline-primary">Voir</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Dernières Commandes</span>
                    <a href="{{ route('commandes.create') }}" class="btn btn-sm btn-primary">+ Nouvelle</a>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            @foreach($recentCommandes as $commande)
                                <tr>
                                    <td>#{{ $commande->id }} - {{ $commande->client->prenom }}</td>
                                    <td>{{ $commande->statut }}</td>
                                    <td><a href="{{ route('commandes.show', $commande) }}"
                                            class="btn btn-sm btn-outline-primary">Voir</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection