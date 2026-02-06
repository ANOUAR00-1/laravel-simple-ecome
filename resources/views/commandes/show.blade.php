@extends('layouts.app')

@section('title', 'Commande #' . $commande->id)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-cart3"></i> Commande #{{ $commande->id }}</h1>
        <div class="btn-group">
            <a href="{{ route('commandes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <a href="{{ route('commandes.print', $commande) }}" class="btn btn-outline-primary" target="_blank">
                <i class="bi bi-printer"></i> Imprimer
            </a>
            <a href="{{ route('commandes.pdf', $commande) }}" class="btn btn-outline-danger">
                <i class="bi bi-file-pdf"></i> PDF
            </a>
        </div>
    </div>

    @if($commande->isArchived())
        <div class="alert alert-warning">
            <i class="bi bi-archive"></i> Cette commande est archivée ({{ $commande->archived_at->format('d/m/Y H:i') }})
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><i class="bi bi-info-circle"></i> Informations</div>
                <div class="card-body">
                    <p><strong>Client:</strong>
                        <a href="{{ route('clients.show', $commande->client) }}">
                            {{ $commande->client->prenom }} {{ $commande->client->nom }}
                        </a>
                    </p>
                    <p><strong>Date:</strong> {{ $commande->date->format('d/m/Y') }}</p>
                    <p><strong>Statut:</strong>
                        <span
                            class="badge bg-{{ $commande->statut == 'livree' ? 'success' : ($commande->statut == 'annulee' ? 'danger' : ($commande->statut == 'en_cours' ? 'info' : 'warning')) }}">
                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                        </span>
                    </p>
                    <p><strong>Notes:</strong> {{ $commande->notes ?? 'Aucune' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><i class="bi bi-calculator"></i> Totaux</div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td>Total HT</td>
                            <td class="text-end"><strong>{{ number_format($total, 2) }} DH</strong></td>
                        </tr>
                        <tr>
                            <td>TVA (20%)</td>
                            <td class="text-end">{{ number_format($tva, 2) }} DH</td>
                        </tr>
                        <tr class="table-primary">
                            <td><strong>Total TTC</strong></td>
                            <td class="text-end"><strong class="fs-4">{{ number_format($ttc, 2) }} DH</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($commande->canBeModified())
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-plus-circle"></i> Ajouter un produit</div>
            <div class="card-body">
                <form action="{{ route('commandes.addProduit', $commande) }}" method="POST" class="row g-3" data-barba-prevent>
                    @csrf
                    <div class="col-md-5">
                        <select class="form-select" name="produit_id" required>
                            <option value="">Sélectionner un produit</option>
                            @foreach($produits ?? \App\Models\Produit::all() as $p)
                                <option value="{{ $p->id }}">{{ $p->designation }} ({{ number_format((float) $p->prix, 2) }} DH)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="quantite" placeholder="Qté" min="1" value="1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" class="form-control" name="prix" placeholder="Prix" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-plus"></i> Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header"><i class="bi bi-box-seam"></i> Produits</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                        @if($commande->canBeModified())
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->produits as $produit)
                        <tr>
                            <td><a href="{{ route('produits.show', $produit) }}">{{ $produit->designation }}</a></td>
                            @if($commande->canBeModified())
                                <td>
                                    <form action="{{ route('commandes.updateProduit', [$commande, $produit]) }}" method="POST"
                                        class="d-flex gap-2" data-barba-prevent>
                                        @csrf
                                        @method('PUT')
                                        <input type="number" step="0.01" class="form-control form-control-sm" name="prix"
                                            value="{{ $produit->pivot->prix }}" style="width: 90px;" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="quantite"
                                        value="{{ $produit->pivot->quantite }}" style="width: 70px;" min="1" required>
                                </td>
                                <td><strong>{{ number_format($produit->pivot->prix * $produit->pivot->quantite, 2) }} DH</strong>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                        title="Modifier">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    </form>
                                    <form action="{{ route('commandes.removeProduit', [$commande, $produit]) }}" method="POST"
                                        class="d-inline" data-barba-prevent>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Retirer?')" data-bs-toggle="tooltip" title="Retirer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td>{{ number_format($produit->pivot->prix, 2) }} DH</td>
                                <td>{{ $produit->pivot->quantite }}</td>
                                <td><strong>{{ number_format($produit->pivot->prix * $produit->pivot->quantite, 2) }} DH</strong>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="{{ $commande->canBeModified() ? 3 : 3 }}" class="text-end">Total HT:</th>
                        <th>{{ number_format($total, 2) }} DH</th>
                        @if($commande->canBeModified())
                        <th></th>@endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
    </script>
@endsection