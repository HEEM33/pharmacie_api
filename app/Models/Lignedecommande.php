<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lignedecommande extends Model
{
    /** @use HasFactory<\Database\Factories\LignedecommandeFactory> */
    use HasFactory;
    protected $table = 'lignedecommandes';
    protected $fillable=
    [
        'commande_id',
        'produit_id',
        'quantite',
    ];

}
