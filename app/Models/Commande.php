<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date',
        'statut',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class)
            ->withPivot('quantite', 'prix')
            ->withTimestamps();
    }

    public function calculerTotal(): float
    {
        return $this->produits->sum(function ($produit) {
            return $produit->pivot->quantite * $produit->pivot->prix;
        });
    }
}
