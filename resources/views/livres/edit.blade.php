@php
    // Génération de l'URL temporaire si l'URL de l'image cover livre existe
    $urlImageCoverUrl = !empty($livre->image_cover_url) ? Storage::disk('wasabi')->temporaryUrl(
        $livre->image_cover_url, now()->addMinutes(20)
    ) : null;

    $urlFile = !empty($livre->file->path) ? Storage::disk('wasabi')->temporaryUrl(
        $livre->file->path, now()->addMinutes(20)
    ) : null;

    $urlFileExtrait = !empty($livre->file->path_extrait) ? Storage::disk('wasabi')->temporaryUrl(
        $livre->file->path_extrait, now()->addMinutes(20)
    ) : null;

@endphp

@include('layouts.header')
@include('layouts.menu')

@include('layouts.fileariane')


    <div class="row">
        <div class="col-lg-12 col-md-12">
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
            <h4 class="mb-3">Ajouter un livre</h4>
            <form action="{{ route('livre.update', ['id' => $livre->id ]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title">Informations</div>
                        <div class="d-flex flex-column">
                            <div class="form-group">
                                <label for="">Type de publication</label>
                                <select disabled class="form-control" name="type_publication_id"  id="typePublicationSelect">
                                    @foreach ($type_publications as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $livre->type_publication_id ? 'selected' : '' }}>{{ $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Titre du livre</label>
                                        <input class="form-control" name="titre" type="text" value="{{ $livre->titre }}">
                                    </div>
                                </div>
                                @if(isset($auteurs) && $auteurs->count() > 0)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Auteur</label>
                                            <select class="form-control" name="auteur_id">
                                                @foreach ($auteurs as $auteur)
                                                    <option value="{{ $auteur->id }}" {{ $auteur->id == $livre->auteur_id ? 'selected' : '' }}>{{ $auteur->nom }} {{ $auteur->prenoms }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <p>Aucun auteur disponible.</p>
                                @endif

                            </div>
                            <div class="row">
                                @if(isset($categories) && $categories->count() > 0)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Catégorie du livre</label>
                                            <select class="form-control" name="categorie_id">
                                                @foreach ($categories as $categorie)
                                                    <option value="{{ $categorie->id }}" {{ $categorie->id == $livre->categorie_id ? 'selected' : '' }}>{{ $categorie->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <p>Aucune catégotie disponible.</p>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Mot clé</label>
                                        <input id="" class="form-control" name="mot_cle" type="text" value="{{ $livre->mot_cle }}">
                                        <p class="text-muted"><font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">
                                            Mettez les virgules vous permet d'ajouter d'autres mots</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Année de publication</label>
                                        <input class="form-control" name="annee_publication" type="number" value="{{ $livre->annee_publication }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Lecteur cible</label>
                                        <input id="" class="form-control" name="lecture_cible" type="text" value="{{ $livre->lecture_cible }}">
                                        <p class="text-muted"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                            Mettez les virgules vous permet d'ajouter d'autres mots</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Accès au livre</label>
                                        <select class="form-control" name="acces_livre">
                                            <option value="gratuit" {{ $livre->acces_livre == 'gratuit' ? 'selected' : '' }}>Gratuit</option>
                                            <option value="achat" {{ $livre->acces_livre == 'achat' ? 'selected' : '' }}>Achat</option>
                                            <option value="abonnement" {{ $livre->acces_livre == 'abonnement' ? 'selected' : '' }}>Abonnement</option>
                                            <option value="achat_et_abonnement" {{ $livre->acces_livre == 'achat_et_abonnement' ? 'selected' : '' }}>Achat et Abonnement</option>
                                        </select>
                                    </div>
                                </div>
                                @if(isset($editeurs) && $editeurs->count() > 0)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Éditeur</label>
                                            <select class="form-control" name="editeur_id">
                                                @foreach ($editeurs as $editeur)
                                                    <option value="{{ $editeur->id }}" {{ $editeur->id == $livre->editeur_id ? 'selected' : '' }}>{{ $editeur->nom }} {{ $editeur->prenoms }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <p>Aucun éditeur disponible.</p>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Prix du livre en F CFA</label>
                                        <input class="form-control" name="amount" type="number" value="{{ $livre->amount }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Édition du livre</label>
                                        <input class="form-control" name="edition_du_livre" type="text" value="{{ $livre->edition_du_livre }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if(isset($pays) && $pays->count() > 0)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Pays d'origine</label>
                                            <select class="form-control" name="pays_id">
                                                @foreach ($pays as $country)
                                                    <option value="{{ $country->id }}" {{ $country->id == $livre->pays_id ? 'selected' : '' }}>{{ $country->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <p>Aucun pays disponible.</p>
                                @endif
                                @if(isset($langues) && $langues->count() > 0)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Langue du livre</label>
                                            <select class="form-control" name="langue_id">
                                                @foreach ($langues as $langue)
                                                    <option value="{{ $langue->id }}" {{ $langue->id == $livre->langue_id ? 'selected' : '' }}>{{ $langue->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <p>Aucun langue disponible.</p>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">En vedette</label>
                                        <select class="form-control" name="vedette" required>
                                            <option value="1" {{ $livre->vedette == 1 ? 'selected' : '' }}>Oui</option>
                                            <option value="0" {{ $livre->vedette == 0 ? 'selected' : '' }}>Non</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nombre de page</label>
                                        <input class="form-control" name="nombre_de_page" type="number" required value="{{ $livre->nombre_de_page }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Couverture du livre</label>
                                        <input class="form-control" name="image_cover" type="file">
                                        <img src="{{ $urlImageCoverUrl }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title">Description</div>
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Brève Description</label>
                                        <textarea class="form-control" name="breve_description" id="" cols="10" rows="2">{{ $livre->breve_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea class="form-control" name="description" id="" cols="30" rows="5">{{ $livre->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if (!empty($files) && count($files) > 0)
                    <div class="card mb-3" id="livreAndMagazineContent">
                        <div class="card-body">
                            <div class="card-title">Fichier du livre</div>
                            <div class="d-flex flex-column">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="file_type">Type de fichier</label>
                                            <select name="file_type" class="form-control custom-select-black" id="file_type">
                                                <option value="upload" {{ $livre->file_type == 'upload' ? 'selected' : '' }}>Télécharger</option>
                                                <option value="audio" {{ $livre->file_type == 'audio' ? 'selected' : '' }}>Plusieurs fichiers audio</option>
                                                <option value="external_link" {{ $livre->file_type == 'external_link' ? 'selected' : '' }}>Lien externe</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="path_extrait">Extrait</label>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <input class="form-control" type="file" name="path_extrait" id="path_extrait">
                                                    @if (!empty($urlFileExtrait))
                                                        <a href="{{ $urlFileExtrait }}" target="_blank" rel="noopener noreferrer">

                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="path">Fichier</label>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <input class="form-control" type="file" name="path" id="path">
                                                    @if (!empty($urlFile))
                                                        <a href="{{ $urlFile }}" target="_blank" rel="noopener noreferrer">
                                                            <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.3929 4.05365L14.8912 4.61112L15.3929 4.05365ZM19.3517 7.61654L18.85 8.17402L19.3517 7.61654ZM21.654 10.1541L20.9689 10.4592V10.4592L21.654 10.1541ZM3.17157 20.8284L3.7019 20.2981H3.7019L3.17157 20.8284ZM20.8284 20.8284L20.2981 20.2981L20.2981 20.2981L20.8284 20.8284ZM14 21.25H10V22.75H14V21.25ZM2.75 14V10H1.25V14H2.75ZM21.25 13.5629V14H22.75V13.5629H21.25ZM14.8912 4.61112L18.85 8.17402L19.8534 7.05907L15.8947 3.49618L14.8912 4.61112ZM22.75 13.5629C22.75 11.8745 22.7651 10.8055 22.3391 9.84897L20.9689 10.4592C21.2349 11.0565 21.25 11.742 21.25 13.5629H22.75ZM18.85 8.17402C20.2034 9.3921 20.7029 9.86199 20.9689 10.4592L22.3391 9.84897C21.9131 8.89241 21.1084 8.18853 19.8534 7.05907L18.85 8.17402ZM10.0298 2.75C11.6116 2.75 12.2085 2.76158 12.7405 2.96573L13.2779 1.5653C12.4261 1.23842 11.498 1.25 10.0298 1.25V2.75ZM15.8947 3.49618C14.8087 2.51878 14.1297 1.89214 13.2779 1.5653L12.7405 2.96573C13.2727 3.16993 13.7215 3.55836 14.8912 4.61112L15.8947 3.49618ZM10 21.25C8.09318 21.25 6.73851 21.2484 5.71085 21.1102C4.70476 20.975 4.12511 20.7213 3.7019 20.2981L2.64124 21.3588C3.38961 22.1071 4.33855 22.4392 5.51098 22.5969C6.66182 22.7516 8.13558 22.75 10 22.75V21.25ZM1.25 14C1.25 15.8644 1.24841 17.3382 1.40313 18.489C1.56076 19.6614 1.89288 20.6104 2.64124 21.3588L3.7019 20.2981C3.27869 19.8749 3.02502 19.2952 2.88976 18.2892C2.75159 17.2615 2.75 15.9068 2.75 14H1.25ZM14 22.75C15.8644 22.75 17.3382 22.7516 18.489 22.5969C19.6614 22.4392 20.6104 22.1071 21.3588 21.3588L20.2981 20.2981C19.8749 20.7213 19.2952 20.975 18.2892 21.1102C17.2615 21.2484 15.9068 21.25 14 21.25V22.75ZM21.25 14C21.25 15.9068 21.2484 17.2615 21.1102 18.2892C20.975 19.2952 20.7213 19.8749 20.2981 20.2981L21.3588 21.3588C22.1071 20.6104 22.4392 19.6614 22.5969 18.489C22.7516 17.3382 22.75 15.8644 22.75 14H21.25ZM2.75 10C2.75 8.09318 2.75159 6.73851 2.88976 5.71085C3.02502 4.70476 3.27869 4.12511 3.7019 3.7019L2.64124 2.64124C1.89288 3.38961 1.56076 4.33855 1.40313 5.51098C1.24841 6.66182 1.25 8.13558 1.25 10H2.75ZM10.0298 1.25C8.15538 1.25 6.67442 1.24842 5.51887 1.40307C4.34232 1.56054 3.39019 1.8923 2.64124 2.64124L3.7019 3.7019C4.12453 3.27928 4.70596 3.02525 5.71785 2.88982C6.75075 2.75158 8.11311 2.75 10.0298 2.75V1.25Z" fill="#b62a11"></path> <path opacity="0.5" d="M6 14.5H14" stroke="#b62a11" stroke-width="1.5" stroke-linecap="round"></path> <path opacity="0.5" d="M6 18H11.5" stroke="#b62a11" stroke-width="1.5" stroke-linecap="round"></path> <path opacity="0.5" d="M13 2.5V5C13 7.35702 13 8.53553 13.7322 9.26777C14.4645 10 15.643 10 18 10H22" stroke="#b62a11" stroke-width="1.5"></path> </g></svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="paths">Fichier multiple</label>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <input class="form-control" multiple type="file" name="paths[]" id="paths">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="url">Lien externe</label>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="url" id="url">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Conteneur pour afficher les épisodes existants et les nouveaux -->
                {{-- <div id="episodesContainer">
                    @foreach ($livre->episodes as $episode)
                        <hr>
                        <div class="episode-section" id="episode_{{ $episode->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-title">Épisode <span class="episode-number">{{ $episode->id }}</span></div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <!-- Bouton de suppression -->
                                    <button id="deleteEpisodeBtn_{{ $episode->id }}" class="btn btn-danger" onclick="deleteEpisode({{ $episode->id }}, {{ $livre->id }})">Supprimer</button>
                                </div>
                            </div>
                            <div class="d-flex flex-column" id="episodeFields_{{ $episode->id }}" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titre_episode_{{ $episode->id }}">Titre</label>
                                            <input class="form-control" type="text" name="titre_episode[{{ $episode->id }}]" value="{{ old('titre_episode.' . $episode->id, $episode->titre) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="description_episode_{{ $episode->id }}">Description</label>
                                            <textarea class="form-control" name="description_episode[{{ $episode->id }}]" id="description_episode_{{ $episode->id }}" cols="10" rows="3">{{ old('description_episode.' . $episode->id, $episode->description) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="file_type_episode_{{ $episode->id }}">Type de fichier</label>
                                            <select name="file_type_episode[{{ $episode->id }}]" class="form-control file_type" id="file_type_episode_{{ $episode->id }}">
                                                <option value="upload" {{ $episode->url ? '' : 'selected' }}>Télécharger</option>
                                                <option value="external_link" {{ $episode->url ? 'selected' : '' }}>Lien externe</option>
                                            </select>
                                        </div>
                                        <div class="form-group upload_file" style="display: {{ $episode->url ? 'none' : 'block' }}">
                                            <label for="file_episode_{{ $episode->id }}">Fichier</label>
                                            <input class="form-control" type="file" name="file_episode[{{ $episode->id }}]">
                                        </div>
                                        <div class="form-group external_link" style="display: {{ $episode->url ? 'block' : 'none' }}">
                                            <label for="url_episode_{{ $episode->id }}">Lien externe</label>
                                            <input class="form-control" type="text" name="url_episode[{{ $episode->id }}]" value="{{ old('url_episode.' . $episode->id, $episode->url) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Bouton pour ajouter un nouvel épisode -->
                <button id="addNewEpisodeBtn" class="btn btn-primary">+ Ajouter un nouvel épisode</button> --}}

                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-primary pd-x-20">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector('#target_reader');
            var tagify = new Tagify(input, {
                // options
                delimiters: ",| ", // délimiteurs pour séparer les tags (virgule, espace, etc.)
                maxTags: 10, // nombre maximum de tags autorisés
                whitelist: [], // vous pouvez ajouter une liste blanche si vous voulez des tags prédéfinis
                dropdown: {
                    enabled: 0 // désactiver le menu déroulant
                }
            });
        });
     </script>
     
     <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector('#key_word');
            var tagify = new Tagify(input, {
                // options
                delimiters: ",| ", // délimiteurs pour séparer les tags (virgule, espace, etc.)
                maxTags: 10, // nombre maximum de tags autorisés
                whitelist: [], // vous pouvez ajouter une liste blanche si vous voulez des tags prédéfinis
                dropdown: {
                    enabled: 0 // désactiver le menu déroulant
                }
            });
        });
     </script>

    <script>
        document.getElementById('file_type_chapitre').addEventListener('change', function () {
            var fileGroup = document.getElementById('file_group_chapitre');
            var linkGroup = document.getElementById('link_group_chapitre');

            if (this.value === 'upload_chapitre') {
                fileGroup.style.display = 'block';
                linkGroup.style.display = 'none';
            } else if (this.value === 'external_link_chapitre') {
                fileGroup.style.display = 'none';
                linkGroup.style.display = 'block';
            }
        });
    </script>

    <script>
        // Ajoute un écouteur d'événement pour détecter les changements dans le select
        document.getElementById('file_type_episode').addEventListener('change', function () {
            var fileGroup = document.getElementById('file_group_episode');
            var linkGroup = document.getElementById('link_group_episode');

            // Si 'Télécharger' est sélectionné, on affiche le champ de fichier
            if (this.value === 'upload_episode') {
                fileGroup.style.display = 'block';
                linkGroup.style.display = 'none';
            } 
            // Si 'Lien externe' est sélectionné, on affiche le champ de lien externe
            else if (this.value === 'external_link_episode') {
                fileGroup.style.display = 'none';
                linkGroup.style.display = 'block';
            }
        });
    </script>

    <script>
        // Ajoute un écouteur d'événement pour détecter les changements dans le select
        document.getElementById('file_type_chapitre').addEventListener('change', function () {
            var fileGroup = document.getElementById('file_group_chapitre');
            var linkGroup = document.getElementById('link_group_chapitre');

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

        // Initialiser l'affichage basé sur la sélection actuelle au chargement
        document.getElementById('file_type_chapitre').dispatchEvent(new Event('change'));
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typePublicationSelect = document.getElementById('typePublicationSelect');
            const podcastContent = document.getElementById('podcastContent');
            const audioBookContent = document.getElementById('audioBookContent');
            const livreAndMagazineContent = document.getElementById('livreAndMagazineContent');

            typePublicationSelect.addEventListener('change', function () {
                const selectedValue = this.value;

                // Réinitialiser l'affichage des contenus
                podcastContent.style.display = 'none';
                audioBookContent.style.display = 'none';
                livreAndMagazineContent.style.display = 'none';

                // Afficher ou masquer les contenus en fonction de la sélection
                if (selectedValue === '4') {
                    podcastContent.style.display = 'block';
                } else if (selectedValue === '3') {
                    audioBookContent.style.display = 'block';
                } else if (selectedValue === '2' || selectedValue === '1') {
                    livreAndMagazineContent.style.display = 'block';
                }
            });

            // Initialiser l'affichage en fonction de la valeur sélectionnée par défaut
            typePublicationSelect.dispatchEvent(new Event('change'));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileTypeSelect = document.getElementById('file_type');
            
            // Sélection des sections pour chaque type de fichier
            const fileSection = document.querySelector('[name="path"]'); // Champ "Fichier"
            const multiFileSection = document.querySelector('[name="paths[]"]'); // Champ "Fichier multiple"
            const externalLinkSection = document.querySelector('[name="url"]'); // Champ "Lien externe"

            // Fonction pour afficher/masquer les sections en fonction du type sélectionné
            function toggleFields() {
                const selectedType = fileTypeSelect.value;
                
                // Masquer toutes les sections
                fileSection.closest('.row').style.display = 'none';
                multiFileSection.closest('.row').style.display = 'none';
                externalLinkSection.closest('.row').style.display = 'none';

                // Afficher la section correspondante
                if (selectedType === 'upload') {
                    fileSection.closest('.row').style.display = 'flex';
                } else if (selectedType === 'audio') {
                    multiFileSection.closest('.row').style.display = 'flex';
                } else if (selectedType === 'external_link') {
                    externalLinkSection.closest('.row').style.display = 'flex';
                }
            }

            // Déclenchement de la fonction au changement de sélection
            fileTypeSelect.addEventListener('change', toggleFields);

            // Initialisation pour afficher le champ correct au chargement de la page
            toggleFields();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#typePublicationSelect').on('change', function() {
                const selectedValue = $(this).val();
                
                // Efface les règles "required" actuelles pour les champs
                $('[name="titre_episode"], [name="description_episode"], [name="file_type_episode"], [name="file_episode"], [name="url_episode"]').prop('required', false);
                $('[name="titre_chapitre"], [name="description_chapitre"], [name="file_type_chapitre"], [name="file_chapitre"], [name="url_chapitre"]').prop('required', false);

                // Applique les règles "required" selon la sélection
                if (selectedValue === '4') { // Podcast
                    $('[name="titre_episode"], [name="description_episode"], [name="file_type_episode"]').prop('required', true);
                    $('[name="file_episode"]').prop('required', $('[name="file_type_episode"]').val() === 'upload');
                    $('[name="url_episode"]').prop('required', $('[name="file_type_episode"]').val() === 'external_link');
                } else if (selectedValue === '3') { // Audio Book
                    $('[name="titre_chapitre"], [name="description_chapitre"], [name="file_type_chapitre"]').prop('required', true);
                    $('[name="file_chapitre"]').prop('required', $('[name="file_type_chapitre"]').val() === 'upload');
                    $('[name="url_chapitre"]').prop('required', $('[name="file_type_chapitre"]').val() === 'external_link');
                }
            });

            // Appliquer les règles si le type de fichier change
            $('.file_type').on('change', function() {
                const type = $(this).val();
                const parent = $(this).closest('.row');
                
                if (type === 'upload') {
                    parent.find('.upload_file').show().find('input').prop('required', true);
                    parent.find('.external_link').hide().find('input').prop('required', false);
                } else if (type === 'external_link') {
                    parent.find('.upload_file').hide().find('input').prop('required', false);
                    parent.find('.external_link').show().find('input').prop('required', true);
                }
            });
            
            // Déclencher le changement au chargement pour configurer les règles initiales
            $('#typePublicationSelect').trigger('change');
        });
    </script>

{{-- <script>
    // Empêcher le comportement par défaut (soumission du formulaire) lors du clic sur le bouton d'ajout
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.addEpisodeBtn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                // Empêche la soumission du formulaire et l'actualisation de la page
                event.preventDefault();
                
                const episodeId = button.id.split('_')[1]; // Récupère l'ID de l'épisode lié au bouton
                const episodeSection = document.getElementById(`episode_${episodeId}`);
                const episodeFields = document.getElementById(`episodeFields_${episodeId}`);

                // Toggle the display of the fields (show/hide)
                if (episodeFields.style.display === 'none' || episodeFields.style.display === '') {
                    episodeFields.style.display = 'block';
                } else {
                    episodeFields.style.display = 'none';
                }
            });
        });

        // Ajouter un nouvel épisode à la fin de la liste d'épisodes
        document.getElementById('addNewEpisodeBtn').addEventListener('click', function(event) {
            event.preventDefault();

            // Crée un identifiant unique pour le nouvel épisode
            const newEpisodeId = Date.now(); // Utilise l'horodatage comme ID unique

            // Crée le HTML pour le nouvel épisode
            const newEpisodeHtml = `
                <div class="episode-section" id="episode_${newEpisodeId}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-title">Épisode <span class="episode-number">${newEpisodeId}</span></div>
                        </div>
                    </div>
                    <div class="d-flex flex-column" id="episodeFields_${newEpisodeId}" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="titre_episode_${newEpisodeId}">Titre</label>
                                    <input class="form-control" type="text" name="titre_episode[${newEpisodeId}]">
                                </div>
                                <div class="form-group">
                                    <label for="description_episode_${newEpisodeId}">Description</label>
                                    <textarea class="form-control" name="description_episode[${newEpisodeId}]" id="description_episode_${newEpisodeId}" cols="10" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_type_episode_${newEpisodeId}">Type de fichier</label>
                                    <select name="file_type_episode[${newEpisodeId}]" class="form-control file_type" id="file_type_episode_${newEpisodeId}">
                                        <option value="upload">Télécharger</option>
                                        <option value="external_link">Lien externe</option>
                                    </select>
                                </div>
                                <div class="form-group upload_file" style="display: block;">
                                    <label for="file_episode_${newEpisodeId}">Fichier</label>
                                    <input class="form-control" type="file" name="file_episode[${newEpisodeId}]">
                                </div>
                                <div class="form-group external_link" style="display: none;">
                                    <label for="url_episode_${newEpisodeId}">Lien externe</label>
                                    <input class="form-control" type="text" name="url_episode[${newEpisodeId}]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Ajoute le nouvel épisode après le dernier épisode
            const episodesContainer = document.getElementById('episodesContainer');
            episodesContainer.insertAdjacentHTML('beforeend', newEpisodeHtml);

            // Ajoute l'événement au bouton "Ajouter"
            const newAddButton = document.getElementById(`addEpisodeBtn_${newEpisodeId}`);
            newAddButton.addEventListener('click', function(event) {
                event.preventDefault();
                const episodeFields = document.getElementById(`episodeFields_${newEpisodeId}`);
                if (episodeFields.style.display === 'none' || episodeFields.style.display === '') {
                    episodeFields.style.display = 'block';
                } else {
                    episodeFields.style.display = 'none';
                }
            });
        });
    });

    // Gérer l'affichage/masquage des champs de type de fichier
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('file_type')) {
            const episodeId = event.target.id.split('_')[3]; // Récupère l'ID de l'épisode
            const fileType = event.target.value;

            const uploadFile = document.querySelector(`#episodeFields_${episodeId} .upload_file`);
            const externalLink = document.querySelector(`#episodeFields_${episodeId} .external_link`);

            if (fileType === 'upload') {
                uploadFile.style.display = 'block';
                externalLink.style.display = 'none';
            } else if (fileType === 'external_link') {
                uploadFile.style.display = 'none';
                externalLink.style.display = 'block';
            }
        }
    });
</script> --}}


{{-- <script>
    // Empêcher le comportement par défaut (soumission du formulaire) lors du clic sur le bouton d'ajout
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.addEpisodeBtn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                // Empêche la soumission du formulaire et l'actualisation de la page
                event.preventDefault();
                
                const episodeId = button.id.split('_')[1]; // Récupère l'ID de l'épisode lié au bouton
                const episodeSection = document.getElementById(`episode_${episodeId}`);
                const episodeFields = document.getElementById(`episodeFields_${episodeId}`);

                // Toggle the display of the fields (show/hide)
                if (episodeFields.style.display === 'none' || episodeFields.style.display === '') {
                    episodeFields.style.display = 'block';
                } else {
                    episodeFields.style.display = 'none';
                }
            });
        });

        // Ajouter un nouvel épisode à la fin de la liste d'épisodes
        document.getElementById('addNewEpisodeBtn').addEventListener('click', function(event) {
            event.preventDefault();

            // Crée un identifiant unique pour le nouvel épisode
            const newEpisodeId = Date.now(); // Utilise l'horodatage comme ID unique

            // Crée le HTML pour le nouvel épisode
            const newEpisodeHtml = `
                <div class="episode-section" id="episode_${newEpisodeId}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-title">Épisode <span class="episode-number">${newEpisodeId}</span></div>
                        </div>
                        <div class="col-md-6 text-right">
                            <!-- Bouton Retirer pour supprimer l'épisode -->
                            <button class="btn btn-warning" onclick="removeEpisode(${newEpisodeId})">Retirer</button>
                        </div>
                    </div>
                    <div class="d-flex flex-column" id="episodeFields_${newEpisodeId}" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="titre_episode_${newEpisodeId}">Titre</label>
                                    <input class="form-control" type="text" name="titre_episode[${newEpisodeId}]">
                                </div>
                                <div class="form-group">
                                    <label for="description_episode_${newEpisodeId}">Description</label>
                                    <textarea class="form-control" name="description_episode[${newEpisodeId}]" id="description_episode_${newEpisodeId}" cols="10" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_type_episode_${newEpisodeId}">Type de fichier</label>
                                    <select name="file_type_episode[${newEpisodeId}]" class="form-control file_type" id="file_type_episode_${newEpisodeId}">
                                        <option value="upload">Télécharger</option>
                                        <option value="external_link">Lien externe</option>
                                    </select>
                                </div>
                                <div class="form-group upload_file" style="display: block;">
                                    <label for="file_episode_${newEpisodeId}">Fichier</label>
                                    <input class="form-control" type="file" name="file_episode[${newEpisodeId}]">
                                </div>
                                <div class="form-group external_link" style="display: none;">
                                    <label for="url_episode_${newEpisodeId}">Lien externe</label>
                                    <input class="form-control" type="text" name="url_episode[${newEpisodeId}]">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            `;

            // Ajoute le nouvel épisode après le dernier épisode
            const episodesContainer = document.getElementById('episodesContainer');
            episodesContainer.insertAdjacentHTML('beforeend', newEpisodeHtml);

            // Ajouter un bouton "Ajouter" pour le nouvel épisode
            const newAddButton = document.getElementById(`addEpisodeBtn_${newEpisodeId}`);
            newAddButton.addEventListener('click', function(event) {
                event.preventDefault();
                const episodeFields = document.getElementById(`episodeFields_${newEpisodeId}`);
                if (episodeFields.style.display === 'none' || episodeFields.style.display === '') {
                    episodeFields.style.display = 'block';
                } else {
                    episodeFields.style.display = 'none';
                }
            });
        });
    });

    // Fonction pour retirer un épisode
    function removeEpisode(episodeId) {
        const episodeSection = document.getElementById(`episode_${episodeId}`);
        if (episodeSection) {
            episodeSection.remove(); // Supprime l'épisode
        }
    }

    // Gérer l'affichage/masquage des champs de type de fichier
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('file_type')) {
            const episodeId = event.target.id.split('_')[3]; // Récupère l'ID de l'épisode
            const fileType = event.target.value;

            const uploadFile = document.querySelector(`#episodeFields_${episodeId} .upload_file`);
            const externalLink = document.querySelector(`#episodeFields_${episodeId} .external_link`);

            if (fileType === 'upload') {
                uploadFile.style.display = 'block';
                externalLink.style.display = 'none';
            } else if (fileType === 'external_link') {
                uploadFile.style.display = 'none';
                externalLink.style.display = 'block';
            }
        }
    });
</script> --}}


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


    

@include('layouts.footer')