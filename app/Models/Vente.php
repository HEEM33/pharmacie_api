<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    /** @use HasFactory<\Database\Factories\VenteFactory> */
    use HasFactory;

     protected $fillable = 
    [
        'user_id',
        'total',
        'status'
    ];

    public function paiement()
    {
       return $this->hasMany(Paiement::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function produit()
    {
        return $this->belongsToMany(Produit::class)->withPivot('quantite');
    }
}
