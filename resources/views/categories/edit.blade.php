@extends('layouts.app')

@section('title', 'Modifier Catégorie')

@section('content')
    <h1>Modifier Catégorie</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $category->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description"
                name="description">{{ old('description', $category->description) }}</textarea>
        </div>

        @if($category->image)
            <div class="mb-3">
                <label class="form-label">Image actuelle</label>
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->nom }}" class="d-block"
                    style="max-height: 100px;">
            </div>
        @endif

        <div class="mb-3">
            <label for="image" class="form-label">Nouvelle Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('categories.show', $category) }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection