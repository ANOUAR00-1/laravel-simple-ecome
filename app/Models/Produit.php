<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'designation',
        'prix',
        'description',
        'stock',
        'image',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class)
            ->withPivot('quantite', 'prix')
            ->withTimestamps();
    }
}
