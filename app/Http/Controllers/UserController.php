<?php

namespace App\Http\Controllers;

use App\Models\Devise;
use App\Models\Super;
use App\Models\User;
use App\Models\Wallet_transaction;
use App\Models\Livre;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Redirector;
use Session;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Liste des utilisateurs';
        $data['menu'] ='utilisateur';

        $data["user"] = Super::where([
            'id' => auth()->user()->id,
            'role' => 1
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        // Compter tous les utilisateurs
        $data['users'] = User::orderBy('id', 'desc')
        ->with('pays', 'pays.devise')
        ->get();

        return view('utilisateur.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($id)
    {
        $data['title'] = "Détaisl d'un utilisateur";
        $data['menu'] = 'utilisateur';

        $data["super"] = Super::where([
            'id' => auth()->user()->id,
            'role' => 1
        ])->first();

        if (empty($data['super'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
            return back();
        }

        $data['user'] = User::findOrFail($id);

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
            return back();
        }

        $data["livreAchetes"] = Wallet_transaction::where('user_id', $data['user']->id)
        ->with('livre', 'user')
        ->get();

        return view('utilisateur.show',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}