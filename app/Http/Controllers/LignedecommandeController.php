<?php

namespace App\Http\Controllers;

use App\Models\Lignedecommande;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLignedecommandeRequest;
use App\Http\Requests\UpdateLignedecommandeRequest;

class LignedecommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLignedecommandeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lignedecommande $lignedecommande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLignedecommandeRequest $request, Lignedecommande $lignedecommande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lignedecommande $lignedecommande)
    {
        //
    }
}
