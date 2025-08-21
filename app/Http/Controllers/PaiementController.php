<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Http\Controllers\Controller;
use App\Models\Vente;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Paiement::with(['user', 'vente'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'vente_id' => 'required|exists:ventes,id',
            'methode_de_paiement' => 'required', 
            'montant_total' => 'required', 
        ]);

        $paiement = Paiement::create($fields);
        $vente = $paiement->vente;
        $vente->status = 'finie';
        $vente->save();

        return $paiement;
    }
    
    public function ventesEnAttente()
{
    $ventes = Vente::with(['user', 'produits'])
                ->where('status', 'en attente')
                ->get();

    return response()->json($ventes);
}

    /**
     * Display the specified resource.
     */
    public function show(Paiement $paiement)
    {
        return ['paiement' => $paiement];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paiement $paiement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paiement $paiement)
    {
        //
    }
}
