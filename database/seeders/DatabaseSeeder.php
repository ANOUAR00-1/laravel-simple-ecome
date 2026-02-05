<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample clients
        $client1 = Client::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean.dupont@example.com',
            'telephone' => '0612345678',
            'adresse' => '123 Rue de Paris, 75001 Paris',
        ]);

        $client2 = Client::create([
            'nom' => 'Martin',
            'prenom' => 'Marie',
            'email' => 'marie.martin@example.com',
            'telephone' => '0687654321',
            'adresse' => '456 Avenue des Champs, 69001 Lyon',
        ]);

        $client3 = Client::create([
            'nom' => 'Bernard',
            'prenom' => 'Pierre',
            'email' => 'pierre.bernard@example.com',
            'telephone' => '0698765432',
            'adresse' => '789 Boulevard de la Mer, 13001 Marseille',
        ]);

        // Create sample categories
        $electronique = Category::create([
            'nom' => 'Électronique',
            'description' => 'Produits électroniques et informatiques',
        ]);

        $accessoires = Category::create([
            'nom' => 'Accessoires',
            'description' => 'Accessoires informatiques',
        ]);

        $peripheriques = Category::create([
            'nom' => 'Périphériques',
            'description' => 'Périphériques pour ordinateur',
        ]);

        // Create sample products
        $produit1 = Produit::create([
            'category_id' => $electronique->id,
            'designation' => 'Ordinateur portable',
            'prix' => 899.99,
            'description' => 'Ordinateur portable haute performance',
            'stock' => 25,
        ]);

        $produit2 = Produit::create([
            'category_id' => $accessoires->id,
            'designation' => 'Souris sans fil',
            'prix' => 29.99,
            'description' => 'Souris ergonomique sans fil',
            'stock' => 100,
        ]);

        $produit3 = Produit::create([
            'category_id' => $peripheriques->id,
            'designation' => 'Clavier mécanique',
            'prix' => 89.99,
            'description' => 'Clavier mécanique RGB',
            'stock' => 50,
        ]);

        $produit4 = Produit::create([
            'category_id' => $electronique->id,
            'designation' => 'Écran 24 pouces',
            'prix' => 199.99,
            'description' => 'Écran Full HD 24 pouces',
            'stock' => 30,
        ]);

        $produit5 = Produit::create([
            'category_id' => $accessoires->id,
            'designation' => 'Webcam HD',
            'prix' => 59.99,
            'description' => 'Webcam 1080p avec microphone',
            'stock' => 45,
        ]);

        // Create sample commandes with products
        $commande1 = Commande::create([
            'client_id' => $client1->id,
            'date' => now()->subDays(5),
            'statut' => 'livree',
            'notes' => 'Livraison rapide demandée',
        ]);

        // Attach products to commande1 (Example from screenshot #1)
        $commande1->produits()->attach([
            $produit1->id => ['quantite' => 2, 'prix' => 899.99],
            $produit2->id => ['quantite' => 2, 'prix' => 29.99],
        ]);

        $commande2 = Commande::create([
            'client_id' => $client2->id,
            'date' => now()->subDays(2),
            'statut' => 'en_cours',
            'notes' => null,
        ]);

        $commande2->produits()->attach([
            $produit3->id => ['quantite' => 1, 'prix' => 89.99],
            $produit4->id => ['quantite' => 1, 'prix' => 199.99],
            $produit5->id => ['quantite' => 1, 'prix' => 59.99],
        ]);

        $commande3 = Commande::create([
            'client_id' => $client3->id,
            'date' => now(),
            'statut' => 'en_attente',
            'notes' => 'Client préfère la livraison en point relais',
        ]);

        $commande3->produits()->attach([
            $produit1->id => ['quantite' => 1, 'prix' => 899.99],
            $produit4->id => ['quantite' => 2, 'prix' => 199.99],
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('Created:');
        $this->command->info('- 3 Categories');
        $this->command->info('- 3 Clients');
        $this->command->info('- 5 Produits');
        $this->command->info('- 3 Commandes with products');
    }
}
