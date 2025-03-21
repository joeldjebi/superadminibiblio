<?php

namespace App\Http\Controllers;

use App\Models\Type_publication;
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

class TypePublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les type de publication';
        $data['menu'] ='type_publication';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["type_publications"] = Type_publication::orderBy('id', 'desc')->get();
        
        return view('donnees.type_publication',$data);
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
    
        $type_publication = new Type_publication();
        $type_publication->libelle = html_entity_decode($request->libelle);
    
        // Vérification si l'utilisateur a bien été créé
        if ($type_publication->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Type publication créer avec succès');
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

        $type_publication = Type_publication::find($id);

        if (empty($type_publication)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Type publication introuvable');
            return back();
        }

        $type_publication->libelle = html_entity_decode($request->libelle);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($type_publication->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Type publication mis à jour avec succès');
            
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

        $type_publication = Type_publication::find($id);

        if ($type_publication) {
            $type_publication->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Type publication supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Type publication introuvable');
        }

        return back();
    }

}