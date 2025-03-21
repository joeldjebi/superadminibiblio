<?php

namespace App\Http\Controllers;

use App\Models\Paroleforte;
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

class ParoleForteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les parôles fortes';
        $data['menu'] ='Parolefortes';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["parolefortes"] = Paroleforte::orderBy('id', 'desc')->get();
        
        return view('paroleforte.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'description' => 'required|string|unique:Parolefortes',
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
    
        $paroleforte = new Paroleforte();
        $paroleforte->description = html_entity_decode($request->description);
    
        // Vérification si l'utilisateur a bien été créé
        if ($paroleforte->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Parole forte créer avec succès');
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
            'description' => [
                'required',
                'string',
                Rule::unique('parolefortes')->ignore($id), // Ignore l'enregistrement actuel
            ]
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

        $paroleforte = Paroleforte::find($id);

        if (empty($paroleforte)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Parole forte introuvable');
            return back();
        }

        $paroleforte->description = html_entity_decode($request->description);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($paroleforte->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Parole forte mis à jour avec succès');
            
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

        $paroleforte = Paroleforte::find($id);

        if ($paroleforte) {
            $paroleforte->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Parole forte supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Parole forte introuvable');
        }

        return back();
    }

}