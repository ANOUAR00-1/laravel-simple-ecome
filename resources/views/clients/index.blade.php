@extends('layouts.app')

@section('title', 'Clients')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item text-muted">Admin</li>
            <li class="breadcrumb-item active"><strong>Clients</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Clients</h2>
        <a href="{{ route('clients.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg"></i> Nouveau Client
        </a>
    </div>

    <!-- Filter Panel -->
    <div class="card-minimal mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3" style="padding: 20px 24px 0;">
            <h6 class="mb-0 fw-bold"><i class="bi bi-funnel"></i> Recherche & Export</h6>
        </div>
        <form action="{{ route('clients.index') }}" method="GET" style="padding: 0 24px 20px;">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small text-muted">Rechercher</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Nom, email ou téléphone..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-sm btn-dark">
                    <i class="bi bi-search"></i> Rechercher
                </button>
                <a href="{{ route('clients.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Réinitialiser
                </a>

                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('clients.export.print', request()->all()) }}" class="btn btn-sm btn-outline-primary"
                        target="_blank">
                        <i class="bi bi-printer"></i> Imprimer
                    </a>
                    <a href="{{ route('clients.export.pdf', request()->all()) }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Clients Table -->
    <div class="card-minimal">
        <div class="table-responsive">
            <table class="table table-minimal mb-0" id="clientsTable">
                <thead>
                    <tr>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            ID</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Nom</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Email</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Téléphone</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Adresse</th>
                        <th
                            style="padding: 16px 24px; background: #fafafa; font-weight: 600; color: #6c757d; font-size: 0.85rem;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td><span class="text-muted">#{{ $client->id }}</span></td>
                            <td><strong>{{ $client->prenom }} {{ $client->nom }}</strong></td>
                            <td><span class="text-muted">{{ $client->email }}</span></td>
                            <td><span class="text-muted">{{ $client->telephone }}</span></td>
                            <td><span class="text-muted">{{ Str::limit($client->adresse, 30) }}</span></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Supprimer ce client?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Aucun client trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $clients->links() }}
    </div>
@endsection