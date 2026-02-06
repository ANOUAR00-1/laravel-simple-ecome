<?php

namespace Database\Factories;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    public function definition(): array
    {
        $produits = [
            'Smartphone Samsung Galaxy' => [199.99, 999.99],
            'iPhone 15 Pro' => [899.99, 1299.99],
            'Laptop HP Pavilion' => [499.99, 899.99],
            'MacBook Air M2' => [999.99, 1499.99],
            'Écouteurs Bluetooth' => [29.99, 199.99],
            'Montre Connectée' => [49.99, 349.99],
            'Tablette Samsung' => [199.99, 699.99],
            'iPad Pro 12.9' => [799.99, 1199.99],
            'Clavier Mécanique' => [49.99, 149.99],
            'Souris Gaming' => [29.99, 99.99],
            'Casque Audio Sony' => [79.99, 299.99],
            'Enceinte Bluetooth JBL' => [39.99, 199.99],
            'Chargeur USB-C Rapide' => [19.99, 49.99],
            'Câble HDMI 4K' => [9.99, 29.99],
            'Webcam HD 1080p' => [39.99, 129.99],
            'Disque Dur Externe 1TB' => [49.99, 99.99],
            'Clé USB 128GB' => [14.99, 39.99],
            'Power Bank 20000mAh' => [29.99, 79.99],
            'Support Téléphone Voiture' => [9.99, 29.99],
            'Coque iPhone Protection' => [9.99, 39.99],
        ];

        $designation = fake()->randomElement(array_keys($produits));
        $priceRange = $produits[$designation];

        return [
            'category_id' => Category::inRandomOrder()->first()?->id,
            'designation' => $designation . ' ' . fake()->randomNumber(3),
            'prix' => fake()->randomFloat(2, $priceRange[0], $priceRange[1]),
            'description' => fake()->paragraph(2),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}
