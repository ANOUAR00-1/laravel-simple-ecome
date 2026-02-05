@extends('layouts.app')

@section('title', 'Catégories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Catégories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Nouvelle Catégorie</a>
    </div>

    <div class="row">
        @foreach($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->nom }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->nom }}</h5>
                        <p class="card-text">{{ Str::limit($category->description, 100) }}</p>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Confirmer?')">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $categories->links() }}
@endsection