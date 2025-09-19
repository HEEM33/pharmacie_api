<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Produit_vente;
use App\Models\Stock;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();;

        $ventesDuJour = Vente::whereDate('created_at', $today)->count();

        $revenus = Vente::whereDate('created_at', $today)->sum('total');

        $produitsEnStock = Stock::count('produit_id');

        $produitsAlerte = Produit::where('niveau_en_stock', '<', 3) 
          //  ->orWhereDate('date_expiration', '<=', Carbon::today()->addDays(30)) 
            ->get();

        $ventesSemaine = Vente::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $transactionsRecentes = Vente::with(['produits', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($vente) {
        return [
            'id' => $vente->id,
            'total' => $vente->total,
            'date' => $vente->created_at->format('d/m/Y H:i'),
            'user' => $vente->user->name ?? 'Inconnu',
            'produits' => $vente->produits->map(function ($p) {
                return [
                    'id' => $p->id,
                    'nom' => $p->nom,
                    'quantite' => $p->pivot->quantite ?? 1,
                ];
            }),
        ];
    });

    $topProduits = Produit_vente::with('produit')
    ->selectRaw('produit_id, SUM(quantite) as quantite')
    ->groupBy('produit_id')
    ->orderByDesc('quantite')
    ->limit(3)
    ->get()
    ->map(function ($item) {
        return [
            'nom' => $item->produit->nom,
            'quantite' => $item->quantite,
        ];
    });

        return response()->json([
            "ventes_du_jour" => $ventesDuJour,
            "revenus" => $revenus,
            "stock" => $produitsEnStock,
            "alertes" => $produitsAlerte,
            "ventes_semaine" => $ventesSemaine,
            "transactionsRecentes" => $transactionsRecentes,
            "topProduits" => $topProduits
        ]);
    }
}
