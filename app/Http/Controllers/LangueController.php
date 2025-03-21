<?php

namespace App\Http\Controllers;

use App\Models\Langue;
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

class LangueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les langue';
        $data['menu'] ='langue';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["langues"] = Langue::orderBy('id', 'desc')->get();
        
        return view('donnees.langue',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'libelle' => 'required|string|unique:langues',
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
    
        $langue = new Langue();
        $langue->libelle = html_entity_decode($request->libelle);
    
        // Vérification si l'utilisateur a bien été créé
        if ($langue->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Langue créer avec succès');
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
                Rule::unique('langues')->ignore($id), // Ignore l'enregistrement actuel
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

        $langue = Langue::find($id);

        if (empty($langue)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Catégorie introuvable');
            return back();
        }

        $langue->libelle = html_entity_decode($request->libelle);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($langue->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Langue mis à jour avec succès');
            
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

        $langue = Langue::find($id);

        if ($langue) {
            $langue->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Langue supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Langue introuvable');
        }

        return back();
    }

}