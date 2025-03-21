@include('layouts.header')
@include('layouts.menu')

@include('layouts.fileariane')


    <div class="row">
        <div class="col-lg-8 col-md-12">
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
                <h4 class="card-title mb-3">Les forfaits d'abonnement</h4>
                @if($forfaits->isNotEmpty() )
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Libellé</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Durée (en mois)</th>
                                    <th scope="col">Nombre de livre max</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forfaits as $key => $item)
                                    <div class="modal fade" id="id{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier la catégorie</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('forfait.update', ['id' => $item->id]) }}" method="post">
                                                        @csrf
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Libelle</label>
                                                                <input class="form-control" name="libelle" type="text" value="{{ old("libelle")?? $item->libelle }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Prix</label>
                                                                <input class="form-control" name="prix" type="number" value="{{ old("prix")?? $item->prix }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Durée de l'abonnement du forfait (en mois)</label>
                                                                <input class="form-control" name="duree" type="text" value="{{ old("duree")?? $item->duree }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Nombre de livre max</label>
                                                                <input class="form-control" name="max_livres" type="text" value="{{ old("max_livres")?? $item->max_livres }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Description</label>
                                                                <textarea class="form-control" name="description" id="" cols="30" rows="10">
                                                                    {{ old("description")?? $item->description }}
                                                                </textarea>
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
                                        <td>{{ $item->libelle }}</td>
                                        <td>{{ $item->prix }}</td>
                                        <td>{{ $item->duree }}</td>
                                        <td>{{ $item->max_livres }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <a class="text-success mr-2" href="#" data-toggle="modal" data-target="#id{{ $item->id }}">
                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                            </a>
                                            <form action="{{ route('forfait.destroy', ['id' => $item->id]) }}" method="POST"  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger" style="background:none; border:none; cursor:pointer;" id="delete">
                                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                                </button>
                                            </form> 
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p>Aucun forfait enregistrer !</p>
                @endif
            </div>
        </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <h4>Ajouter un forfait</h4>
            <div class="card mb-5">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <form action="{{ route('forfait.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Libelle</label>
                                <input class="form-control" name="libelle" type="text">
                            </div>
                            <div class="form-group">
                                <label for="">Prix en FCFA</label>
                                <input class="form-control" name="prix" type="number">
                            </div>
                            <div class="form-group">
                                <label for="">Durée (en mois)</label>
                                <input class="form-control" name="duree" type="number">
                            </div>
                            <div class="form-group">
                                <label for="">Nombre de livre max</label>
                                <input class="form-control" name="max_livres" type="number">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ old("description") }}</textarea>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary pd-x-20">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@include('layouts.footer')