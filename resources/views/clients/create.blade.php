@extends('layouts.app')

@section('title', 'Nouveau Client')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}" class="text-muted">Clients</a></li>
            <li class="breadcrumb-item active"><strong>Nouveau</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-0">Nouveau Client</h2>
    </div>

    <!-- Form Card -->
    <div class="card-minimal" style="max-width: 600px;">
        <div style="padding: 24px;">
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="prenom" class="form-label small text-muted">Prénom *</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom"
                            name="prenom" value="{{ old('prenom') }}" required>
                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nom" class="form-label small text-muted">Nom *</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                            value="{{ old('nom') }}" required>
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label for="email" class="form-label small text-muted">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mt-3">
                    <label for="telephone" class="form-label small text-muted">Téléphone</label>
                    <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                        name="telephone" value="{{ old('telephone') }}">
                    @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mt-3">
                    <label for="adresse" class="form-label small text-muted">Adresse</label>
                    <textarea class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse"
                        rows="3">{{ old('adresse') }}</textarea>
                    @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-dark">
                        <i class="bi bi-check-lg"></i> Créer
                    </button>
                    <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection