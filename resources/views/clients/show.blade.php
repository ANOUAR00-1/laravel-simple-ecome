@extends('layouts.app')

@section('title', $client->nom)

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}" class="text-muted">Clients</a></li>
            <li class="breadcrumb-item active"><strong>{{ $client->prenom }} {{ $client->nom }}</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">{{ $client->prenom }} {{ $client->nom }}</h2>
            <span class="text-muted">Client #{{ $client->id }}</span>
        </div>
        <div class="btn-group">
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-outline-secondary">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('clients.index') }}" class="btn btn-dark">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Client Info Card -->
        <div class="col-md-4">
            <div class="card-minimal" style="height: 100%;">
                <div class="card-minimal-header">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Informations</h5>
                </div>
                <div style="padding: 24px;">
                    <div class="mb-3">
                        <small class="text-muted d-block">Email</small>
                        <strong>{{ $client->email }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Téléphone</small>
                        <strong>{{ $client->telephone ?? 'Non renseigné' }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">Adresse</small>
                        <strong>{{ $client->adresse ?? 'Non renseignée' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Orders Card -->
        <div class="col-md-8">
            <div class="card-minimal">
                <div class="card-minimal-header">
                    <h5 class="mb-0"><i class="bi bi-cart3"></i> Commandes ({{ $client->commandes->count() }})</h5>
                </div>
                @if($client->commandes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-minimal mb-0">
                            <thead>
                                <tr>
                                    <th
                                        style="padding: 12px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                                        N°</th>
                                    <th
                                        style="padding: 12px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                                        Date</th>
                                    <th
                                        style="padding: 12px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                                        Statut</th>
                                    <th
                                        style="padding: 12px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($client->commandes as $commande)
                                    <tr>
                                        <td><strong>#{{ str_pad($commande->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td><span class="text-muted">{{ $commande->date->format('d/m/Y') }}</span></td>
                                        <td>
                                            <span class="badge-minimal badge-{{ $commande->statut }}">
                                                {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('commandes.show', $commande) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="padding: 40px; text-align: center;">
                        <i class="bi bi-cart text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">Aucune commande</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection