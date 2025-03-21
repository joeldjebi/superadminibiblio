<?php

namespace App\Http\Controllers;

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

class DeviseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les dévises';
        $data['menu'] ='devise';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["devises"] = Devise::orderBy('id', 'desc')->get();
        
        return view('donnees.devise',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'libelle' => 'required|string|unique:devises',
            'code_iso' => 'required|string|unique:devises',
            'symbole' => 'required|string|unique:devises',
            'taux' => 'required|string',
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
    
        $devise = new Devise();
        $devise->libelle = html_entity_decode($request->libelle);
        $devise->code_iso = html_entity_decode($request->code_iso);
        $devise->symbole = html_entity_decode($request->symbole);
        $devise->taux = html_entity_decode($request->taux);
    
        // Vérification si l'utilisateur a bien été créé
        if ($devise->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Devise créer avec succès');
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
                Rule::unique('devises')->ignore($id), // Ignore l'enregistrement actuel
            ],
            'code_iso' => [
                'required',
                'string',
                'max:20',
                Rule::unique('devises')->ignore($id), // Ignore l'enregistrement actuel
            ],
            'symbole' => [
                'required',
                'string',
                'max:20',
                Rule::unique('devises')->ignore($id), // Ignore l'enregistrement actuel
            ],
            'taux' => 'required|string',
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

        $devise = Devise::find($id);

        if (empty($devise)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Dévise introuvable');
            return back();
        }

        $devise->libelle = html_entity_decode($request->libelle);
        $devise->code_iso = html_entity_decode($request->code_iso);
        $devise->symbole = html_entity_decode($request->symbole);
        $devise->taux = html_entity_decode($request->taux);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($devise->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Dévise mis à jour avec succès');
            
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

        $devise = Devise::find($id);

        if ($devise) {
            $devise->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Dévise supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Dévise introuvable');
        }

        return back();
    }

}