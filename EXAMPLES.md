# Examples from Screenshots - Laravel Many-to-Many

This file contains all the practical examples shown in the screenshots for testing and learning purposes.

## Example 1: Create a Commande with Products

```php
use App\Models\Commande;

// Create commande
$commande = Commande::create([
    'client_id' => 1,
    'date' => now()
]);

// Attach products with pivot data
$commande->produits()->attach([
    1 => ['quantite' => 2, 'prix' => 50],
    2 => ['quantite' => 1, 'prix' => 120]
]);
```

**Explanation**: The `attach()` method inserts records into the pivot table `commande_produit`.

---

## Example 2: Read Products from a Commande

```php
use App\Models\Commande;

// Load commande with products
$commande = Commande::with('produits')->find(1);

// Loop through products
foreach ($commande->produits as $produit) {
    echo $produit->designation . "\n";
    echo "Quantité: " . $produit->pivot->quantite . "\n";
    echo "Prix: " . $produit->pivot->prix . "\n";
}
```

**Explanation**: Access pivot data using `$produit->pivot->field_name`.

---

## Example 3: Update Quantity in Pivot Table

```php
use App\Models\Commande;

$commande = Commande::find(1);

// Update quantity for product ID 1
$commande->produits()->updateExistingPivot(1, [
    'quantite' => 5
]);
```

**Explanation**: `updateExistingPivot()` updates the pivot record for a specific product.

---

## Example 4: Remove a Product from a Commande

```php
use App\Models\Commande;

$commande = Commande::find(1);

// Remove product with ID 2
$commande->produits()->detach(2);
```

**Explanation**: `detach()` removes the relationship from the pivot table.

---

## Example 5: Sync Products (Replace All)

```php
use App\Models\Commande;

$commande = Commande::find(1);

// Sync: Remove old products and add these new ones
$commande->produits()->sync([
    1 => ['quantite' => 3, 'prix' => 50],
    3 => ['quantite' => 2, 'prix' => 90],
]);
```

**Explanation**:

- `sync()` removes all old associations
- Inserts the new ones provided
- Very useful for update forms

---

## Example 6: Calculate Total of a Commande

### Method 1: Using the Model Method

```php
use App\Models\Commande;

$commande = Commande::with('produits')->find(1);
$total = $commande->calculerTotal();

echo "Total: " . $total;
```

### Method 2: Using sum() Directly

```php
use App\Models\Commande;

$commande = Commande::with('produits')->find(1);

$total = $commande->produits->sum(function ($produit) {
    return $produit->pivot->quantite * $produit->pivot->prix;
});

echo "Total: " . $total;
```

---

## Example 7: Eager Loading (Performance Optimization)

### ❌ Bad - N+1 Problem

```php
use App\Models\Commande;

// This will cause N+1 queries
$commandes = Commande::all();

foreach ($commandes as $commande) {
    // Each loop = 1 additional query!
    foreach ($commande->produits as $produit) {
        echo $produit->designation;
    }
}
```

### ✅ Good - Eager Loading

```php
use App\Models\Commande;

// Only 2 queries total (1 for commandes, 1 for all related produits)
$commandes = Commande::with('produits')->get();

foreach ($commandes as $commande) {
    foreach ($commande->produits as $produit) {
        echo $produit->designation;
    }
}
```

**Explanation**: Always use `with()` to load relationships to avoid the N+1 query problem.

---

## Testing in Tinker

Run these examples in Laravel Tinker:

```bash
php artisan tinker
```

Then paste any example above to test it!

### Complete Test Scenario

```php
// 1. Create a client
$client = \App\Models\Client::create([
    'nom' => 'Test',
    'prenom' => 'User',
    'email' => 'test@example.com'
]);

// 2. Create products
$p1 = \App\Models\Produit::create([
    'designation' => 'Product A',
    'prix' => 100
]);

$p2 = \App\Models\Produit::create([
    'designation' => 'Product B',
    'prix' => 200
]);

// 3. Create commande
$commande = \App\Models\Commande::create([
    'client_id' => $client->id,
    'date' => now()
]);

// 4. Attach products
$commande->produits()->attach([
    $p1->id => ['quantite' => 2, 'prix' => 100],
    $p2->id => ['quantite' => 1, 'prix' => 200]
]);

// 5. Calculate total
$total = $commande->calculerTotal();
echo "Total: $total\n"; // Output: 400

// 6. View products
$commande->load('produits');
foreach ($commande->produits as $produit) {
    echo "{$produit->designation}: {$produit->pivot->quantite} x {$produit->pivot->prix}\n";
}
```

---

## API Testing with cURL

### Create a Commande

```bash
curl -X POST http://localhost:8000/api/v1/commandes \
  -H "Content-Type: application/json" \
  -d '{
    "client_id": 1,
    "date": "2024-01-15",
    "produits": [
      {"id": 1, "quantite": 2, "prix": 50},
      {"id": 2, "quantite": 1, "prix": 120}
    ]
  }'
```

### Get Commande Total

```bash
curl http://localhost:8000/api/v1/commandes/1/total
```

### Sync Products

```bash
curl -X POST http://localhost:8000/api/v1/commandes/1/sync-produits \
  -H "Content-Type: application/json" \
  -d '{
    "produits": [
      {"id": 1, "quantite": 3, "prix": 50},
      {"id": 3, "quantite": 2, "prix": 90}
    ]
  }'
```

---

## Common Patterns

### Check if Product Exists in Commande

```php
$commande = Commande::find(1);

if ($commande->produits->contains(2)) {
    echo "Product ID 2 is in this commande";
}
```

### Get Quantity of a Specific Product

```php
$commande = Commande::find(1);
$produit = $commande->produits()->find(1);

if ($produit) {
    echo "Quantity: " . $produit->pivot->quantite;
}
```

### Attach Only if Not Already Attached

```php
$commande = Commande::find(1);

if (!$commande->produits->contains(3)) {
    $commande->produits()->attach(3, [
        'quantite' => 1,
        'prix' => 75
    ]);
}
```
