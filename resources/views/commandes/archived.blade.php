@extends('layouts.app')

@section('title', 'Commandes Archivées')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-archive"></i> Commandes Archivées</h1>
        <a href="{{ route('commandes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour aux commandes
        </a>
    </div>

    @if($commandes->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Aucune commande archivée.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Archivée le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commandes as $commande)
                    <tr>
                        <td><strong>#{{ $commande->id }}</strong></td>
                        <td>{{ $commande->client->prenom }} {{ $commande->client->nom }}</td>
                        <td>{{ $commande->date->format('d/m/Y') }}</td>
                        <td>
                            <span
                                class="badge bg-{{ $commande->statut == 'livree' ? 'success' : ($commande->statut == 'annulee' ? 'danger' : 'warning') }}">
                                {{ $commande->statut }}
                            </span>
                        </td>
                        <td>{{ $commande->archived_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('commandes.show', $commande) }}" class="btn btn-sm btn-outline-info"
                                    data-bs-toggle="tooltip" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('commandes.restore', $commande) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip"
                                        title="Restaurer">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $commandes->links() }}
    @endif

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
    </script>
@endsection