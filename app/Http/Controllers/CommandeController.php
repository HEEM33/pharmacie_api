<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Commande::with(['fournisseur', 'produit'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $fields = $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'produit_id' => 'required|exists:produits,id',  
        ]);

        $commande = Commande::create([ 'fournisseur_id' => $fields['fournisseur_id'],
        'produit_id' => $fields['produit_id'],
        'status' => 'en attente',]);

        return $commande;
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        return ['commande' => $commande];
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
