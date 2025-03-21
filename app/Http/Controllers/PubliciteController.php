<?php

namespace App\Http\Controllers;

use App\Models\Publicite;
use App\Models\Livre;
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

class PubliciteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les publicites';
        $data['menu'] ='publicites';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["publicites"] = Publicite::orderBy('id', 'desc')
        ->with('livre')
        ->get();

        // dd($data["publicites"]);
        
        $data["livres"] = Livre::orderBy('id', 'desc')->get();
        
        return view('publicite.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'livre_id' => 'required|string|exists:livres,id',
            'description' => 'required|string',
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
    
        $publicite = new Publicite();
        $publicite->livre_id = html_entity_decode($request->livre_id);
        $publicite->description = html_entity_decode($request->description);
    
        // Vérification si l'utilisateur a bien été créé
        if ($publicite->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Publicité créer avec succès');
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
                'string'
            ],
            'livre_id' => [
                'required',
                'string',
                'max:20',
                Rule::unique('publicites')->ignore($id), // Ignore l'enregistrement actuel
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

        $publicite = Publicite::find($id);

        if (empty($publicite)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Publicité introuvable');
            return back();
        }

        $publicite->livre_id = html_entity_decode($request->livre_id);
        $publicite->description = html_entity_decode($request->description);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($publicite->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Publicité mis à jour avec succès');
            
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

        $publicite = Publicite::find($id);

        if ($publicite) {
            $publicite->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Publicité supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Publicité introuvable');
        }

        return back();
    }

}