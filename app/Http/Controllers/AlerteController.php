<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlerteController extends Controller
{
   
    
    public function index()
    {
    $faibleStock = Produit::where('niveau_en_stock', '<', Produit::seuil)->get();

    if ($faibleStock->isNotEmpty()) {
        foreach ($faibleStock as $produit) {
        }

        return response()->json([
            'message' => 'Certains produits ont un stock faible.',
            'produits' => $faibleStock
        ]);
    }

    return response()->json(['message' => 'Tous les stocks sont suffisants.']);
}
   
}
