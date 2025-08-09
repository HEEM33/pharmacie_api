<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lignedecommande extends Model
{
    /** @use HasFactory<\Database\Factories\LignedecommandeFactory> */
    use HasFactory;

    protected $fillable=
    [
        'commande_id',
        'produit_id',
    ];

     public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
