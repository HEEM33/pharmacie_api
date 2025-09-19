<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Commande::with(['fournisseur', 'produits'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
         $fields = $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'items' => 'required|array|min:1',
            'items.*.produit_id' => 'required|exists:produits,id',
            'items.*.quantite' => 'required|integer|min:1',  
        ]);

        $commande = Commande::create([ 'fournisseur_id' => $fields['fournisseur_id'],
        'status' => 'en attente',]);

         foreach ($fields['items'] as $item) {
            $commande->produits()->attach($item['produit_id'], [
                'quantite' => $item['quantite'],
            ]);
         }

        return $commande->load('fournisseur', 'produits');
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
    public function show(Commande $commande)
    {
        return $commande->load('fournisseur', 'produits');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
