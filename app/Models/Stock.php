<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;

     protected $fillable = 
    [
        'quantite',
        'produit_id',
    ];

     public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
