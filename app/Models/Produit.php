<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Produit extends Model
{
    /** @use HasFactory<\Database\Factories\ProduitFactory> */
    use HasFactory;

const seuil = 3;
     protected $fillable = 
    [
        'nom',
        'description',
        'prix_unitaire',
        'niveau_en_stock',
        'categorie_id', 
        'image' 
    ];

    public function commandes()
{
    return $this->belongsToMany(Commande::class, 'lignedeCommandes')
                ->withPivot('quantite')
                ->withTimestamps();
}

    public function stock()
    {
       return $this->hasOne(Stock::class);
    }

    public function alerte()
    {
       return $this->hasMany(Alerte::class);
    }

    public function ventes()
    {
       return $this->belongsToMany(Vente::class, 'produit_ventes')
                    ->withPivot('quantite');
    }

     public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
}
