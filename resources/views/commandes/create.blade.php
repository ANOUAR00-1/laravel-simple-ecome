@extends('layouts.app')

@section('title', 'Nouvelle Commande')

@section('content')
    <h1>Nouvelle Commande</h1>

    <form action="{{ route('commandes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="client_id" class="form-label">Client</label>
            <select class="form-select" id="client_id" name="client_id" required>
                <option value="">Sélectionner un client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->prenom }} {{ $client->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select class="form-select" id="statut" name="statut">
                <option value="en_attente">En attente</option>
                <option value="en_cours">En cours</option>
                <option value="livree">Livrée</option>
                <option value="annulee">Annulée</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes"></textarea>
        </div>

        <h4>Produits</h4>
        <div id="produits-container">
            <div class="row mb-2 produit-row">
                <div class="col-md-5">
                    <select class="form-select" name="produits[0][id]" required>
                        <option value="">Sélectionner un produit</option>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id }}">{{ $produit->designation }}
                                ({{ number_format($produit->prix, 2) }} €)</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="produits[0][quantite]" placeholder="Qté" min="1"
                        value="1" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" class="form-control" name="produits[0][prix]" placeholder="Prix"
                        required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" onclick="this.closest('.produit-row').remove()">X</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addProduit()">+ Ajouter Produit</button>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>

    <script>
        let produitIndex = 1;
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
                    <input type="number" class="form-control" name="produits[${produitIndex}][quantite]" placeholder="Qté" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" class="form-control" name="produits[${produitIndex}][prix]" placeholder="Prix" required>
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