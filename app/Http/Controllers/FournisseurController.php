<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        try{
         $fields = $request->validate([
            'nom' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',  
        ]);

        $fournisseur = Fournisseur::create($fields);

        return $fournisseur;
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
    public function show(Fournisseur $fournisseur)
    {
        return ['fournisseur' => $fournisseur];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        try{
         $fields = $request->validate([
            'nom' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',  
        ]);

        $fournisseur->update($fields);

        return $fournisseur;
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
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();

        return ['message' => 'supprime'];
    }
}
