<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Forfait;
use App\Models\Type_publication;
use App\Models\Categorie;
use App\Models\Auteur;
use App\Models\Wallet_transaction;
use App\Models\Editeur;
use App\Models\Episode;
use App\Models\Chapitre;
use App\Models\Pays;
use App\Models\File;
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
use Illuminate\Support\Facades\Storage;



class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les livres';
        $data['menu'] ='livre';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["livres"] = Livre::orderBy('id', 'desc')
        ->with('type_publication', 'auteur', 'categorie', 'editeur', 'episodes', 'chapitres', 'langue', 'file')
        ->get();

        // dd($data["livres"]);

        return view('livres.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] ='Les livres';
        $data['menu'] ='livre';

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
        $data["categories"] = Categorie::orderBy('id', 'desc')->get();
        $data["editeurs"] = Editeur::orderBy('id', 'desc')->get();
        $data["pays"] = Pays::orderBy('id', 'desc')->get();
        $data["langues"] = Langue::orderBy('id', 'desc')->get();

        $data["auteurs"] = Auteur::withoutTrashed()->orderBy('id', 'desc')->get();

        return view('livres.create', $data);
    }


    public function store(Request $request)
    {
        // dd($request->file_type_episode);
        // Validation des champs
        $request->validate([
            'type_publication_id' => 'required|numeric|exists:type_publications,id',
            'titre' => 'required|string|unique:livres',
            'auteur_id' => 'required|numeric|exists:auteurs,id',
            'categorie_id' => 'required|numeric|exists:categories,id',
            'mot_cle' => 'required|string',
            'annee_publication' => 'required|numeric',
            'lecture_cible' => 'required|string',
            'acces_livre' => 'required|string',
            'editeur_id' => 'required|numeric|exists:editeurs,id',
            'amount' => 'required|numeric',
            'pays_id' => 'required|numeric|exists:pays,id',
            'episode_id' => 'nullable|numeric|exists:episodes,id',
            'langue_id' => 'required|numeric',
            'vedette' => 'required|numeric',
            'nombre_de_page' => 'required|numeric',
            'breve_description' => 'required|string',
            'description' => 'required|string',
            'file_type' => 'nullable|string',
            'path_extrait' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:10240|unique:files',
            'paths' => 'nullable|array|file|mimes:jpg,jpeg,png,pdf,docx|max:10240',
            'url' => 'nullable|string',

            // Champs conditionnels pour Podcast
            'titre_episode.*' => $request->type_publication_id == 4 ? 'required|string' : 'nullable|string',
            'description_episode.*' => $request->type_publication_id == 4 ? 'required|string' : 'nullable|string',
            'file_type_episode.*' => $request->type_publication_id == 4 ? 'required|string' : 'nullable|string',
            'file_episode.*' => ($request->type_publication_id == 4 && $request->file_type_episode == 'upload')
                ? 'required|file'
                : 'nullable|file',
            'url_episode.*' => ($request->type_publication_id == 4 && $request->file_type_episode == 'external_link') ? 'required|string' : 'nullable|string',

            // Champs conditionnels pour Audio Book
            'titre_chapitre.*' => $request->type_publication_id == 3 ? 'required|string' : 'nullable|string',
            'description_chapitre.*' => $request->type_publication_id == 3 ? 'required|string' : 'nullable|string',
            'file_type_chapitre.*' => $request->type_publication_id == 3 ? 'required|string' : 'nullable|string',
            'file_chapitre.*' => ($request->type_publication_id == 3 && $request->file_type_chapitre == 'upload')
                ? 'required|file'
                : 'nullable|file',
            'url_chapitre.*' => ($request->type_publication_id == 3 && $request->file_type_chapitre == 'external_link') ? 'required|string' : 'nullable|string',

        ]);

        // Vérification de l'utilisateur
        $user = Super::where(['id' => Auth::id(), 'role' => 1])->first();
        if (!$user) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
            return back();
        }

        // Création du livre
        $livre = new Livre();
        $fields = [
            'type_publication_id', 'titre', 'auteur_id', 'categorie_id', 'mot_cle',
            'annee_publication', 'lecture_cible', 'acces_livre', 'editeur_id', 'amount',
            'pays_id', 'langue_id', 'vedette', 'nombre_de_page', 'breve_description',
            'description', 'file_type', 'edition_du_livre', 'image_cover', 'episode_id', 'url'
        ];

        foreach ($fields as $field) {
            $livre->$field = html_entity_decode($request->$field);
        }

        $livre->created_by = Auth::id();

        // Champs optionnels conditionnels
        $livre->episode_id = $request->filled('episode_id') ? $request->episode_id : null;
        $livre->chapitre_id = $request->filled('chapitre_id') ? $request->chapitre_id : null;

        $imageCover = $request->file('image_cover');
        $imageCovername = uniqid() . '.' . $imageCover->getClientOriginalExtension();
        $imageCoverPath = Storage::disk('wasabi')->putFileAs('image_cover_livre', $imageCover, $imageCovername);
        // Stocke seulement le chemin relatif de l'image
        $livre->image_cover_url = 'image_cover_livre/' . $imageCovername;
        $livre->image_cover = $imageCovername;


        // Sauvegarde du livre
        if ($livre->save()) {

            $livreLastSave = Livre::where('id', $livre->id)->first();

            // Gestion des fichiers optionnels
            $this->handleFileUploadPathExtrait($request->file('path_extrait'), 'path_extrait', $livre, $request);
            $this->handleFileUploadPaths($request->file('paths'), 'paths', $livre, $request);
            $this->handleFileUploadPath($request->file('path'), 'path', $livre, $request);

            // Vérification du type de publication pour les épisodes
            if ($request->type_publication_id == 4) {
                $this->handleEpisode(
                    $request->file_episode ?? [],
                    $request->url_episode ?? [],
                    'file_episode', // ou un autre répertoire si nécessaire
                    $livre,
                    $request
                );
            }

            // Vérification du type de publication pour les chapitres
            if ($request->type_publication_id == 3) {
                $this->handleChapitre(
                    $request->file_chapitre ?? [],
                    $request->url_chapitre ?? [],
                    'file_chapitre', // ou un autre répertoire si nécessaire
                    $livre,
                    $request
                );
            }

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Livre créé avec succès');
            return back();
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue');
            return back();
        }
    }

    protected function handleFileUploadPathExtrait($file, $directory, $livre, $request)
    {
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);

            $fileRecord = new File();
            $fileRecord->titre = $request->titre;
            $fileRecord->description = $request->description;
            $fileRecord->filename = $filename;
            $fileRecord->disk = 'wasabi';
            $fileRecord->extension = $file->getClientOriginalExtension();
            $fileRecord->mime = $file->getMimeType();
            $fileRecord->size = $file->getSize();
            $fileRecord->download = 0;
            $fileRecord->path = $filePath;
            $fileRecord->url = $fileUrl;
            $fileRecord->path_extrait = $filePath;
            $fileRecord->livre_id = $livre->id;
            $fileRecord->auteur_id = $request->auteur_id;

            if ($fileRecord->save()) {
                $fileLastSave = File::where('filename', $filename)->first();
                if ($fileLastSave) {
                    // Directly update the livre instance
                    $livre->file_id = $fileLastSave->id;
                    $livre->save();
                }
            }

        }
    }

    protected function handleFileUploadPaths($files, $directory, $livre, $request)
    {
        if ($files && is_array($files)) {
            foreach ($files as $file) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
                $fileUrl = Storage::disk('wasabi')->url($filePath);

                $fileRecord = new File();
                $fileRecord->titre = $request->titre;
                $fileRecord->description = $request->description;
                $fileRecord->filename = $filename;
                $fileRecord->disk = 'wasabi';
                $fileRecord->extension = $file->getClientOriginalExtension();
                $fileRecord->mime = $file->getMimeType();
                $fileRecord->size = $file->getSize();
                $fileRecord->download = 0;
                $fileRecord->path = $filePath;
                $fileRecord->url = $fileUrl;
                $fileRecord->livre_id = $livre->id;
                $fileRecord->auteur_id = $request->auteur_id;

                if ($fileRecord->save()) {
                    $fileLastSave = File::where('filename', $filename)->first();
                    if ($fileLastSave) {
                        // Directement mettre à jour l'instance livre si nécessaire
                        $livre->file_id = $fileLastSave->id;
                        $livre->save();
                    }
                }
            }
        }
    }

    protected function handleFileUploadPath($file, $directory, $livre, $request)
    {
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);

            $fileRecord = new File();
            $fileRecord->titre = $request->titre;
            $fileRecord->description = $request->description;
            $fileRecord->filename = $filename;
            $fileRecord->disk = 'wasabi';
            $fileRecord->extension = $file->getClientOriginalExtension();
            $fileRecord->mime = $file->getMimeType();
            $fileRecord->size = $file->getSize();
            $fileRecord->download = 0;
            $fileRecord->path = $filePath;
            $fileRecord->url = $fileUrl;
            $fileRecord->livre_id = $livre->id;
            $fileRecord->auteur_id = $request->auteur_id;

            if ($fileRecord->save()) {
                $fileLastSave = File::where('filename', $filename)->first();
                if ($fileLastSave) {
                    // Directly update the livre instance
                    $livre->file_id = $fileLastSave->id;
                    $livre->save();
                }
            }

        }
    }

    protected function handleEpisode($files, $urls, $directory, $livre, $request)
    {
        $titles = $request->titre_episode;
        $descriptions = $request->description_episode;
        $count = count($titles);

        for ($i = 0; $i < $count; $i++) {
            // Traitement des fichiers d'upload
            if (isset($files[$i])) {
                $file = $files[$i];
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
                $fileUrl = Storage::disk('wasabi')->url($filePath);

                $fileRecord = new Episode();
                $fileRecord->titre = $titles[$i];
                $fileRecord->description = $descriptions[$i];
                $fileRecord->filename = $filename;
                $fileRecord->disk = 'wasabi';
                $fileRecord->extension = $file->getClientOriginalExtension();
                $fileRecord->mime = $file->getMimeType();
                $fileRecord->size = $file->getSize();
                $fileRecord->download = 0;
                $fileRecord->path = $filePath;
                $fileRecord->url = $fileUrl;
                $fileRecord->livre_id = $livre->id;
                $fileRecord->auteur_id = $request->auteur_id;

                if (!$fileRecord->save()) {
                    session()->flash('type', 'alert-danger');
                    session()->flash('message', 'Une erreur est survenue');
                    return back();
                }

                $livre->episode_id = $fileRecord->id;
                $livre->save();
            }

            // Traitement des liens externes
            if (isset($urls[$i])) {
                $fileRecord = new Episode();
                $fileRecord->titre = $titles[$i];
                $fileRecord->description = $descriptions[$i];
                $fileRecord->filename = uniqid();
                $fileRecord->disk = 'link';
                $fileRecord->extension = "url";
                $fileRecord->url = $urls[$i];
                $fileRecord->path = $urls[$i];
                $fileRecord->livre_id = $livre->id;
                $fileRecord->auteur_id = $request->auteur_id;

                if (!$fileRecord->save()) {
                    session()->flash('type', 'alert-danger');
                    session()->flash('message', 'Une erreur est survenue');
                    return back();
                }

                $livre->episode_id = $fileRecord->id;
                $livre->save();
            }
        }
    }

    protected function handleChapitre($files, $urls, $directory, $livre, $request)
    {
        $titles = $request->titre_chapitre;
        $descriptions = $request->description_chapitre;
        $count = count($titles);

        for ($i = 0; $i < $count; $i++) {
            // Traitement des fichiers d'upload
            if (isset($files[$i])) {
                $file = $files[$i];
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
                $fileUrl = Storage::disk('wasabi')->url($filePath);

                $fileRecord = new Chapitre();
                $fileRecord->titre = $titles[$i];
                $fileRecord->description = $descriptions[$i];
                $fileRecord->filename = $filename;
                $fileRecord->disk = 'wasabi';
                $fileRecord->extension = $file->getClientOriginalExtension();
                $fileRecord->mime = $file->getMimeType();
                $fileRecord->size = $file->getSize();
                $fileRecord->download = 0;
                $fileRecord->path = $filePath;
                $fileRecord->url = $fileUrl;
                $fileRecord->livre_id = $livre->id;
                $fileRecord->auteur_id = $request->auteur_id;

                if (!$fileRecord->save()) {
                    session()->flash('type', 'alert-danger');
                    session()->flash('message', 'Une erreur est survenue');
                    return back();
                }

                $livre->chapitre_id = $fileRecord->id;
                $livre->save();
            }

            // Traitement des liens externes
            if (isset($urls[$i])) {
                $fileRecord = new Chapitre();
                $fileRecord->titre = $titles[$i];
                $fileRecord->description = $descriptions[$i];
                $fileRecord->filename = uniqid();
                $fileRecord->disk = 'link';
                $fileRecord->extension = "url";
                $fileRecord->url = $urls[$i];
                $fileRecord->path = $urls[$i];
                $fileRecord->livre_id = $livre->id;
                $fileRecord->auteur_id = $request->auteur_id;

                if (!$fileRecord->save()) {
                    session()->flash('type', 'alert-danger');
                    session()->flash('message', 'Une erreur est survenue');
                    return back();
                }

                $livre->chapitre_id = $fileRecord->id;
                $livre->save();
            }
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['title'] = 'Détails du livre';
        $data['menu'] = 'livre';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data['livre'] = Livre::where('id', $id)
            ->with(['auteur', 'episodes', 'chapitres', 'file', 'type_publication', 'categorie', 'editeur', 'langue', 'createdBy'])
            ->first();

        // Vous n'avez pas besoin de vérifier si file est null ici, car cela se fait dans la vue
        return view('livres.show', $data);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $data['title'] ='Mise a jour des livres';
        $data['menu'] ='livre-edit';

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
        $data["categories"] = Categorie::orderBy('id', 'desc')->get();
        $data["editeurs"] = Editeur::orderBy('id', 'desc')->get();
        $data["pays"] = Pays::orderBy('id', 'desc')->get();
        $data["langues"] = Langue::orderBy('id', 'desc')->get();

        $data["auteurs"] = Auteur::withoutTrashed()->orderBy('id', 'desc')->get();

        $data["livre"] = Livre::where(['id' => $id])
        ->with('file')
        ->first();

        $data["files"] = File::where(['livre_id' => $data["livre"]->id])->get();


        return view('livres.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // Rechercher le livre
        $livre = Livre::findOrFail($id);

        // Validation des champs (mêmes règles que pour le store, avec certaines modifications pour le titre unique)
        $request->validate([
            // 'type_publication_id' => 'required|numeric|exists:type_publications,id',
            'titre' => [
                'required',
                'string',
                Rule::unique('livres', 'titre')->ignore($id)
            ],
            'auteur_id' => 'required|numeric|exists:auteurs,id',
            'categorie_id' => 'required|numeric|exists:categories,id',
            'mot_cle' => 'required|string',
            'annee_publication' => 'required|numeric',
            'lecture_cible' => 'required|string',
            'acces_livre' => 'required|string',
            'editeur_id' => 'required|numeric|exists:editeurs,id',
            'amount' => 'required|numeric',
            'pays_id' => 'required|numeric|exists:pays,id',
            'episode_id' => 'nullable|numeric|exists:episodes,id',
            'langue_id' => 'required|numeric',
            'vedette' => 'required|numeric',
            'nombre_de_page' => 'required|numeric',
            'breve_description' => 'required|string',
            'description' => 'required|string',
            'file_type' => 'nullable|string',
            'path_extrait' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:10240|unique:files,path_extrait,' . $id,
            'paths' => 'nullable|array|file|mimes:jpg,jpeg,png,pdf,docx|max:10240',
            'url' => 'nullable|string',

            // Champs conditionnels pour Podcast et Audio Book (comme dans le store)
            'titre_episode.*' => $request->type_publication_id == 4 ? 'required|string' : 'nullable|string',
            'description_episode.*' => $request->type_publication_id == 4 ? 'required|string' : 'nullable|string',
            'file_type_episode.*' => $request->type_publication_id == 4 ? 'required|string' : 'nullable|string',
            'file_episode.*' => ($request->type_publication_id == 4 && $request->file_type_episode == 'upload') ? 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:10240' : 'nullable|file',
            'url_episode.*' => ($request->type_publication_id == 4 && $request->file_type_episode == 'external_link') ? 'required|string' : 'nullable|string',
            'titre_chapitre.*' => $request->type_publication_id == 3 ? 'required|string' : 'nullable|string',
            'description_chapitre.*' => $request->type_publication_id == 3 ? 'required|string' : 'nullable|string',
            'file_type_chapitre.*' => $request->type_publication_id == 3 ? 'required|string' : 'nullable|string',
            'file_chapitre.*' => ($request->type_publication_id == 3 && $request->file_type_chapitre == 'upload') ? 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:10240' : 'nullable|file',
            'url_chapitre.*' => ($request->type_publication_id == 3 && $request->file_type_chapitre == 'external_link') ? 'required|string' : 'nullable|string',

            'image_cover' => $livre->image_cover ? 'nullable|file|mimes:jpg,jpeg,png|max:10240' : 'required|file|mimes:jpg,jpeg,png|max:10240',

        ]);

        // Vérification de l'utilisateur
        $user = Super::where(['id' => Auth::id(), 'role' => 1])->first();
        if (!$user) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
            return back();
        }

        $fields = [
            // 'type_publication_id',
            'titre', 'auteur_id', 'categorie_id', 'mot_cle',
            'annee_publication', 'lecture_cible', 'acces_livre', 'editeur_id', 'amount',
            'pays_id', 'langue_id', 'vedette', 'nombre_de_page', 'breve_description',
            'description', 'file_type', 'edition_du_livre', 'image_cover', 'episode_id', 'url'
        ];

        foreach ($fields as $field) {
            if ($request->filled($field)) {
                $livre->$field = html_entity_decode($request->$field);
            }
        }

        // Gestion de l'image de couverture
        if ($request->hasFile('image_cover')) {
            $imageCover = $request->file('image_cover');
            $imageCovername = uniqid() . '.' . $imageCover->getClientOriginalExtension();
            $imageCoverPath = Storage::disk('wasabi')->putFileAs('image_cover_livre', $imageCover, $imageCovername);
            $livre->image_cover_url = 'image_cover_livre/' . $imageCovername;
            $livre->image_cover = $imageCovername;
        }

        // Sauvegarde du livre
        if ($livre->save()) {

            // Mise à jour des fichiers optionnels
            $this->handleFileUploadPathExtraitUpdate($request->file('path_extrait'), 'path_extrait', $livre, $request);
            $this->handleFileUploadPathsUpdate($request->file('paths'), 'paths', $livre, $request);
            $this->handleFileUploadPathUpdate($request->file('path'), 'path', $livre, $request);

            // Gestion des épisodes ou chapitres selon le type de publication
            if ($request->type_publication_id == 4) {
                $this->handleEpisodeUpdate(
                    $request->file_episode ?? [],
                    $request->url_episode ?? [],
                    'file_episode', // ou un autre répertoire si nécessaire
                    $livre,
                    $request
                );
            }

            if ($request->type_publication_id == 3) {
                $this->handleChapitreUpdate(
                    $request->file_chapitre ?? [],
                    $request->url_chapitre ?? [],
                    'file_chapitre', // ou un autre répertoire si nécessaire
                    $livre,
                    $request
                );
            }

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Livre mis à jour avec succès');
            return back();
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue');
            return back();
        }
    }

    protected function handleFileUploadPathExtraitUpdate($file, $directory, $livre, $request)
    {
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);

            // Mettre à jour le fichier existant ou en créer un nouveau
            $fileRecord = File::firstOrNew(['id' => $livre->file_id]);
            $fileRecord->fill([
                'titre' => $request->titre,
                'description' => $request->description,
                'filename' => $filename,
                'disk' => 'wasabi',
                'extension' => $file->getClientOriginalExtension(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $filePath,
                'url' => $fileUrl,
                'path_extrait' => $filePath,
                'livre_id' => $livre->id,
                'auteur_id' => $request->auteur_id
            ]);

            if ($fileRecord->save()) {
                $livre->file_id = $fileRecord->id;
                $livre->save();
            }
        }
    }

    protected function handleFileUploadPathsUpdate($files, $directory, $livre, $request)
    {
        if ($files && is_array($files)) {
            foreach ($files as $file) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
                $fileUrl = Storage::disk('wasabi')->url($filePath);

                $fileRecord = File::firstOrNew(['livre_id' => $livre->id, 'filename' => $filename]);
                $fileRecord->fill([
                    'titre' => $request->titre,
                    'description' => $request->description,
                    'disk' => 'wasabi',
                    'extension' => $file->getClientOriginalExtension(),
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'path' => $filePath,
                    'url' => $fileUrl,
                    'auteur_id' => $request->auteur_id
                ]);

                $fileRecord->save();
            }
        }
    }

    protected function handleFileUploadPathUpdate($file, $directory, $livre, $request)
    {
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);

            $fileRecord = File::firstOrNew(['id' => $livre->file_id]);
            $fileRecord->fill([
                'titre' => $request->titre,
                'description' => $request->description,
                'filename' => $filename,
                'disk' => 'wasabi',
                'extension' => $file->getClientOriginalExtension(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $filePath,
                'url' => $fileUrl,
                'livre_id' => $livre->id,
                'auteur_id' => $request->auteur_id
            ]);

            if ($fileRecord->save()) {
                $livre->file_id = $fileRecord->id;
                $livre->save();
            }
        }
    }

    protected function handleEpisodeUpdate($files, $urls, $directory, $livre, $request)
    {
        $titles = $request->titre_episode;
        $descriptions = $request->description_episode;
        $count = count($titles);

        for ($i = 0; $i < $count; $i++) {
            if (isset($files[$i])) {
                $file = $files[$i];
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
                $fileUrl = Storage::disk('wasabi')->url($filePath);

                $fileRecord = Episode::firstOrNew(['livre_id' => $livre->id, 'filename' => $filename]);
                $fileRecord->fill([
                    'titre' => $titles[$i],
                    'description' => $descriptions[$i],
                    'disk' => 'wasabi',
                    'extension' => $file->getClientOriginalExtension(),
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'path' => $filePath,
                    'url' => $fileUrl,
                    'auteur_id' => $request->auteur_id
                ]);

                $fileRecord->save();
                $livre->episode_id = $fileRecord->id;
                $livre->save();
            }

            if (isset($urls[$i])) {
                $fileRecord = Episode::firstOrNew(['livre_id' => $livre->id, 'url' => $urls[$i]]);
                $fileRecord->fill([
                    'titre' => $titles[$i],
                    'description' => $descriptions[$i],
                    'filename' => uniqid(),
                    'disk' => 'link',
                    'extension' => "url",
                    'path' => $urls[$i],
                    'auteur_id' => $request->auteur_id
                ]);

                $fileRecord->save();
                $livre->episode_id = $fileRecord->id;
                $livre->save();
            }
        }
    }

    protected function handleChapitreUpdate($files, $urls, $directory, $livre, $request)
    {
        $titles = $request->titre_chapitre;
        $descriptions = $request->description_chapitre;
        $count = count($titles);

        for ($i = 0; $i < $count; $i++) {
            if (isset($files[$i])) {
                $file = $files[$i];
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
                $fileUrl = Storage::disk('wasabi')->url($filePath);

                $fileRecord = Chapitre::firstOrNew(['livre_id' => $livre->id, 'filename' => $filename]);
                $fileRecord->fill([
                    'titre' => $titles[$i],
                    'description' => $descriptions[$i],
                    'disk' => 'wasabi',
                    'extension' => $file->getClientOriginalExtension(),
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'path' => $filePath,
                    'url' => $fileUrl,
                    'auteur_id' => $request->auteur_id
                ]);

                $fileRecord->save();
                $livre->chapitre_id = $fileRecord->id;
                $livre->save();
            }

            if (isset($urls[$i])) {
                $fileRecord = Chapitre::firstOrNew(['livre_id' => $livre->id, 'url' => $urls[$i]]);
                $fileRecord->fill([
                    'titre' => $titles[$i],
                    'description' => $descriptions[$i],
                    'filename' => uniqid(),
                    'disk' => 'link',
                    'extension' => "url",
                    'path' => $urls[$i],
                    'auteur_id' => $request->auteur_id
                ]);

                $fileRecord->save();
                $livre->chapitre_id = $fileRecord->id;
                $livre->save();
            }
        }
    }

    protected function handleEpisodeUpdateOnly(Request $request, $livre_id, $episode_id)
    {
        $titles = $request->titre_episode;
        $descriptions = $request->description_episode;
        $fileType = $request->file_type_episode;
        $files = $request->file('file_episode'); // Récupère les fichiers téléchargés
        $urls = $request->input('url_episode'); // Récupère les URLs externes

        // Vérifier que le livre existe
        $livre = Livre::find($livre_id);
        if (empty($livre)) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Livre introuvable');
            return back();
        }

        // Vérifier que l'épisode existe
        $episode = Episode::find($episode_id);
        if (empty($episode)) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Episode introuvable');
            return back();
        }

        // Traitement du cas où le type de fichier est "upload" (téléchargement)
        if ($fileType === 'upload' && $files && $files->isValid()) {

            // Supprimer l'ancien fichier sur Wasabi s'il existe
            if ($episode->disk === 'wasabi' && !empty($episode->path)) {
                Storage::disk('wasabi')->delete($episode->path);
            }

            $file = $files;
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs('file_episode', $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);

            // Mise à jour de l'épisode avec les informations du fichier
            $episode->fill([
                'titre' => $titles,
                'description' => $descriptions,
                'disk' => 'wasabi',
                'extension' => $file->getClientOriginalExtension(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $filePath,
                'url' => $fileUrl,
            ]);

            $episode->save();
            $livre->episode_id = $episode->id;
            $livre->save();

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Episode mis a jour avec succès');
            return back();

        }
        // Traitement du cas où le type de fichier est "external_link" (lien externe)
        elseif ($fileType === 'external_link' && !empty($urls)) {
            // Mise à jour de l'épisode avec l'URL externe
            $episode->fill([
                'titre' => $titles,
                'description' => $descriptions,
                'filename' => uniqid(),
                'disk' => 'link',
                'extension' => "url",
                'path' => $urls,
            ]);

            $episode->save();
            $livre->episode_id = $episode->id;
            $livre->save();

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Episode mis a jour avec succès');
            return back();

        } else {
            // Cas où aucun fichier ni URL n'est fourni
            $episode->fill([
                'titre' => $titles,
                'description' => $descriptions,
            ]);

            $episode->save();
            $livre->episode_id = $episode->id;
            $livre->save();

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Episode mis a jour avec succès');
            return back();

        }
    }

    protected function handleEpisodeStoreOnly(Request $request, $livre_id)
    {
        $titles = $request->titre_episode;
        $descriptions = $request->description_episode;
        $fileType = $request->file_type_episode;
        $files = $request->file('file_episode'); // Récupère les fichiers téléchargés
        $urls = $request->input('url_episode'); // Récupère les URLs externes

        // Vérifier que le livre existe
        $livre = Livre::find($livre_id);
        if (empty($livre)) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Livre introuvable');
            return back();
        }

        // Vérifier que le type de fichier est bien présent et valide
        if (!$fileType || !in_array($fileType, ['upload', 'external_link'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Le type de fichier est requis et doit être valide (upload ou external_link)');
            return back();
        }

        // Créer un nouvel épisode
        $episode = new Episode();

        // Traitement du cas où le type de fichier est "upload" (téléchargement)
        if ($fileType === 'upload' && $files && $files->isValid()) {
            $file = $files;
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs('file_episode', $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);

            // Enregistrement du nouvel épisode avec les informations du fichier
            $episode->fill([
                'titre' => $titles,
                'description' => $descriptions,
                'disk' => 'wasabi',
                'extension' => $file->getClientOriginalExtension(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $filePath,
                'url' => $fileUrl,
            ]);
        }
        // Traitement du cas où le type de fichier est "external_link" (lien externe)
        elseif ($fileType === 'external_link' && !empty($urls)) {
            // Enregistrement du nouvel épisode avec l'URL externe
            $episode->fill([
                'titre' => $titles,
                'description' => $descriptions,
                'filename' => uniqid(),
                'disk' => 'link',
                'extension' => "url",
                'path' => $urls,
            ]);
        } else {
            // Si aucun fichier ni URL valide n'est fourni, retourner une erreur
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Un fichier ou une URL valide est requis.');
            return back();
        }

        // Sauvegarder l'épisode et associer au livre
        $episode->livre_id = $livre->id;
        $episode->auteur_id = $livre->auteur_id;
        $episode->save();
        $livre->episode_id = $episode->id;
        $livre->save();

        session()->flash('type', 'alert-success');
        session()->flash('message', 'Nouvel épisode créé avec succès');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyEpisode($livreId, $episodeId)
    {
        // Trouver le livre et l'épisode
        $livre = Livre::findOrFail($livreId);
        $episode = $livre->episodes()->findOrFail($episodeId);

        // Supprimer l'épisode
        $episode->delete();

        // Retourner une réponse de succès
        return response()->json(['message' => 'Épisode supprimé avec succès.']);
    }

    protected function handleChapitreUpdateOnly(Request $request, $livre_id, $chapitre_id)
    {
        $titles = $request->titre_chapitre;
        $descriptions = $request->description_chapitre;
        $fileType = $request->file_type_chapitre;
        $files = $request->file('file_chapitre'); // Récupère les fichiers téléchargés
        $urls = $request->input('url_chapitre'); // Récupère les URLs externes

        // Vérifier que le livre existe
        $livre = Livre::find($livre_id);
        if (empty($livre)) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Livre introuvable');
            return back();
        }

        // Vérifier que l'épisode existe
        $chapitre = Chapitre::find($chapitre_id);
        if (empty($chapitre)) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Chapitre introuvable');
            return back();
        }

        // Traitement du cas où le type de fichier est "upload" (téléchargement)
        if ($fileType === 'upload' && $files && $files->isValid()) {

            // Supprimer l'ancien fichier sur Wasabi s'il existe
            if ($chapitre->disk === 'wasabi' && !empty($chapitre->path)) {
                Storage::disk('wasabi')->delete($chapitre->path);
            }

            $file = $files;
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs('file_chapitre', $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);

            // Mise à jour du chapitre avec les informations du fichier
            $chapitre->fill([
                'titre' => $titles,
                'description' => $descriptions,
                'disk' => 'wasabi',
                'extension' => $file->getClientOriginalExtension(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $filePath,
                'url' => $fileUrl,
            ]);

            $chapitre->save();
            $livre->chapitre_id = $chapitre->id;
            $livre->save();

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Chapitre mis a jour avec succès');
            return back();

        }
        // Traitement du cas où le type de fichier est "external_link" (lien externe)
        elseif ($fileType === 'external_link' && !empty($urls)) {
            // Mise à jour de l'épisode avec l'URL externe
            $chapitre->fill([
                'titre' => $titles,
                'description' => $descriptions,
                'filename' => uniqid(),
                'disk' => 'link',
                'extension' => "url",
                'path' => $urls,
            ]);

            $chapitre->save();
            $livre->chapitre_id = $chapitre->id;
            $livre->save();

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Chapitre mis a jour avec succès');
            return back();

        } else {
            // Cas où aucun fichier ni URL n'est fourni
            $chapitre->fill([
                'titre' => $titles,
                'description' => $descriptions,
            ]);

            $chapitre->save();
            $livre->chapitre_id = $chapitre->id;
            $livre->save();

            session()->flash('type', 'alert-success');
            session()->flash('message', 'Chapitre mis a jour avec succès');
            return back();

        }
    }

    protected function handleChapitreStoreOnly(Request $request, $livre_id)
    {
        $titles = $request->titre_chapitre;
        $descriptions = $request->description_chapitre;
        $fileType = $request->file_type_chapitre;
        $files = $request->file('file_chapitre'); // Récupère les fichiers téléchargés
        $urls = $request->input('url_chapitre'); // Récupère les URLs externes

        // Vérifier que le livre existe
        $livre = Livre::find($livre_id);
        if (empty($livre)) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Livre introuvable');
            return back();
        }

        // Vérifier que le type de fichier est bien présent et valide
        if (!$fileType || !in_array($fileType, ['upload', 'external_link'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Le type de fichier est requis et doit être valide (upload ou external_link)');
            return back();
        }

        // Créer un nouvel épisode
        $chapitre = new Chapitre();

        // Traitement du cas où le type de fichier est "upload" (téléchargement)
        if ($fileType === 'upload' && $files && $files->isValid()) {
            $file = $files;
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs('file_chapitre', $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);

            // Enregistrement du nouvel épisode avec les informations du fichier
            $chapitre->fill([
                'titre' => $titles,
                'description' => $descriptions,
                'disk' => 'wasabi',
                'extension' => $file->getClientOriginalExtension(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $filePath,
                'url' => $fileUrl,
            ]);
        }
        // Traitement du cas où le type de fichier est "external_link" (lien externe)
        elseif ($fileType === 'external_link' && !empty($urls)) {
            // Enregistrement du nouvel épisode avec l'URL externe
            $chapitre->fill([
                'titre' => $titles,
                'description' => $descriptions,
                'filename' => uniqid(),
                'disk' => 'link',
                'extension' => "url",
                'path' => $urls,
            ]);
        } else {
            // Si aucun fichier ni URL valide n'est fourni, retourner une erreur
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Un fichier ou une URL valide est requis.');
            return back();
        }

        // Sauvegarder l'épisode et associer au livre
        $chapitre->livre_id = $livre->id;
        $chapitre->auteur_id = $livre->auteur_id;
        $chapitre->save();
        $livre->chapitre_id = $chapitre->id;
        $livre->save();

        session()->flash('type', 'alert-success');
        session()->flash('message', 'Nouvel chapitre créé avec succès');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyChapitre($livreId, $chapitreId)
    {
        // Trouver le livre et l'épisode
        $livre = Livre::findOrFail($livreId);
        $chapitre = $livre->chapitres()->findOrFail($chapitreId);

        // Supprimer l'épisode
        $chapitre->delete();

        // Retourner une réponse de succès
        return response()->json(['message' => 'Épisode supprimé avec succès.']);
    }
/**
     * Display a listing of the resource.
     */
    public function indexLivreAchete()
    {
        $data['title'] ='Les livres achetés';
        $data['menu'] ='livre';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["livreAchetes"] = Wallet_transaction::orderBy('id', 'desc')
        ->with('livre', 'user')
        ->get();

        return view('livres.livreachete',$data);
    }


}