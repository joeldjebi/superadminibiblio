<?php

namespace App\Http\Controllers;

use App\Models\Jeton;
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

class JetonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les jetons';
        $data['menu'] ='jeton';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["jetons"] = Jeton::orderBy('id', 'desc')->get();
        
        return view('donnees.jeton',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'piece' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }
    
        $jeton = new Jeton();
        $jeton->piece = html_entity_decode($request->piece);
        $jeton->amount = html_entity_decode($request->amount);
        $jeton->super_id = Auth::user()->id;
    
        // Vérification si l'utilisateur a bien été créé
        if ($jeton->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Jeton créer avec succès');
            return back();
            
        } else {
            // Flash error message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue');
            
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des champs
        $request->validate([
            'piece' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $jeton = Jeton::find($id);

        if (empty($jeton)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'jeton introuvable');
            return back();
        }

        $jeton->piece = html_entity_decode($request->piece);
        $jeton->amount = html_entity_decode($request->amount);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($jeton->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Jeton mis à jour avec succès');
            
            return back();
        } else {
            // Flash error message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue');
            
            return back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
            return back();
        }

        $jeton = Jeton::find($id);

        if ($jeton) {
            $jeton->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Jeton supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Jeton introuvable');
        }

        return back();
    }

}