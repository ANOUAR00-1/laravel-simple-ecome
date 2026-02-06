<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Category;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 categories
        Category::factory(10)->create();

        // Create 20 clients
        Client::factory(20)->create();

        // Create 50 products
        Produit::factory(50)->create();

        // Create 30 orders with products
        $produits = Produit::all();

        Commande::factory(30)->create()->each(function ($commande) use ($produits) {
            // Attach 1-5 random products to each order
            $randomProduits = $produits->random(rand(1, 5));

            foreach ($randomProduits as $produit) {
                $commande->produits()->attach($produit->id, [
                    'quantite' => rand(1, 5),
                    'prix' => $produit->prix,
                ]);
            }
        });

        $this->command->info('✅ Seeding completed:');
        $this->command->info('   - 10 Categories');
        $this->command->info('   - 20 Clients');
        $this->command->info('   - 50 Products');
        $this->command->info('   - 30 Orders with products');
    }
}
