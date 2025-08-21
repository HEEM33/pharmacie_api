<?php

use App\Http\Controllers\AlerteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/roles', function() {
    return Role::all();
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

Route::apiResource('categorie', CategorieController::class);
Route::apiResource('commande', CommandeController::class);
Route::apiResource('fournisseur', FournisseurController::class);
Route::apiResource('paiement', PaiementController::class);
Route::apiResource('produit', ProduitController::class);
Route::apiResource('stock', StockController::class);
Route::apiResource('vente', VenteController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('alerte', AlerteController::class);
Route::get('/ventes-en-attente', [PaiementController::class, 'ventesEnAttente']);

});