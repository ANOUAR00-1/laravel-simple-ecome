@extends('layouts.app')

@section('title', 'Nouvelle Catégorie')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" class="text-muted">Catégories</a></li>
            <li class="breadcrumb-item active"><strong>Nouvelle</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-0">Nouvelle Catégorie</h2>
    </div>

    <!-- Form Card -->
    <div class="card-minimal" style="max-width: 600px;">
        <div style="padding: 24px;">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nom" class="form-label small text-muted">Nom *</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                        value="{{ old('nom') }}" required>
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label small text-muted">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label small text-muted">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">
                        <i class="bi bi-check-lg"></i> Créer
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection