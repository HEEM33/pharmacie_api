<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Categorie::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        $fields = $request->validate([
            'nom' => 'required',
            'description' => 'required',  
        ]);

        $categorie = Categorie::create($fields);

        return $categorie;
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
    public function show(Categorie $categorie)
    {
        return ['categorie' => $categorie];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        try{
         $fields = $request->validate([
            'nom' => 'required',
            'description' => 'required',  
        ]);

        $categorie->update($fields);

        return $categorie;
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
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();

        return ['message' => 'supprime'];
    }
}
