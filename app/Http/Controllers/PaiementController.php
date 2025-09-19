<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Http\Controllers\Controller;
use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $vente->status = 'paye';
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

    public function initMobilePayment(Request $request)
    {
        $response = Http::post("https://api-checkout.cinetpay.com/v2/payment", [
            "apikey" => env("CINETPAY_API_KEY"),
            "site_id" => env("CINETPAY_SITE_ID"),
            "transaction_id" => uniqid(),
            "amount" => $request->amount,
            "currency" => "XOF",
            "description" => "Paiement de la vente #" . $request->vente_id,
            "return_url" => url("/paiement/retour"),
            "notify_url" => url("/api/paiement/notify"),
            
        ]);

        return response()->json($response->json());
    }
}


