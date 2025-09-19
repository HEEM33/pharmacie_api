<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit_vente extends Model
{
    
    protected $table = 'produit_ventes';
    protected $fillable = [
        'produit_id',
        'vente_id',
        'quantite',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
