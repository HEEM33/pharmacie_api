<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Stock::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
        'produit_id' => 'required|exists:produits,id',
        'commande_id' => 'required|exists:fournisseurs,id',
        'quantite' => 'required|integer|min:1',
        
        ]);

         $entree = Stock::create($fields);

    $produit = Produit::find($fields['produit_id']);
    $produit->niveau_en_stock += $fields['quantite'];
    $produit->save();

    return response()->json([
        'message' => 'Entrée en stock enregistrée avec succès',
        'entree_stock' => $entree,
    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return ['stock' => $stock];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
