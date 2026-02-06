<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Produits - {{ now()->format('d/m/Y') }}</title>
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

        .badge {
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
            grid-template-columns: repeat(4, 1fr);
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
            font-size: 20px;
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
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #1a1a2e; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ Imprimer
        </button>
        <a href="{{ route('produits.index', $filters ?? []) }}"
            style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">
            ← Retour
        </a>
    </div>

    <div class="header">
        <div class="company">
            <h1>🛒 E-Commerce</h1>
            <p>Liste des Produits</p>
        </div>
        <div class="export-info">
            <h2>EXPORT</h2>
            <p><strong>Date:</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p><strong>Total:</strong> {{ $produits->count() }} produit(s)</p>
        </div>
    </div>

    @if($filters && !empty(array_filter($filters)))
        <div class="filter-info">
            <h3>📊 Critères de filtrage</h3>
            <div style="display: flex; gap: 30px; flex-wrap: wrap;">
                @if(isset($filters['search']) && $filters['search'])
                    <p><strong>Recherche:</strong> {{ $filters['search'] }}</p>
                @endif
                @if(isset($filters['category_id']) && $filters['category_id'])
                    <p><strong>Catégorie:</strong> <span
                            class="badge">{{ $categories[$filters['category_id']]->nom ?? 'N/A' }}</span></p>
                @endif
                @if(isset($filters['stock_status']) && $filters['stock_status'])
                    <p><strong>Stock:</strong> {{ $filters['stock_status'] === 'in_stock' ? 'En stock' : 'Rupture' }}</p>
                @endif
            </div>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Produit</th>
                <th>Catégorie</th>
                <th class="text-right">Prix</th>
                <th class="text-right">Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produits as $produit)
                <tr>
                    <td>#{{ $produit->id }}</td>
                    <td><strong>{{ $produit->designation }}</strong></td>
                    <td>{{ $produit->category->nom ?? '-' }}</td>
                    <td class="text-right">{{ number_format($produit->prix, 2) }} DH</td>
                    <td class="text-right">{{ $produit->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Résumé</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">Total Produits</div>
                <div class="value">{{ $produits->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="label">En Stock</div>
                <div class="value">{{ $produits->where('stock', '>', 0)->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Rupture</div>
                <div class="value">{{ $produits->where('stock', '<=', 0)->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Valeur Totale</div>
                <div class="value">{{ number_format($produits->sum('prix'), 2) }} DH</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        <p>E-Commerce - Système de Gestion</p>
    </div>
</body>

</html>