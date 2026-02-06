<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Clients - {{ now()->format('d/m/Y') }}</title>
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
        <a href="{{ route('clients.index', $filters ?? []) }}"
            style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">
            ← Retour
        </a>
    </div>

    <div class="header">
        <div class="company">
            <h1>🛒 E-Commerce</h1>
            <p>Liste des Clients</p>
        </div>
        <div class="export-info">
            <h2>EXPORT</h2>
            <p><strong>Date:</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p><strong>Total:</strong> {{ $clients->count() }} client(s)</p>
        </div>
    </div>

    @if($filters && !empty(array_filter($filters)))
        <div class="filter-info">
            <h3>📊 Critères de recherche</h3>
            <div style="display: flex; gap: 30px; flex-wrap: wrap;">
                @if(isset($filters['search']) && $filters['search'])
                    <p><strong>Recherche:</strong> {{ $filters['search'] }}</p>
                @endif
            </div>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>#{{ $client->id }}</td>
                    <td><strong>{{ $client->prenom }} {{ $client->nom }}</strong></td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->telephone }}</td>
                    <td>{{ $client->adresse }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Résumé</h3>
        <p><strong>Total Clients:</strong> {{ $clients->count() }}</p>
    </div>

    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        <p>E-Commerce - Système de Gestion</p>
    </div>
</body>

</html>