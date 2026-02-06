<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Commande #{{ $commande->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 30px;
            color: #333;
            font-size: 12px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #1a1a2e;
            padding-bottom: 15px;
        }

        .company h1 {
            color: #1a1a2e;
            font-size: 22px;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-info h2 {
            color: #1a1a2e;
            font-size: 18px;
        }

        .client-info {
            background: #f0f0f0;
            padding: 15px;
            margin-bottom: 20px;
        }

        .client-info h3 {
            margin-bottom: 8px;
            color: #1a1a2e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background: #1a1a2e;
            color: white;
        }

        th,
        td {
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            width: 250px;
            margin-left: auto;
        }

        .totals td,
        .totals th {
            padding: 6px 10px;
        }

        .total-row {
            background: #1a1a2e;
            color: white;
        }

        .notes {
            background: #fff3cd;
            padding: 10px;
            margin-top: 15px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company">
            <h1>E-Commerce</h1>
            <p>Système de Gestion</p>
        </div>
        <div class="invoice-info">
            <h2>FACTURE</h2>
            <p><strong>N°:</strong> {{ str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Date:</strong> {{ $commande->date->format('d/m/Y') }}</p>
            <p><strong>Statut:</strong> {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</p>
        </div>
    </div>

    <div class="client-info">
        <h3>Client</h3>
        <p><strong>{{ $commande->client->prenom }} {{ $commande->client->nom }}</strong></p>
        <p>Email: {{ $commande->client->email }}</p>
        <p>Tél: {{ $commande->client->telephone }}</p>
        <p>Adresse: {{ $commande->client->adresse }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th class="text-right">Prix</th>
                <th class="text-right">Qté</th>
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

    <table class="totals">
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

    @if($commande->notes)
        <div class="notes">
            <strong>Notes:</strong> {{ $commande->notes }}
        </div>
    @endif

    <div class="footer">
        <p>Merci pour votre confiance!</p>
        <p>Document généré le {{ now()->format('d/m/Y') }}</p>
    </div>
</body>

</html>