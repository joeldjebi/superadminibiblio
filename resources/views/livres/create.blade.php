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
            <form action="{{ route('livre.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title">Informations</div>
                        <div class="d-flex flex-column">
                            <div class="form-group">
                                <label for="">Type de publication</label>
                                <select class="form-control" name="type_publication_id"  id="typePublicationSelect">
                                    @foreach ($type_publications as $item)
                                        <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Titre du livre</label>
                                        <input class="form-control" name="titre" type="text">
                                    </div>
                                </div>
                                @if(isset($auteurs) && $auteurs->count() > 0)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Auteur</label>
                                            <select class="form-control" name="auteur_id">
                                                @foreach ($auteurs as $auteur)
                                                    <option value="{{ $auteur->id }}">{{ $auteur->nom }} {{ $auteur->prenoms }}</option>
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
                                                    <option value="{{ $categorie->id }}">{{ $categorie->libelle }}</option>
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
                                        <input id="" class="form-control" name="mot_cle" type="text">
                                        <p class="text-muted"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                            Mettez les virgules vous permet d'ajouter d'autres mots</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Année de publication</label>
                                        <input class="form-control" name="annee_publication" type="number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Lecteur cible</label>
                                        <input id="" class="form-control" name="lecture_cible" type="text">
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
                                            <option value="gratuit">Gratuit</option>
                                            <option value="achat">Achat</option>
                                            <option value="abonnement">Abonnement</option>
                                            <option value="achat_et_abonnement">Achat et Abonnement</option>
                                        </select>
                                    </div>
                                </div>
                                @if(isset($editeurs) && $editeurs->count() > 0)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Éditeur</label>
                                            <select class="form-control" name="editeur_id">
                                                @foreach ($editeurs as $editeur)
                                                    <option value="{{ $editeur->id }}">{{ $editeur->nom }} {{ $editeur->prenoms }}</option>
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
                                        <input class="form-control" name="amount" type="number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Édition du livre</label>
                                        <input class="form-control" name="edition_du_livre" type="text">
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
                                                    <option value="{{ $country->id }}">{{ $country->libelle }}</option>
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
                                                    <option value="{{ $langue->id }}">{{ $langue->libelle }}</option>
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
                                            <option value="1">Oui</option>
                                            <option value="0">Non</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nombre de page</label>
                                        <input class="form-control" name="nombre_de_page" type="number" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Couverture du livre</label>
                                        <input class="form-control" name="image_cover" type="file" required>
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
                                        <textarea class="form-control" name="breve_description" id="" cols="10" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea class="form-control" name="description" id="" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" id="livreAndMagazineContent">
                    <div class="card-body">
                        <div class="card-title">Fichier du livre</div>
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Type de fichier</label>
                                        <select name="file_type" class="form-control custom-select-black" id="file_type">
                                            <option value="upload">Télécharger</option>
                                            <option value="audio">Plusieurs fichiers audio</option>
                                            <option value="external_link">Lien externe</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Extrait</label>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="path_extrait" id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Fichier</label>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="path" id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Fichier multiple</label>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input class="form-control" multiple type="file" name="paths[]" id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Lien externe</label>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="url" id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3" id="podcastContent">
                    <div class="card-body" id="episodeContainer">
                        <div class="episode-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-title">Épisode <span class="episode-number">1</span></div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button id="addEpisodeBtn" class="btn btn-success">+ Ajouter</button>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titre_episode">Titre</label>
                                            <input class="form-control" type="text" name="titre_episode[]">
                                        </div>
                                        <div class="form-group">
                                            <label for="description_episode">Description</label>
                                            <textarea class="form-control" name="description_episode[]" id="description_episode" cols="10" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="file_type_episode">Type de fichier</label>
                                            <select name="file_type_episode[]" class="form-control file_type" id="file_type_episode">
                                                <option value="upload">Télécharger</option>
                                                <option value="external_link">Lien externe</option>
                                            </select>
                                        </div>
                                        <div class="form-group upload_file">
                                            <label for="file_episode">Fichier</label>
                                            <input class="form-control" type="file" name="file_episode[]">
                                        </div>
                                        <div class="form-group external_link" style="display: none;">
                                            <label for="url_episode">Lien externe</label>
                                            <input class="form-control" type="text" name="url_episode[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3" id="audioBookContent">
                    <div class="card-body" id="chapitreContainer">
                        <div class="chapitre-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-title">Chapitre <span class="chapitre-number">1</span></div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button id="addChapitreBtn" class="btn btn-success">+ Ajouter</button>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titre_chapitre">Titre</label>
                                            <input class="form-control" type="text" name="titre_chapitre[]" id="titre_chapitre">
                                        </div>
                                        <div class="form-group">
                                            <label for="description_chapitre">Description</label>
                                            <textarea class="form-control" name="description_chapitre[]" id="description_chapitre" cols="10" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="file_type_chapitre">Type de fichier</label>
                                            <select name="file_type_chapitre[]" class="form-control file_type" id="file_type_chapitre">
                                                <option value="upload">Télécharger</option>
                                                <option value="external_link">Lien externe</option>
                                            </select>
                                        </div>
                                        <div class="form-group upload_file" id="file_group_chapitre">
                                            <label for="file_chapitre">Fichier</label>
                                            <input class="form-control" type="file" name="file_chapitre[]" id="file_chapitre">
                                        </div>
                                        <div class="form-group external_link" id="link_group_chapitre" style="display: none;">
                                            <label for="url_chapitre">Lien externe</label>
                                            <input class="form-control" type="text" name="url_chapitre[]" id="url_chapitre">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

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
            const chapitreContainer = document.getElementById('chapitreContainer');
            const addChapitreBtn = document.getElementById('addChapitreBtn');

            // Fonction pour cloner un chapitre et l'ajouter à la liste
            addChapitreBtn.addEventListener('click', function (e) {
                e.preventDefault();

                // Clone la première section de chapitre
                const firstChapitre = chapitreContainer.querySelector('.chapitre-section');
                const newChapitre = firstChapitre.cloneNode(true);

                // Réinitialiser les champs dans la nouvelle section
                newChapitre.querySelectorAll('input, textarea').forEach(input => input.value = '');

                // Supprimer le bouton "Ajouter" du nouvel élément
                const addChapitreButton = newChapitre.querySelector('#addChapitreBtn');
                if (addChapitreButton) {
                    addChapitreButton.remove();
                }

                // Ajouter une ligne de séparation <hr />
                const hr = document.createElement('hr');
                chapitreContainer.appendChild(hr);

                // Réinitialiser l'affichage du type de fichier
                newChapitre.querySelector('.upload_file').style.display = 'block';
                newChapitre.querySelector('.external_link').style.display = 'none';

                // Ajouter un bouton de suppression pour le nouvel chapitre uniquement
                const removeButton = document.createElement('div');
                removeButton.classList.add('text-end');
                removeButton.innerHTML = '<button type="button" class="btn btn-danger remove-chapitre-btn">Retirer</button>';
                newChapitre.appendChild(removeButton);

                // Ajouter la nouvelle section de chapitre au container
                chapitreContainer.appendChild(newChapitre);

                // Réorganiser les numéros de chapitres
                updateChapitreNumbers();

                // Ajouter les gestionnaires d'événements pour le changement de type de fichier
                attachFileTypeChangeHandler(newChapitre);

                // Ajouter le gestionnaire de suppression pour le nouveau chapitre
                attachRemoveChapitreHandler(newChapitre);
            });

            // Fonction pour gérer l'affichage du type de fichier
            function attachFileTypeChangeHandler(chapitre) {
                const fileTypeSelect = chapitre.querySelector('#file_type_chapitre');

                fileTypeSelect.addEventListener('change', function () {
                    const selectedFileType = this.value;
                    const uploadFileDiv = chapitre.querySelector('#file_group_chapitre');
                    const externalLinkDiv = chapitre.querySelector('#link_group_chapitre');

                    // Masquer ou afficher les champs en fonction de la sélection
                    if (selectedFileType === 'upload') {
                        uploadFileDiv.style.display = 'block';
                        externalLinkDiv.style.display = 'none';
                    } else if (selectedFileType === 'external_link') {
                        uploadFileDiv.style.display = 'none';
                        externalLinkDiv.style.display = 'block';
                    }
                });
            }

            // Fonction pour gérer la suppression d'un chapitre
            function attachRemoveChapitreHandler(chapitre) {
                const removeBtn = chapitre.querySelector('.remove-chapitre-btn');

                removeBtn.addEventListener('click', function () {
                    if (chapitreContainer.children.length > 1) {
                        chapitre.previousElementSibling.remove(); // Supprime le <hr />
                        chapitre.remove();
                        updateChapitreNumbers();
                    } else {
                        alert("Vous devez conserver au moins un chapitre.");
                    }
                });
            }

            // Fonction pour mettre à jour les numéros des chapitres
            function updateChapitreNumbers() {
                const chapitres = chapitreContainer.querySelectorAll('.chapitre-section');
                chapitres.forEach((chapitre, index) => {
                    const chapitreNumber = chapitre.querySelector('.chapitre-number');
                    if (chapitreNumber) {
                        chapitreNumber.textContent = index + 1; // Mettre à jour la numérotation
                    }
                });
            }

            // Appliquer les gestionnaires d'événements pour le premier chapitre
            attachFileTypeChangeHandler(document.querySelector('.chapitre-section'));

            // Initialiser la numérotation au démarrage
            updateChapitreNumbers();
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const episodeContainer = document.getElementById('episodeContainer');
            const addEpisodeBtn = document.getElementById('addEpisodeBtn');

            // Fonction pour cloner un épisode et l'ajouter à la liste
            addEpisodeBtn.addEventListener('click', function (e) {
                e.preventDefault();

                // Clone la première section d'épisode
                const firstEpisode = episodeContainer.querySelector('.episode-section');
                const newEpisode = firstEpisode.cloneNode(true);

                // Réinitialiser les champs dans la nouvelle section
                newEpisode.querySelectorAll('input, textarea').forEach(input => input.value = '');

                // Supprimer le bouton "Ajouter" du nouvel élément
                const addEpisodeButton = newEpisode.querySelector('#addEpisodeBtn');
                if (addEpisodeButton) {
                    addEpisodeButton.remove();
                }

                // Ajouter une ligne de séparation <hr />
                const hr = document.createElement('hr');
                episodeContainer.appendChild(hr);

                // Réinitialiser l'affichage du type de fichier
                newEpisode.querySelector('.upload_file').style.display = 'block';
                newEpisode.querySelector('.external_link').style.display = 'none';

                // Ajouter un bouton de suppression pour le nouvel épisode uniquement
                const removeButton = document.createElement('div');
                removeButton.classList.add('text-end');
                removeButton.innerHTML = '<button type="button" class="btn btn-danger remove-episode-btn">Retirer</button>';
                newEpisode.appendChild(removeButton);

                // Ajouter la nouvelle section d'épisode au container
                episodeContainer.appendChild(newEpisode);

                // Réorganiser les numéros d'épisodes
                updateEpisodeNumbers();

                // Ajouter les gestionnaires d'événements pour le changement de type de fichier
                attachFileTypeChangeHandler(newEpisode);

                // Ajouter le gestionnaire de suppression pour le nouveau épisode
                attachRemoveEpisodeHandler(newEpisode);
            });

            // Fonction pour gérer l'affichage du type de fichier
            function attachFileTypeChangeHandler(episode) {
                const fileTypeSelect = episode.querySelector('.file_type');

                fileTypeSelect.addEventListener('change', function () {
                    const selectedFileType = this.value;
                    const uploadFileDiv = episode.querySelector('.upload_file');
                    const externalLinkDiv = episode.querySelector('.external_link');

                    // Masquer ou afficher les champs en fonction de la sélection
                    if (selectedFileType === 'upload') {
                        uploadFileDiv.style.display = 'block';
                        externalLinkDiv.style.display = 'none';
                    } else if (selectedFileType === 'external_link') {
                        uploadFileDiv.style.display = 'none';
                        externalLinkDiv.style.display = 'block';
                    }
                });
            }

            // Fonction pour gérer la suppression d'un épisode
            function attachRemoveEpisodeHandler(episode) {
                const removeBtn = episode.querySelector('.remove-episode-btn');

                removeBtn.addEventListener('click', function () {
                    if (episodeContainer.children.length > 1) {
                        episode.previousElementSibling.remove(); // Supprime le <hr />
                        episode.remove();
                        updateEpisodeNumbers();
                    } else {
                        alert("Vous devez conserver au moins un épisode.");
                    }
                });
            }

            // Fonction pour mettre à jour les numéros des épisodes
            function updateEpisodeNumbers() {
                const episodes = episodeContainer.querySelectorAll('.episode-section');
                episodes.forEach((episode, index) => {
                    const episodeNumber = episode.querySelector('.episode-number');
                    if (episodeNumber) {
                        episodeNumber.textContent = index + 1; // Mettre à jour la numérotation
                    }
                });
            }

            // Appliquer les gestionnaires d'événements pour le premier épisode
            attachFileTypeChangeHandler(document.querySelector('.episode-section'));

            // Initialiser la numérotation au démarrage
            updateEpisodeNumbers();
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const episodeContainer = document.getElementById('episodeContainer');
            const addEpisodeBtn = document.getElementById('addEpisodeBtn');
    
            // Fonction pour cloner un épisode et l'ajouter à la liste
            addEpisodeBtn.addEventListener('click', function (e) {
                e.preventDefault();
    
                // Clone la première section d'épisode
                const firstEpisode = episodeContainer.querySelector('.episode-section');
                const newEpisode = firstEpisode.cloneNode(true);
    
                // Réinitialiser les champs dans la nouvelle section
                newEpisode.querySelectorAll('input, textarea').forEach(input => input.value = '');
    
                // Supprimer le bouton "Ajouter" du nouvel élément
                const addEpisodeButton = newEpisode.querySelector('#addEpisodeBtn');
                if (addEpisodeButton) {
                    addEpisodeButton.remove();
                }
    
                // Ajouter une ligne de séparation <hr />
                const hr = document.createElement('hr');
                episodeContainer.appendChild(hr);
    
                // Réinitialiser l'affichage du type de fichier
                newEpisode.querySelector('.upload_file').style.display = 'block';
                newEpisode.querySelector('.external_link').style.display = 'none';
    
                // Ajouter un bouton de suppression pour le nouvel épisode uniquement
                const removeButton = document.createElement('div');
                removeButton.classList.add('text-end');
                removeButton.innerHTML = '<button type="button" class="btn btn-danger remove-episode-btn">Retirer</button>';
                newEpisode.appendChild(removeButton);
    
                // Ajouter la nouvelle section d'épisode au container
                episodeContainer.appendChild(newEpisode);
    
                // Réorganiser les numéros d'épisodes
                updateEpisodeNumbers();
    
                // Ajouter les gestionnaires d'événements pour le changement de type de fichier
                attachFileTypeChangeHandler(newEpisode);
    
                // Ajouter le gestionnaire de suppression pour le nouvel épisode
                attachRemoveEpisodeHandler(newEpisode);
            });
    
            // Fonction pour gérer l'affichage du type de fichier
            function attachFileTypeChangeHandler(episode) {
                const fileTypeSelect = episode.querySelector('.file_type');
    
                fileTypeSelect.addEventListener('change', function () {
                    const selectedFileType = this.value;
                    const uploadFileDiv = episode.querySelector('.upload_file');
                    const externalLinkDiv = episode.querySelector('.external_link');
    
                    // Masquer ou afficher les champs en fonction de la sélection
                    if (selectedFileType === 'upload') {
                        uploadFileDiv.style.display = 'block';
                        externalLinkDiv.style.display = 'none';
                    } else if (selectedFileType === 'external_link') {
                        uploadFileDiv.style.display = 'none';
                        externalLinkDiv.style.display = 'block';
                    }
                });
            }
    
            // Fonction pour gérer la suppression d'un épisode
            function attachRemoveEpisodeHandler(episode) {
                const removeBtn = episode.querySelector('.remove-episode-btn');
    
                removeBtn.addEventListener('click', function () {
                    if (episodeContainer.children.length > 1) {
                        episode.previousElementSibling.remove(); // Supprime le <hr />
                        episode.remove();
                        updateEpisodeNumbers();
                    } else {
                        alert("Vous devez conserver au moins un épisode.");
                    }
                });
            }
    
            // Fonction pour mettre à jour les numéros des épisodes
            function updateEpisodeNumbers() {
                const episodes = episodeContainer.querySelectorAll('.episode-section');
                episodes.forEach((episode, index) => {
                    const episodeNumber = episode.querySelector('.episode-number');
                    if (episodeNumber) {
                        episodeNumber.textContent = index + 1; // Mettre à jour la numérotation
                    }
                });
            }
    
            // Appliquer les gestionnaires d'événements pour le premier épisode
            attachFileTypeChangeHandler(document.querySelector('.episode-section'));
    
            // Initialiser la numérotation au démarrage
            updateEpisodeNumbers();
        });
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

@include('layouts.footer')