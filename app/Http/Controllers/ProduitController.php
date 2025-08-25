<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Produit::with('categorie')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
         $fields = $request->validate([
            'nom' => 'required', 
            'description' => 'required',
            'prix_unitaire' => 'required',
            'niveau_en_stock' => 'required',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'required|file|mimes:jpeg,png,jpg',
             
        ]);
         $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products/'), $filename);
           $fields['image'] = $filename;
        }

        $produit = Produit::create($fields);
        $qrCode = QrCode::size(300)->generate("Produit ID: " . $produit->id);

         return response()->json([
            'produit' => $produit,
            'qrCode' => $qrCode
        ], 201);

    } catch (ValidationException $e) {
        return response()->json([
            'errors' => $e->errors()
        ], 422);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        return ['produit' => $produit];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
         $fields = $request->validate([
            'nom' => 'required', 
            'description' => 'required',
            'prix_unitaire' => 'required',
            'niveau_en_stock' => 'required',
            'categorie_id' => 'required|exists:categories,id', 
            'image' => 'required|file'
        ]);

         if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('produits', 'public');
        $fields['image'] = $imagePath;
        }
        $produit->update($fields);

        return $produit;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $produit->delete();

        return ['message' => 'supprime'];
    }

}
