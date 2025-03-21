<?php

namespace App\Http\Controllers;

use App\Models\Editeur;
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

class EditeurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les éditeurs';
        $data['menu'] ='editeur';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["editeurs"] = Editeur::orderBy('id', 'desc')->get();
        
        return view('donnees.editeur',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'nom' => 'required|string',
            'prenoms' => 'required|string',
            'mobile' => 'required|string|unique:editeurs',
            'email' => 'required|string|unique:editeurs',
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
    
        $editeur = new Editeur();
        $editeur->nom = html_entity_decode($request->nom);
        $editeur->prenoms = html_entity_decode($request->prenoms);
        $editeur->mobile = html_entity_decode($request->mobile);
        $editeur->email = html_entity_decode($request->email);
    
        // Vérification si l'utilisateur a bien été créé
        if ($editeur->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Éditeur créer avec succès');
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
            'nom' => 'required|string',
            'prenoms' => 'required|string',
            'mobile' => [
                'required',
                'string',
                'max:20',
                Rule::unique('editeurs')->ignore($id), // Ignore l'enregistrement actuel
            ],
            'email' => [
                'required',
                'string',
                'max:20',
                Rule::unique('editeurs')->ignore($id), // Ignore l'enregistrement actuel
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

        $editeur = Editeur::find($id);

        if (empty($editeur)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Catégorie introuvable');
            return back();
        }

        $editeur->nom = html_entity_decode($request->nom);
        $editeur->prenoms = html_entity_decode($request->prenoms);
        $editeur->mobile = html_entity_decode($request->mobile);
        $editeur->email = html_entity_decode($request->email);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($editeur->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Éditeur mis à jour avec succès');
            
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

        $editeur = Editeur::find($id);

        if ($editeur) {
            $editeur->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Éditeur supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Éditeur introuvable');
        }

        return back();
    }

}