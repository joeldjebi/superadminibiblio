<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Historique_achat_jeton;
use App\Models\Jeton;
use App\Models\Wallet_transaction;
use App\Models\Forfait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Redirector; 
use Session;
use App\Models\Super;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexTalent()
    {
        $data['title'] = "Historique d'achat de talent";
        $data['menu'] ='historique_achat_jeton';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["historique_achat_jetons"] = Historique_achat_jeton::orderBy('id', 'desc')
        ->with('user', 'jeton')
        ->get();
        // $encryptedTokens = Crypt::encryptString(100);
        // $decryptedTokens = Crypt::decryptString($encryptedTokens);
        // dd($encryptedTokens, $decryptedTokens);
        
        return view('transaction.jeton',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexAbonnement()
    {
        $data['title'] = "Historique des abonnement";
        $data['menu'] ='historique_abonnement';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["abonnements"] = Abonnement::orderBy('id', 'desc')
        ->with('user', 'forfait')
        ->get();
        
        return view('transaction.abonnement',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function indexAchatLivre()
    {
        $data['title'] = "Historique des achats de livre";
        $data['menu'] ='historique_achat_livre';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["wallet_transactions"] = Wallet_transaction::orderBy('id', 'desc')
        ->with('user', 'forfait', 'forfait.auteur', 'livre')
        ->get();
        
        return view('transaction.achat',$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Abonnement $abonnement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Abonnement $abonnement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Abonnement $abonnement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Abonnement $abonnement)
    {
        //
    }
}