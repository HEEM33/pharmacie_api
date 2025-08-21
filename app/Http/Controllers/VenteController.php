<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Vente::with(['user', 'produit'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $user = auth()->user();
         
         $fields = $request->validate([
            'produits' => 'required|array',
            'produits.*.id' => 'required|integer|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
            'produits.*.total' => 'required|integer'
             
        ]);

        $produits = $request->input('produits');

    foreach ($produits as $produit) {
        $produitModel = Produit::find($produit['id']);
        $stockModel = $produitModel->stock;

        if (!$stockModel || $stockModel->quantite < $produit['quantite']) {
            return response()->json([
                'message' => "Stock insuffisant pour le produit {$produitModel->nom}."
            ], 400);
        }
    }

        foreach ($produits as $produit) {
        $produitModel = Produit::find($produit['id']);
        $stockModel = $produitModel->stock;

        $stockModel->quantite -= $produit['quantite'];
        $stockModel->save();
    }

        $vente = Vente::create(['user_id' => $user->id, 'status' => 'en attente']);
         $vente->produits()->attach(
        collect($produits)->mapWithKeys(fn($p) => [$p['id'] => ['quantite' => $p['quantite']]])->toArray()
        );

        return $vente;
    }

    /**
     * Display the specified resource.
     */
    public function show(Vente $vente)
    {
        return ['vente' => $vente];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vente $vente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vente $vente)
    {
        //
    }
}
