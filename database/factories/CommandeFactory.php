<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommandeFactory extends Factory
{
    protected $model = Commande::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::inRandomOrder()->first()?->id ?? Client::factory(),
            'date' => fake()->dateTimeBetween('-3 months', 'now'),
            'statut' => fake()->randomElement(['en_attente', 'en_cours', 'livree', 'annulee']),
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }

    public function enAttente(): static
    {
        return $this->state(fn(array $attributes) => [
            'statut' => 'en_attente',
        ]);
    }

    public function enCours(): static
    {
        return $this->state(fn(array $attributes) => [
            'statut' => 'en_cours',
        ]);
    }

    public function livree(): static
    {
        return $this->state(fn(array $attributes) => [
            'statut' => 'livree',
        ]);
    }

    public function annulee(): static
    {
        return $this->state(fn(array $attributes) => [
            'statut' => 'annulee',
        ]);
    }
}
