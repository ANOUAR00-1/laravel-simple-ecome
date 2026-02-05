@extends('layouts.app')

@section('title', 'Modifier Commande')

@section('content')
    <h1>Modifier Commande #{{ $commande->id }}</h1>

    <form action="{{ route('commandes.update', $commande) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="client_id" class="form-label">Client</label>
            <select class="form-select" id="client_id" name="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $commande->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->prenom }} {{ $client->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $commande->date->format('Y-m-d') }}"
                required>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select class="form-select" id="statut" name="statut">
                <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="en_cours" {{ $commande->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="livree" {{ $commande->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
                <option value="annulee" {{ $commande->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes">{{ $commande->notes }}</textarea>
        </div>

        <h4>Produits</h4>
        <div id="produits-container">
            @foreach($commande->produits as $index => $produit)
                <div class="row mb-2 produit-row">
                    <div class="col-md-5">
                        <select class="form-select" name="produits[{{ $index }}][id]" required>
                            @foreach($produits as $p)
                                <option value="{{ $p->id }}" {{ $produit->id == $p->id ? 'selected' : '' }}>
                                    {{ $p->designation }} ({{ number_format($p->prix, 2) }} €)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="produits[{{ $index }}][quantite]"
                            value="{{ $produit->pivot->quantite }}" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" class="form-control" name="produits[{{ $index }}][prix]"
                            value="{{ $produit->pivot->prix }}" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger" onclick="this.closest('.produit-row').remove()">X</button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addProduit()">+ Ajouter Produit</button>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('commandes.show', $commande) }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>

    <script>
        let produitIndex = {{ $commande->produits->count() }};
        function addProduit() {
            const container = document.getElementById('produits-container');
            const html = `
            <div class="row mb-2 produit-row">
                <div class="col-md-5">
                    <select class="form-select" name="produits[${produitIndex}][id]" required>
                        <option value="">Sélectionner un produit</option>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id }}">{{ $produit->designation }} ({{ number_format($produit->prix, 2) }} €)</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="produits[${produitIndex}][quantite]" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" class="form-control" name="produits[${produitIndex}][prix]" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" onclick="this.closest('.produit-row').remove()">X</button>
                </div>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', html);
            produitIndex++;
        }
    </script>
@endsection