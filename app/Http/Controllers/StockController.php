<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Stock::with('produit')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        $fields = $request->validate([
        'produit_id' => 'required|exists:produits,id',
        'commande_id' => 'required|exists:commandes,id',
        'quantite' => 'required|integer|min:1',
        
        ]);

       $entree = Stock::where('produit_id', $fields['produit_id'])->first();

    if ($entree) {
        $entree->quantite += $fields['quantite'];
        $entree->commande_id = $fields['commande_id'];
        $entree->save();
    } else {
        $entree = Stock::create($fields);
    }

    $produit = Produit::find($fields['produit_id']);
    $produit->niveau_en_stock += $fields['quantite'];
    $produit->save();
    
    $commande = Commande::with('produits')->findOrFail($fields['commande_id']);
    $produitsCommandes = $commande->produits()->withPivot('quantite')->get();

    $produitsRecus = Stock::where('commande_id', $commande->id)
        ->selectRaw('produit_id, SUM(quantite) as total')
        ->groupBy('produit_id')
        ->pluck('total', 'produit_id');

    $allRecus = true;
    foreach ($produitsCommandes as $pc) {
        $qteCommandee = $pc->pivot->quantite;
        $qteRecue = $produitsRecus[$pc->id] ?? 0;
        if ($qteRecue < $qteCommandee) {
            $allRecus = false;
            break;
        }
    }

    if ($allRecus) {
        $commande->status = 'Recu';
        $commande->save();
    }

    return response()->json([
        'message' => 'Entrée en stock enregistrée avec succès',
        'entree_stock' => $entree,
    ]);
     } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Une erreur est survenue',
            'error' => $e->getMessage()
        ], 500);
    }
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
        $stock->delete();

        return response()->json(['message' => 'Stock supprimé avec succès'], 200);
    }
}
