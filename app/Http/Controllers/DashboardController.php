<?php

namespace App\Http\Controllers;

use App\Models\Super;
use App\Models\User;
use App\Models\Abonnement;
use App\Models\Livre;
use App\Models\Wallet_transaction;
use App\Models\Devise;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Redirector;
use Session;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $data['title'] ='Tableau de bord';
        $data['menu'] ='dashboard';

        $data["user"] = Super::where([
            'id' => auth()->user()->id,
            'role' => 01
        ])->first();

        // Compter tous les utilisateurs
        $data['totalUsers'] = User::count();

        $data['totalLivre'] = Livre::count();

        $data['totalWalletTransaction'] = Wallet_transaction::count();

        $data['totalAbonnement'] = Abonnement::count();

        $data['totalAmountBuyLivre'] = DB::table('wallet_transactions')->sum('montant');

        $data['sales'] = DB::table('wallet_transactions')
        ->select(
            DB::raw('MONTH(date_transaction) as month'),
            DB::raw('SUM(montant) as total'),
            DB::raw('COUNT(*) as total_sales')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $data['salesByCountry'] = DB::table('wallet_transactions')
        ->join('livres', 'wallet_transactions.livre_id', '=', 'livres.id')
        ->join('pays', 'livres.pays_id', '=', 'pays.id')
        ->select('pays.libelle as country', DB::raw('COUNT(wallet_transactions.id) as total_sales'))
        ->groupBy('pays.libelle')
        ->get();

        $data["livreAchetes"] = Wallet_transaction::orderBy('id', 'desc')
        ->with('livre', 'user')
        ->get();

        return view('dashboard',$data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}