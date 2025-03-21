@include('layouts.header')
@include('layouts.menu')

@include('layouts.fileariane')

<div class="row show-livre-content">
    <div class="col-lg-12">
        <div class="card-title h5">{{ $livre->titre }}</div>
       <div class="row">
          <div class="col-md-2">
             <div class="card-icon-big mb-4 text-center card">
                <div class="card-body">
                   <i class="i-Data-Download"></i>
                   <p class="text-muted mt-2 mb-0 text-capitalize">Téléchargements</p>
                   <p class="lead text-18 mt-2 mb-0 text-capitalize">21</p>
                </div>
             </div>
          </div>
          <div class="col-md-2">
             <div class="card-icon-big mb-4 text-center card">
                <div class="card-body">
                   <i class="i-Add-User"></i>
                   <p class="text-muted mt-2 mb-0 text-capitalize">Utilisateurs</p>
                   <p class="lead text-18 mt-2 mb-0 text-capitalize">53</p>
                </div>
             </div>
          </div>
          <div class="col-md-2">
             <div class="card-icon-big mb-4 text-center card">
                <div class="card-body">
                   <i class="i-Money-2"></i>
                   <p class="text-muted mt-2 mb-0 text-capitalize">Achats</p>
                   <p class="lead text-18 mt-2 mb-0 text-capitalize">4031</p>
                </div>
             </div>
          </div>
          <div class="col-md-2">
             <div class="card-icon-big mb-4 text-center card">
                <div class="card-body">
                   <i class="i-Car-Coins"></i>
                   <p class="text-muted mt-2 mb-0 text-capitalize">Abonnement</p>
                   <p class="lead text-18 mt-2 mb-0 text-capitalize">4031</p>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>

@if(session()->has("message"))
    <div style="padding: 10px" class="alert {{session()->get('type')}}">{{ session()->get('message') }} </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($livre->file)

    @php
    $urlFile = !empty($livre->file->path) ? Storage::disk('wasabi')->temporaryUrl(
        $livre->file->path, now()->addMinutes(20)
    ) : null;
    @endphp

    <div class="container">
    <p><strong>Auteur:</strong> {{ $livre->auteur ? $livre->auteur->nom .' '. $livre->auteur->prenoms : 'Non spécifié' }}</p>
    <p><strong>Categorie:</strong> {{ $livre->categorie ? $livre->categorie->libelle : 'Non spécifié' }}</p>
    <p><strong>Éditeur:</strong> {{ $livre->editeur ? $livre->editeur->nom .' '. $livre->editeur->prenoms : 'Non spécifié' }}</p>
    <p><strong>Langue:</strong> {{ $livre->langue ? $livre->langue->libelle : 'Non spécifiée' }}</p>

    <h3>Description</h3>
    <p>{{ $livre->description }}</p>

    <h3>Fichier Associé</h3>
    <table class="table">
        <tr>
            <th>Fichier</th>
            <td>
                @if ($livre->file)
                    <a href="{{ $urlFile }}" target="_blank">Télécharger le fichier </a>
                @else
                    Pas de fichier associé
                @endif
            </td>
        </tr>
    </table>

    <h3>Informations Complémentaires</h3>
    <table class="table">
        <tr>
            <th>Type de Publication</th>
            <td>{{ $livre->type_publication ? $livre->type_publication->libelle : 'Non spécifié' }}</td>
        </tr>
        <tr>
            <th>Année de Publication</th>
            <td>{{ $livre->annee_publication }}</td>
        </tr>
        <tr>
            <th>Nombre de Pages</th>
            <td>{{ $livre->nombre_de_page }}</td>
        </tr>
        <tr>
            <th>Accès au Livre</th>
            <td>{{ $livre->acces_livre }}</td>
        </tr>
    </table>

    <h3>Autres informations</h3>
    <table class="table">
        <tr>
            <th>Mot Clé</th>
            <td>{{ $livre->mot_cle }}</td>
        </tr>
        <tr>
            <th>Lecture Cible</th>
            <td>{{ $livre->lecture_cible }}</td>
        </tr>
    </table>
    </div>
@endif

@if ($livre->episodes->isNotEmpty())
<div class="card text-left">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title mb-3">Les episodes</h4>
            </div>
            <div class="col-md-6 text-right">
                <a class="text-white mr-2 btn btn-primary" href="#" data-toggle="modal" data-target="#storeEpisode">
                    Ajouter un episode
                </a>
            </div>
        </div>
        @if(!empty($livre) )
            <div class="table-responsive">
                <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Couverture</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Prix (F CFA)</th>
                            <th scope="col">Type de publication</th>
                            <th scope="col">Taille</th>
                            <th scope="col">Fichier</th>
                            <th scope="col">Téléchargement</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($livre->episodes as $key => $item)

                            @php
                                // Génération de l'URL temporaire si l'URL de l'image existe
                                $urlPath = !empty($item->path) ? Storage::disk('wasabi')->temporaryUrl(
                                    $item->path, now()->addMinutes(20)
                                ) : null;

                                $imgCover = !empty($livre->image_cover_url) ? Storage::disk('wasabi')->temporaryUrl(
                                    $livre->image_cover_url, now()->addMinutes(20)
                                ) : null;

                                // Formatage du montant
                                if ($item && isset($livre->amount)) {
                                    $nombre_formate = number_format((float) $livre->amount, 0, '', ' ');
                                } else {
                                    $nombre_formate = 'N/A';
                                }
                            @endphp

                            <div class="modal fade" id="editEpisode{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modifier un épisode</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('livre.episode-update', ['livreId' => $item->livre_id, 'episodeId' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-md-12">
                                                    <div class="card-body" id="episodeContainer">
                                                        <div class="episode-section">
                                                            <div class="d-flex flex-column">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="titre_episode">Titre</label>
                                                                            <input class="form-control" type="text" name="titre_episode" value="{{ $item->titre }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="description_episode">Description</label>
                                                                            <textarea class="form-control" name="description_episode" id="description_episode" cols="10" rows="5">{!! html_entity_decode($item->description) !!}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="file_type_episode">Type de fichier</label>
                                                                            <select name="file_type_episode" class="form-control file_type" id="file_type_episode">
                                                                                <option value="upload" {{ $livre->file_type == "upload" ? 'selected' : '' }}>Télécharger</option>
                                                                                <option value="external_link" {{ $livre->file_type == "external_link" ? 'selected' : '' }}>Lien externe</option>
                                                                            </select>
                                                                        </div>
                                                                        <!-- Div pour le champ fichier -->
                                                                        <div id="file_group_episode" class="form-group upload_file">
                                                                            <label for="file_episode">Fichier</label>
                                                                            <input class="form-control" type="file" name="file_episode">
                                                                            @if (!empty($urlPath))
                                                                                <a href="{{ $urlPath }}" target="_blank">Écouter </a>
                                                                            @endif
                                                                        </div>
                                                                        <!-- Div pour le champ Lien externe -->
                                                                        <div id="link_group_episode" class="form-group external_link" style="display: none;">
                                                                            <label for="url_episode">Lien externe</label>
                                                                            <input class="form-control" type="text" name="url_episode">
                                                                            @if (!empty($livre->url))
                                                                                <a href="{{ $livre->url }}" target="_blank">Écouter </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermé</button>
                                                    <button class="btn btn-primary ml-2" type="submit">Modifier</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if (!empty($imgCover))
                                        <img src="{{ $imgCover }}" alt="Image" style="width:50px; height:auto;">
                                    @else
                                        <span>Pas d'image</span>
                                    @endif
                                </td>
                                <td>{{ $item->titre }}</td>
                                <td>{{ $nombre_formate }}</td>
                                <td>{{ $livre->type_publication->libelle }}</td>
                                <td>{{ $item->size ?? 'N/A' }}</td>
                                <td><a href="{{ $urlPath }}" target="_blank">Écouter </a></td>
                                <td>{{ $item->download ?? 0 }}</td>
                                <td style="display: inline-flex; border: none;">
                                    {{-- <a class="text-info mr-2" href="{{ route('livre.show', ['id' => $item->id]) }}">
                                        <i class="nav-icon i-Eye font-weight-bold"></i>
                                    </a> --}}
                                    <a class="text-success mr-2" href="#" data-toggle="modal" data-target="#editEpisode{{ $item->id }}">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                    </a>
                                    <!-- Bouton de suppression -->
                                    <button style="line-height: 0.5;" id="deleteEpisodeBtn_{{ $item->id }}" class="btn btn-danger" onclick="deleteEpisode({{ $item->id }}, {{ $item->livre_id }})">Supprimer</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            @else
                <p>Aucun livre enregistrer !</p>
        @endif
    </div>
</div>
@endif

@if ($livre->chapitres->isNotEmpty())  <!-- Vérification plus explicite -->
<div class="card text-left">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title mb-3">Les chapitres</h4>
            </div>
            <div class="col-md-6 text-right">
                <a class="text-white mr-2 btn btn-primary" href="#" data-toggle="modal" data-target="#storeChapitre">
                    Ajouter un chapitre
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Couverture</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Prix (F CFA)</th>
                        <th scope="col">Type de publication</th>
                        <th scope="col">Taille</th>
                        <th scope="col">Fichier</th>
                        <th scope="col">Téléchargement</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($livre->chapitres as $key => $item)
                        @php
                            // Génération de l'URL temporaire si l'URL de l'image existe
                            $urlPath = !empty($item->path) ? Storage::disk('wasabi')->temporaryUrl($item->path, now()->addMinutes(20)) : null;

                            $imgCover = !empty($livre->image_cover_url) ? Storage::disk('wasabi')->temporaryUrl($livre->image_cover_url, now()->addMinutes(20)) : null;

                            // Formatage du montant
                            $nombre_formate = isset($livre->amount) ? number_format((float) $livre->amount, 0, '', ' ') : 'N/A';
                        @endphp

                        <div class="modal fade" id="editChapitre{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modifier un épisode</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('livre.chapitre-update', ['livreId' => $item->livre_id, 'chapitreId' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-12">
                                                <div class="card-body" id="chapitreContainer">
                                                    <div class="chapitre-section">
                                                        <div class="d-flex flex-column">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="titre_chapitre">Titre</label>
                                                                        <input class="form-control" type="text" name="titre_chapitre" value="{{ $item->titre }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="description_chapitre">Description</label>
                                                                        <textarea class="form-control" name="description_chapitre" id="description_chapitre" cols="10" rows="5">{!! html_entity_decode($item->description) !!}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="file_type_chapitre">Type de fichier</label>
                                                                        <select name="file_type_chapitre" class="form-control file_type" id="file_type_chapitre">
                                                                            <option value="upload" {{ $livre->file_type == "upload" ? 'selected' : '' }}>Télécharger</option>
                                                                            <option value="external_link" {{ $livre->file_type == "external_link" ? 'selected' : '' }}>Lien externe</option>
                                                                        </select>
                                                                    </div>
                                                                    <!-- Div pour le champ fichier -->
                                                                    <div id="file_group_chapitre" class="form-group upload_file">
                                                                        <label for="file_chapitre">Fichier</label>
                                                                        <input class="form-control" type="file" name="file_chapitre">
                                                                        @if (!empty($urlPath))
                                                                            <a href="{{ $urlPath }}" target="_blank">Écouter </a>
                                                                        @endif
                                                                    </div>
                                                                    <!-- Div pour le champ Lien externe -->
                                                                    <div id="link_group_chapitre" class="form-group external_link" style="display: none;">
                                                                        <label for="url_chapitre">Lien externe</label>
                                                                        <input class="form-control" type="text" name="url_chapitre">
                                                                        @if (!empty($livre->url))
                                                                            <a href="{{ $livre->url }}" target="_blank">Écouter </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermé</button>
                                                <button class="btn btn-primary ml-2" type="submit">Modifier</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if ($imgCover)
                                    <img src="{{ $imgCover }}" alt="Image" style="width:50px; height:auto;">
                                @else
                                    <span>Aucune couverture disponible</span>
                                @endif
                            </td>
                            <td>{{ $item->titre }}</td>
                            <td>{{ $nombre_formate }}</td>
                            <td>{{ $livre->type_publication->libelle }}</td>
                            <td>{{ $item->size ?? 'N/A' }}</td>
                            <td>
                                @if ($urlPath)
                                    <a href="{{ $urlPath }}" target="_blank">Écouter</a>
                                @else
                                    <span>Aucun fichier disponible</span>
                                @endif
                            </td>
                            <td>{{ $item->download ?? 0 }}</td>
                            <td style="display: inline-flex; border: none;">
                                <a class="text-success mr-2" href="#" data-toggle="modal" data-target="#editChapitre{{ $item->id }}">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                                <!-- Bouton de suppression -->
                                <button style="line-height: 0.5;" id="deleteChapitreBtn_{{ $item->id }}" class="btn btn-danger" onclick="deleteChapitre({{ $item->id }}, {{ $item->livre_id }})">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="storeEpisode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un épisode</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('livre.episode-store', ['livreId' => $livre->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="card-body" id="episodeContainer">
                            <div class="episode-section">
                                <div class="d-flex flex-column">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="titre_episode">Titre</label>
                                                <input class="form-control" type="text" name="titre_episode">
                                            </div>
                                            <div class="form-group">
                                                <label for="description_episode">Description</label>
                                                <textarea class="form-control" name="description_episode" id="description_episode" cols="10" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="file_type_episode">Type de fichier</label>
                                                <select name="file_type_episode" class="form-control file_type" id="file_type_episode">
                                                    <option value="upload">Télécharger</option>
                                                    <option value="external_link">Lien externe</option>
                                                </select>
                                            </div>
                                            <!-- Div pour le champ fichier -->
                                            <div id="file_group_episode" class="form-group upload_file">
                                                <label for="file_episode">Fichier</label>
                                                <input class="form-control" type="file" name="file_episode">
                                            </div>
                                            <!-- Div pour le champ Lien externe -->
                                            <div id="link_group_episode" class="form-group external_link" style="display: none;">
                                                <label for="url_episode">Lien externe</label>
                                                <input class="form-control" type="text" name="url_episode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermé</button>
                        <button class="btn btn-primary ml-2" type="submit">Modifier</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="storeChapitre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un chapitre</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('livre.chapitre-store', ['livreId' => $livre->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="card-body" id="chapitreContainer">
                            <div class="chapitre-section">
                                <div class="d-flex flex-column">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="titre_chapitre">Titre</label>
                                                <input class="form-control" type="text" name="titre_chapitre">
                                            </div>
                                            <div class="form-group">
                                                <label for="description_chapitre">Description</label>
                                                <textarea class="form-control" name="description_chapitre" id="description_chapitre" cols="10" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="file_type_chapitre">Type de fichier</label>
                                                <select name="file_type_chapitre" class="form-control file_type" id="file_type_chapitre">
                                                    <option value="upload">Télécharger</option>
                                                    <option value="external_link">Lien externe</option>
                                                </select>
                                            </div>
                                            <!-- Div pour le champ fichier -->
                                            <div id="file_group_chapitre" class="form-group upload_file">
                                                <label for="file_chapitre">Fichier</label>
                                                <input class="form-control" type="file" name="file_chapitre">
                                            </div>
                                            <!-- Div pour le champ Lien externe -->
                                            <div id="link_group_chapitre" class="form-group external_link" style="display: none;">
                                                <label for="url_chapitre">Lien externe</label>
                                                <input class="form-control" type="text" name="url_chapitre">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermé</button>
                        <button class="btn btn-primary ml-2" type="submit">Modifier</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // Fonction pour supprimer un épisode via AJAX
    function deleteEpisode(episodeId, livreId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet épisode ?")) {
            // Requête AJAX pour supprimer l'épisode
            fetch(`/livre/${livreId}/episode/${episodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => {
                if (response.ok) {
                    // Si la suppression réussit, retirer l'épisode du DOM
                    document.getElementById(`episode_${episodeId}`).remove();
                    alert("Épisode supprimé avec succès.");
                } else {
                    alert("Erreur lors de la suppression de l'épisode.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Une erreur s'est produite.");
            });
        }
    }
</script>

<script>
// Ajoute un écouteur d'événement pour détecter les changements dans le select
document.getElementById('file_type_episode').addEventListener('change', function () {
    // Récupère les groupes de champs
    var fileGroup = document.getElementById('file_group_episode');
    var linkGroup = document.getElementById('link_group_episode');

    // Si 'Télécharger' est sélectionné, on affiche le champ de fichier
    if (this.value === 'upload') {
        fileGroup.style.display = 'block';
        linkGroup.style.display = 'none';
    }
    // Si 'Lien externe' est sélectionné, on affiche le champ de lien externe
    else if (this.value === 'external_link') {
        fileGroup.style.display = 'none';
        linkGroup.style.display = 'block';
    }
});

</script>

<script>
    // Fonction pour supprimer un épisode via AJAX
    function deleteChapitre(chapitreId, livreId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet chapitre ?")) {
            // Requête AJAX pour supprimer l'épisode
            fetch(`/livre/${livreId}/chapitre/${chapitreId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => {
                if (response.ok) {
                    // Si la suppression réussit, retirer l'épisode du DOM
                    document.getElementById(`chapitre_${chapitreId}`).remove();
                    alert("Épisode supprimé avec succès.");
                } else {
                    alert("Erreur lors de la suppression du chapitre.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Une erreur s'est produite.");
            });
        }
    }
</script>


@include('layouts.footer')
