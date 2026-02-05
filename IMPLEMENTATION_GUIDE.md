# Laravel Many-to-Many Relationship - Implementation Guide

## 📋 Project Overview

This project implements a complete **Many-to-Many relationship** between `Commandes` (Orders) and `Produits` (Products) in Laravel, based on the educational material provided.

### Database Schema

```
Client 1 ──────── * Commande * ──────── * Produit
                        │
                   commande_produit (pivot)
                   - commande_id
                   - produit_id
                   - quantite
                   - prix
```

## 🚀 Setup Instructions

### 1. Run Migrations

```bash
php artisan migrate
```

This will create the following tables:

- `clients`
- `commandes`
- `produits`
- `commande_produit` (pivot table)

### 2. Test the Routes

The following routes are available:

#### Web Routes

- **Clients**: `/clients` (index, create, store, show, edit, update, destroy)
- **Produits**: `/produits` (index, create, store, show, edit, update, destroy)
- **Commandes**: `/commandes` (index, create, store, show, edit, update, destroy)

#### Pivot Operations

- `POST /commandes/{commande}/produits` - Attach product to commande
- `DELETE /commandes/{commande}/produits/{produit}` - Detach product from commande
- `PATCH /commandes/{commande}/produits/{produit}` - Update pivot data

#### API Routes (v1)

- `GET /api/v1/clients` - List all clients
- `GET /api/v1/produits` - List all products
- `GET /api/v1/commandes` - List all orders
- `POST /api/v1/commandes/{commande}/sync-produits` - Sync products
- `GET /api/v1/commandes/{commande}/total` - Calculate total

## 💡 Usage Examples (from screenshots)

### 1. Create a Commande with Products

```php
$commande = Commande::create([
    'client_id' => 1,
    'date' => now()
]);

$commande->produits()->attach([
    1 => ['quantite' => 2, 'prix' => 50],
    2 => ['quantite' => 1, 'prix' => 120]
]);
```

### 2. Read Products from a Commande

```php
$commande = Commande::with('produits')->find(1);

foreach ($commande->produits as $produit) {
    echo $produit->designation;
    echo $produit->pivot->quantite;
    echo $produit->pivot->prix;
}
```

### 3. Update Quantity (Pivot)

```php
$commande->produits()->updateExistingPivot(1, [
    'quantite' => 5
]);
```

### 4. Detach a Product

```php
$commande->produits()->detach(2);
```

### 5. Sync Products (Replace All)

```php
$commande->produits()->sync([
    1 => ['quantite' => 3, 'prix' => 50],
    3 => ['quantite' => 2, 'prix' => 90],
]);
```

### 6. Calculate Total

```php
$total = $commande->calculerTotal();
```

Or use the sum method:

```php
$total = $commande->produits->sum(function ($produit) {
    return $produit->pivot->quantite * $produit->pivot->prix;
});
```

### 7. Eager Loading (Performance)

```php
// Good - Only 2 queries
$commandes = Commande::with('produits')->get();

// Bad - N+1 problem
$commandes = Commande::all();
foreach ($commandes as $commande) {
    $commande->produits; // Each iteration = 1 query
}
```

## 🎯 Key Features Implemented

✅ **Migrations**

- Clients, Commandes, Produits tables
- Pivot table with custom fields (quantite, prix)

✅ **Eloquent Models**

- Many-to-Many relationships with `belongsToMany`
- `withPivot()` for custom pivot fields
- `withTimestamps()` on pivot

✅ **CRUD Operations**

- Full resource controllers for all models
- API controllers with JSON responses

✅ **Pivot Operations**

- `attach()` - Add products to order
- `detach()` - Remove products from order
- `sync()` - Replace all products
- `updateExistingPivot()` - Update quantities

✅ **Business Logic**

- Total calculation method
- Eager loading for performance
- Validation rules

## 📚 API Testing Examples

### Create Commande with Products

```bash
POST /api/v1/commandes
Content-Type: application/json

{
  "client_id": 1,
  "date": "2024-01-01",
  "produits": [
    {"id": 1, "quantite": 2, "prix": 50},
    {"id": 2, "quantite": 1, "prix": 120}
  ]
}
```

### Get Commande Total

```bash
GET /api/v1/commandes/1/total
```

Response:

```json
{
    "commande_id": 1,
    "total": 220,
    "details": [
        {
            "produit_id": 1,
            "designation": "Product A",
            "quantite": 2,
            "prix_unitaire": 50,
            "sous_total": 100
        },
        {
            "produit_id": 2,
            "designation": "Product B",
            "quantite": 1,
            "prix_unitaire": 120,
            "sous_total": 120
        }
    ]
}
```

## 🔍 Next Steps

1. Create views for the web controllers (Blade templates)
2. Add seeders for sample data
3. Implement authentication
4. Add more business rules (stock management, order status workflow)
5. Create unit tests

## 📝 Notes

- All foreign keys use `cascadeOnDelete()` for data integrity
- Stock management can be added in future iterations
- The `sync()` method removes old entries and inserts new ones
- Pivot timestamps are automatically managed with `withTimestamps()`
