@extends('layouts.app')

@section('title', 'Clients')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Clients</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">Nouveau Client</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->nom }}</td>
                    <td>{{ $client->prenom }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->telephone }}</td>
                    <td>
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Confirmer?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $clients->links() }}
@endsection