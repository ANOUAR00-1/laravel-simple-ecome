<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande #{{ $commande->id }} - Impression</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            padding: 40px;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            border-bottom: 3px solid #1a1a2e;
            padding-bottom: 20px;
        }

        .company h1 {
            color: #1a1a2e;
            font-size: 28px;
        }

        .company p {
            color: #666;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-info h2 {
            color: #1a1a2e;
            font-size: 24px;
        }

        .invoice-info p {
            color: #666;
            margin: 5px 0;
        }

        .client-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .client-info h3 {
            color: #1a1a2e;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        thead {
            background: #1a1a2e;
            color: white;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-left: auto;
            width: 300px;
        }

        .totals table {
            margin-bottom: 0;
        }

        .totals th {
            background: #f8f9fa;
            color: #333;
        }

        .totals .total-row {
            background: #1a1a2e;
            color: white;
            font-size: 18px;
        }

        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        .status.en_attente {
            background: #ffc107;
            color: #333;
        }

        .status.en_cours {
            background: #17a2b8;
            color: white;
        }

        .status.livree {
            background: #28a745;
            color: white;
        }

        .status.annulee {
            background: #dc3545;
            color: white;
        }

        .notes {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        @media print {
            body {
                padding: 20px;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #1a1a2e; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ Imprimer
        </button>
        <a href="{{ route('commandes.show', $commande) }}"
            style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">
            ← Retour
        </a>
    </div>

    <div class="header">
        <div class="company">
            <h1>🛒 E-Commerce</h1>
            <p>Système de Gestion des Commandes</p>
        </div>
        <div class="invoice-info">
            <h2>FACTURE</h2>
            <p><strong>N°:</strong> {{ str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Date:</strong> {{ $commande->date->format('d/m/Y') }}</p>
            <p><span
                    class="status {{ $commande->statut }}">{{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</span>
            </p>
        </div>
    </div>

    <div class="client-info">
        <h3>Client</h3>
        <p><strong>{{ $commande->client->prenom }} {{ $commande->client->nom }}</strong></p>
        <p>📧 {{ $commande->client->email }}</p>
        <p>📞 {{ $commande->client->telephone }}</p>
        <p>📍 {{ $commande->client->adresse }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th class="text-right">Prix Unitaire</th>
                <th class="text-right">Quantité</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->produits as $index => $produit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $produit->designation }}</td>
                    <td class="text-right">{{ number_format($produit->pivot->prix, 2) }} DH</td>
                    <td class="text-right">{{ $produit->pivot->quantite }}</td>
                    <td class="text-right">{{ number_format($produit->pivot->prix * $produit->pivot->quantite, 2) }} DH</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <th>Total HT</th>
                <td class="text-right">{{ number_format($total, 2) }} DH</td>
            </tr>
            <tr>
                <th>TVA (20%)</th>
                <td class="text-right">{{ number_format($tva, 2) }} DH</td>
            </tr>
            <tr class="total-row">
                <th>Total TTC</th>
                <td class="text-right"><strong>{{ number_format($ttc, 2) }} DH</strong></td>
            </tr>
        </table>
    </div>

    @if($commande->notes)
        <div class="notes">
            <strong>Notes:</strong> {{ $commande->notes }}
        </div>
    @endif

    <div class="footer">
        <p>Merci pour votre confiance!</p>
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>

</html>