<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $fields = $request->validate([
            'nom' => 'required',
            'description' => 'required',  
        ]);

        $categorie = Categorie::create($fields);

        return $categorie;
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
         $fields = $request->validate([
            'nom' => 'required',
            'description' => 'required',  
        ]);

        $categorie->update($fields);

        return $categorie;
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
