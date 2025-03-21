<?php

namespace App\Http\Controllers;

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

class ForfaitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les forfaits';
        $data['menu'] ='forfait';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["forfaits"] = Forfait::orderBy('id', 'desc')->get();
        
        return view('donnees.forfait',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'libelle' => 'required|string',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'duree' => 'required|numeric',
            'max_livres' => 'required|numeric',
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
    
        $forfait = new Forfait();
        $forfait->libelle = html_entity_decode($request->libelle);
        $forfait->description = html_entity_decode($request->description);
        $forfait->prix = html_entity_decode($request->prix);
        $forfait->duree = html_entity_decode($request->duree);
        $forfait->max_livres = html_entity_decode($request->max_livres);
    
        // Vérification si l'utilisateur a bien été créé
        if ($forfait->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Forfait créer avec succès');
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
            'libelle' => 'required|string',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'duree' => 'required|numeric',
            'max_livres' => 'required|numeric',
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

        $forfait = Forfait::find($id);

        if (empty($forfait)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Forfait introuvable');
            return back();
        }

        $forfait->libelle = html_entity_decode($request->libelle);
        $forfait->description = html_entity_decode($request->description);
        $forfait->prix = html_entity_decode($request->prix);
        $forfait->duree = html_entity_decode($request->duree);
        $forfait->max_livres = html_entity_decode($request->max_livres);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($forfait->save()) {
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

        $forfait = Forfait::find($id);

        if ($forfait) {
            $forfait->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Forfait supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Forfait introuvable');
        }

        return back();
    }

}