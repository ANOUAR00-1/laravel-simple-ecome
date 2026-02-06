@extends('layouts.app')

@section('title', 'Catégories')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item text-muted">Admin</li>
            <li class="breadcrumb-item active"><strong>Catégories</strong></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Catégories</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg"></i> Nouvelle Catégorie
        </a>
    </div>

    <!-- Filter Panel -->
    <div class="card-minimal mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3" style="padding: 20px 24px 0;">
            <h6 class="mb-0 fw-bold"><i class="bi bi-funnel"></i> Recherche & Export</h6>
        </div>
        <form action="{{ route('categories.index') }}" method="GET" style="padding: 0 24px 20px;">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small text-muted">Rechercher</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Nom de la catégorie..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-sm btn-dark">
                    <i class="bi bi-search"></i> Rechercher
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Réinitialiser
                </a>

                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('categories.export.print', request()->all()) }}"
                        class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="bi bi-printer"></i> Imprimer
                    </a>
                    <a href="{{ route('categories.export.pdf', request()->all()) }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Categories Grid -->
    <div class="row g-4">
        @forelse($categories as $category)
            <div class="col-md-4 col-sm-6">
                <div class="card-minimal"
                    style="height: 100%; overflow: hidden; border: 1px solid #eee; border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
                    <!-- Category Header -->
                    <div
                        style="height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        @if($category->image)
                            <div
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('{{ asset('storage/' . $category->image) }}'); background-size: cover; background-position: center; opacity: 0.4;">
                            </div>
                        @endif
                        <i class="bi bi-tags-fill text-white" style="font-size: 2.5rem; position: relative; z-index: 1;"></i>
                    </div>

                    <!-- Category Body -->
                    <div style="padding: 24px;">
                        <h5 class="fw-bold text-dark mb-1">{{ $category->nom }}</h5>
                        <p class="text-muted small mb-3" style="min-height: 40px;">
                            {{ Str::limit($category->description, 60) }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge-minimal"
                                style="background: #e0f2fe; color: #0369a1; font-size: 0.8rem; padding: 6px 12px;">
                                {{ $category->produits_count ?? 0 }} produits
                            </span>

                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('categories.show', $category) }}">
                                            <i class="bi bi-eye me-2"></i> Voir détails
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('categories.edit', $category) }}">
                                            <i class="bi bi-pencil me-2"></i> Modifier
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Supprimer cette catégorie?')">
                                                <i class="bi bi-trash me-2"></i> Supprimer
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Voir Link (The user specifically asked for 'voir style') -->
                        <div class="mt-3 pt-3 border-top">
                            <a href="{{ route('categories.show', $category) }}"
                                class="text-decoration-none fw-bold d-block text-center"
                                style="color: #667eea; font-size: 0.9rem;">
                                Voir la catégorie <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-minimal text-center py-5">
                    <i class="bi bi-tags text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3 mb-0">Aucune catégorie trouvée</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection