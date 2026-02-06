<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            'Électronique' => 'Appareils électroniques, gadgets et accessoires',
            'Vêtements' => 'Mode homme, femme et enfant',
            'Maison & Jardin' => 'Décoration, meubles et outillage',
            'Sport' => 'Équipements et accessoires sportifs',
            'Alimentation' => 'Produits alimentaires et boissons',
            'Beauté' => 'Cosmétiques et soins personnels',
            'Livres' => 'Livres, magazines et papeterie',
            'Jouets' => 'Jeux et jouets pour enfants',
            'Auto & Moto' => 'Pièces et accessoires automobiles',
            'Informatique' => 'Ordinateurs, périphériques et logiciels',
        ];

        $nom = fake()->unique()->randomElement(array_keys($categories));

        return [
            'nom' => $nom,
            'description' => $categories[$nom],
        ];
    }
}
