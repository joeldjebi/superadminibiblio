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
            
            <div class="card text-left">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title mb-3">Les livres</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="mb-3">
                                <a href="{{ route('livre.create') }}" class="btn btn-primary pd-x-20">Enregistrer un livre</a>
                            </div>
                        </div>
                    </div>
                    @if($livres->isNotEmpty() )
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Image de couverture</th>
                                        <th scope="col">Libellé</th>
                                        <th scope="col">Prix F CFA</th>
                                        <th scope="col">Auteur</th>
                                        <th scope="col">Editeur</th>
                                        <th scope="col">Type de publication</th>
                                        <th scope="col">Téléchargement</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($livres as $key => $item)
                                        @php
                                            // Génération de l'URL temporaire si l'URL de l'image existe
                                            $url = !empty($item->image_cover_url) ? Storage::disk('wasabi')->temporaryUrl(
                                                $item->image_cover_url, now()->addMinutes(20)
                                            ) : null;
                                            // Formatage du montant
                                            $nombre_formate = number_format($item->amount, 0, '', ' ');
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{-- Vérification si l'URL de l'image existe et affichage de l'image --}}
                                                @if (!empty($url))
                                                    <img src="{{ $url }}" alt="Image" style="width:50px; height:auto;">
                                                @else
                                                    <span>Pas d'image</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->titre }}</td>
                                            <td>{{ $nombre_formate }} </td>
                                            <td>{{ $item->auteur->nom }} {{ $item->auteur->prenoms }}</td>
                                            <td>{{ $item->editeur->nom }} {{ $item->editeur->prenoms }}</td>
                                            <td>{{ $item->type_publication->libelle }}</td>
                                            <td>{{ $item->download }}</td>
                                            <td>{{ $item->statut }}</td>
                                            <td style="display: inline-flex; border: none;">
                                                <a class="text-success mr-2" href="{{ route('livre.show', ['id' => $item->id]) }}">
                                                    <i class="nav-icon i-Eye font-weight-bold"></i>
                                                </a>
                                                <a class="text-success mr-2" href="{{ route('livre.edit', ['id' => $item->id]) }}">
                                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                                </a>
                                                {{-- <form action="{{ route('forfait.destroy', ['id' => $item->id]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger" style="background:none; border:none; cursor:pointer;" id="delete">
                                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                                    </button>
                                                </form>  --}}
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
        </div>
    </div>


@include('layouts.footer')