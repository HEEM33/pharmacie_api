<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    /** @use HasFactory<\Database\Factories\AlerteFactory> */
    use HasFactory;

     protected $fillable = 
    [
        'date',
        'message',
        'produit_id',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
