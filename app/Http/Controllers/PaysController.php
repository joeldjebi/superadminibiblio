<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\Devise;
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

class PaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les pays';
        $data['menu'] ='pays';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["pays"] = pays::orderBy('id', 'desc')
        ->with('devise')
        ->get();
        
        $data["devises"] = Devise::orderBy('id', 'desc')->get();
        
        return view('donnees.pays',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'libelle' => 'required|string|unique:pays',
            'indicatif' => 'required|string|unique:pays',
            'devise_id' => 'required|string|exists:devises,id',
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
    
        $pays = new Pays();
        $pays->libelle = html_entity_decode($request->libelle);
        $pays->indicatif = html_entity_decode($request->indicatif);
        $pays->devise_id = html_entity_decode($request->devise_id);
    
        // Vérification si l'utilisateur a bien été créé
        if ($pays->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Pays créer avec succès');
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
            'libelle' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pays')->ignore($id), // Ignore l'enregistrement actuel
            ],
            'indicatif' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pays')->ignore($id), // Ignore l'enregistrement actuel
            ],
            'devise_id' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pays')->ignore($id), // Ignore l'enregistrement actuel
            ],
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

        $pays = Pays::find($id);

        if (empty($pays)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Dévise introuvable');
            return back();
        }

        $pays->libelle = html_entity_decode($request->libelle);
        $pays->indicatif = html_entity_decode($request->indicatif);
        $pays->devise_id = html_entity_decode($request->devise_id);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($pays->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Pays mis à jour avec succès');
            
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

        $pays = Pays::find($id);

        if ($pays) {
            $pays->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Pays supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Pays introuvable');
        }

        return back();
    }

}