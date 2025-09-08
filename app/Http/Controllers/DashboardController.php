<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();;

        $ventesDuJour = Vente::whereDate('created_at', $today)->count();

        $revenus = Vente::whereDate('created_at', $today)->sum('total');

        $produitsEnStock = Stock::count('produit_id');

        $produitsAlerte = Produit::where('niveau_en_stock', '<', 5) 
          //  ->orWhereDate('date_expiration', '<=', Carbon::today()->addDays(30)) 
            ->get();

        $ventesSemaine = Vente::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            "ventes_du_jour" => $ventesDuJour,
            "revenus" => $revenus,
            "stock" => $produitsEnStock,
            "alertes" => $produitsAlerte,
            "ventes_semaine" => $ventesSemaine,
        ]);
    }
}
