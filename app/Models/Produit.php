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
        'image', 
    ];

    public function ligneCommandes()
    {
        return $this->hasMany(Lignedecommande::class);
    }

    public function stock()
    {
       return $this->hasOne(Stock::class);
    }

    public function alerte()
    {
       return $this->hasMany(Alerte::class);
    }

    public function vente()
    {
       return $this->hasMany(Vente::class);
    }

     public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
