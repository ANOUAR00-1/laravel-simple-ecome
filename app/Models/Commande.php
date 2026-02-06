<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commande extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'date',
        'statut',
        'notes',
        'archived_at',
    ];

    protected $casts = [
        'date' => 'date',
        'archived_at' => 'datetime',
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

    public function calculerTVA(float $taux = 20): float
    {
        return $this->calculerTotal() * ($taux / 100);
    }

    public function calculerTTC(float $taux = 20): float
    {
        return $this->calculerTotal() + $this->calculerTVA($taux);
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    public function canBeModified(): bool
    {
        return !$this->isArchived() && !in_array($this->statut, ['livree', 'annulee']);
    }
}
