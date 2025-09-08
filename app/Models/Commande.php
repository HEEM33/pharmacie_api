<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    /** @use HasFactory<\Database\Factories\CommandeFactory> */
    use HasFactory;

     protected $fillable = 
    [
        'fournisseur_id',
        'status'
        
    ];

     public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }


    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'lignedecommandes')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }
}
