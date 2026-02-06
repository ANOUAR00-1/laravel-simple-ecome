@extends('layouts.app')

@section('title', 'Commandes')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item text-muted">Admin</li>
            <li class="breadcrumb-item active"><strong>Commandes</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Commandes</h2>
        <div class="btn-group">
            <a href="{{ route('commandes.archived') }}" class="btn btn-outline-secondary">
                <i class="bi bi-archive"></i> Archivées
            </a>
            <a href="{{ route('commandes.create') }}" class="btn btn-dark">
                <i class="bi bi-plus-lg"></i> Nouvelle Commande
            </a>
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="card-minimal mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3" style="padding: 20px 24px 0;">
            <h6 class="mb-0 fw-bold"><i class="bi bi-funnel"></i> Filtres</h6>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                data-bs-target="#filterPanel">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        <div class="collapse show" id="filterPanel">
            <form action="{{ route('commandes.index') }}" method="GET" style="padding: 0 24px 20px;">
                <div class="row g-3">
                    <!-- Status Filter -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Statut</label>
                        <select name="statut" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente
                            </option>
                            <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="livree" {{ request('statut') == 'livree' ? 'selected' : '' }}>Livrée</option>
                            <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Date début</label>
                        <input type="date" name="date_from" class="form-control form-control-sm"
                            value="{{ request('date_from') }}">
                    </div>

                    <!-- Date To -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Date fin</label>
                        <input type="date" name="date_to" class="form-control form-control-sm"
                            value="{{ request('date_to') }}">
                    </div>

                    <!-- Client Name -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Client</label>
                        <input type="text" name="client_name" class="form-control form-control-sm"
                            placeholder="Nom du client" value="{{ request('client_name') }}">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-sm btn-dark">
                        <i class="bi bi-search"></i> Filtrer
                    </button>
                    <a href="{{ route('commandes.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </a>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('commandes.export.print', request()->all()) }}"
                            class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="bi bi-printer"></i> Imprimer
                        </a>
                        <a href="{{ route('commandes.export.pdf', request()->all()) }}"
                            class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card-minimal">
        <div class="table-responsive">
            <table class="table table-minimal mb-0">
                <thead>
                    <tr>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            N°</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Client</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Date</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Statut</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Produits</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commandes as $commande)
                        <tr>
                            <td><strong>#{{ str_pad($commande->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>
                                <strong>{{ $commande->client->prenom }} {{ $commande->client->nom }}</strong>
                            </td>
                            <td><span class="text-muted">{{ $commande->date->format('d/m/Y') }}</span></td>
                            <td>
                                <span class="badge-minimal badge-{{ $commande->statut }}">
                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-minimal" style="background: #f0f0f0; color: #666;">
                                    {{ $commande->produits->count() }} article(s)
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        id="actions{{ $commande->id }}" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i> Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actions{{ $commande->id }}">
                                        <!-- View -->
                                        <li>
                                            <a class="dropdown-item" href="{{ route('commandes.show', $commande) }}">
                                                <i class="bi bi-eye"></i> Voir détails
                                            </a>
                                        </li>

                                        <!-- Edit -->
                                        @if($commande->canBeModified())
                                            <li>
                                                <a class="dropdown-item" href="{{ route('commandes.edit', $commande) }}">
                                                    <i class="bi bi-pencil"></i> Modifier
                                                </a>
                                            </li>
                                        @endif

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <!-- Status Actions -->
                                        @if($commande->statut === 'en_attente')
                                            <li>
                                                <form action="{{ route('commandes.validate', $commande) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="bi bi-check-circle"></i> Valider
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        @if($commande->statut === 'en_cours')
                                            <li>
                                                <form action="{{ route('commandes.deliver', $commande) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-info">
                                                        <i class="bi bi-truck"></i> Marquer livrée
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        @if($commande->statut === 'livree' && !$commande->isArchived())
                                            <li>
                                                <form action="{{ route('commandes.close', $commande) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-lock"></i> Clôturer
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        @if(!in_array($commande->statut, ['livree', 'annulee']))
                                            <li>
                                                <form action="{{ route('commandes.cancel', $commande) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Annuler cette commande?')">
                                                        <i class="bi bi-x-circle"></i> Annuler
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <!-- Print & PDF -->
                                        <li>
                                            <a class="dropdown-item" href="{{ route('commandes.print', $commande) }}"
                                                target="_blank">
                                                <i class="bi bi-printer"></i> Imprimer
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('commandes.pdf', $commande) }}">
                                                <i class="bi bi-file-pdf"></i> Télécharger PDF
                                            </a>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <!-- Archive/Restore -->
                                        @if(!$commande->isArchived())
                                            <li>
                                                <form action="{{ route('commandes.archive', $commande) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item"
                                                        onclick="return confirm('Archiver cette commande?')">
                                                        <i class="bi bi-archive"></i> Archiver
                                                    </button>
                                                </form>
                                            </li>
                                        @else
                                            <li>
                                                <form action="{{ route('commandes.restore', $commande) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="bi bi-arrow-counterclockwise"></i> Restaurer
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        <!-- Delete -->
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form action="{{ route('commandes.destroy', $commande) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Supprimer cette commande?')">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Aucune commande trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $commandes->links() }}
    </div>
@endsection