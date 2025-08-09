<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Fournisseur::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $fields = $request->validate([
            'nom' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',  
        ]);

        $fournisseur = Fournisseur::create($fields);

        return $fournisseur;
    }

    /**
     * Display the specified resource.
     */
    public function show(Fournisseur $fournisseur)
    {
        return ['fournisseur' => $fournisseur];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
         $fields = $request->validate([
            'nom' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',  
        ]);

        $fournisseur->update($fields);

        return $fournisseur;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();

        return ['message' => 'supprime'];
    }
}
