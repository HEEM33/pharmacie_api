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
        'date_commande',
        'fournisseur_id',
        
    ];

     public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

     public function lignes()
    {
        return $this->hasMany(Lignedecommande::class);
    }
}
