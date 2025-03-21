<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
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

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les catégories de livre';
        $data['menu'] ='categorie_livre';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["categories"] = Categorie::orderBy('id', 'desc')->get();
        
        return view('donnees.categorie_livre',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'libelle' => 'required|string|unique:categories',
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
    
        $categorie = new Categorie();
        $categorie->libelle = html_entity_decode($request->libelle);
        $categorie->statut = 1;
    
        // Vérification si l'utilisateur a bien été créé
        if ($categorie->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Catégorie de livre créer avec succès');
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
                Rule::unique('categories')->ignore($id), // Ignore l'enregistrement actuel
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

        $categorie = Categorie::find($id);

        if (empty($categorie)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Catégorie introuvable');
            return back();
        }

        $categorie->libelle = html_entity_decode($request->libelle);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($categorie->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Catégorie mis à jour avec succès');
            
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

        $categorie = Categorie::find($id);

        if ($categorie) {
            $categorie->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Catégorie supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Catégorie introuvable');
        }

        return back();
    }

}