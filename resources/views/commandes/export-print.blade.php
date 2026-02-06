<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Commandes - {{ now()->format('d/m/Y') }}</title>
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
            margin-bottom: 30px;
            border-bottom: 3px solid #1a1a2e;
            padding-bottom: 20px;
        }

        .company h1 {
            color: #1a1a2e;
            font-size: 28px;
        }

        .export-info {
            text-align: right;
        }

        .export-info h2 {
            color: #1a1a2e;
            font-size: 22px;
        }

        .filter-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .filter-info h3 {
            color: #1a1a2e;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .filter-info p {
            margin: 5px 0;
            color: #666;
        }

        .filter-info .badge {
            background: #1a1a2e;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 14px;
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
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }

        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 13px;
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

        .summary {
            background: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .summary h3 {
            color: #1a1a2e;
            margin-bottom: 15px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .summary-item {
            text-align: center;
        }

        .summary-item .label {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .summary-item .value {
            font-size: 24px;
            font-weight: bold;
            color: #1a1a2e;
        }

        .footer {
            margin-top: 40px;
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

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
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
        <a href="{{ route('commandes.index', $filters) }}"
            style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">
            ← Retour
        </a>
    </div>

    <div class="header">
        <div class="company">
            <h1>🛒 E-Commerce</h1>
            <p>Export des Commandes</p>
        </div>
        <div class="export-info">
            <h2>EXPORT</h2>
            <p><strong>Date:</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p><strong>Total:</strong> {{ $commandes->count() }} commande(s)</p>
        </div>
    </div>

    <!-- Filter Information -->
    @if($filters)
        <div class="filter-info">
            <h3>📊 Critères de filtrage</h3>
            <div style="display: flex; gap: 30px; flex-wrap: wrap;">
                @if(isset($filters['statut']) && $filters['statut'])
                    <p><strong>Statut:</strong> <span
                            class="badge">{{ ucfirst(str_replace('_', ' ', $filters['statut'])) }}</span></p>
                @endif
                @if(isset($filters['date_from']) && $filters['date_from'])
                    <p><strong>Date début:</strong> {{ \Carbon\Carbon::parse($filters['date_from'])->format('d/m/Y') }}</p>
                @endif
                @if(isset($filters['date_to']) && $filters['date_to'])
                    <p><strong>Date fin:</strong> {{ \Carbon\Carbon::parse($filters['date_to'])->format('d/m/Y') }}</p>
                @endif
                @if(isset($filters['client_name']) && $filters['client_name'])
                    <p><strong>Client:</strong> {{ $filters['client_name'] }}</p>
                @endif
            </div>
        </div>
    @endif

    <!-- Orders Table -->
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Client</th>
                <th>Date</th>
                <th>Statut</th>
                <th class="text-right">Montant TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
                <tr>
                    <td><strong>#{{ str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $commande->client->prenom }} {{ $commande->client->nom }}</td>
                    <td>{{ $commande->date->format('d/m/Y') }}</td>
                    <td><span
                            class="status {{ $commande->statut }}">{{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</span>
                    </td>
                    <td class="text-right"><strong>{{ number_format($commande->calculerTTC(), 2) }} DH</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <h3>Résumé</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">Total Commandes</div>
                <div class="value">{{ $commandes->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Total Produits</div>
                <div class="value">{{ $commandes->sum(function ($c) {
    return $c->produits->count(); }) }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Montant Total</div>
                <div class="value">{{ number_format($grandTotal, 2) }} DH</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        <p>E-Commerce - Système de Gestion des Commandes</p>
    </div>
</body>

</html>