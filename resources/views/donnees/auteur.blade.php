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
                <h4 class="card-title mb-3">Les auteurs</h4>
                @if($auteurs->isNotEmpty() )
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Préoms</th>
                                    <th scope="col">Adresse Email</th>
                                    <th scope="col">Numéro de téléphone</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auteurs as $key => $item)
                                    <div class="modal fade" id="id{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier pays d'étude</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('auteur.update', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Nom</label>
                                                                <input class="form-control" name="nom" type="text" value="{{ old("nom")?? $item->nom }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Prénoms</label>
                                                                <input class="form-control" name="prenoms" type="text" value="{{ old("prenoms")?? $item->prenoms }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Numéro de téléphone</label>
                                                                <input class="form-control" name="mobile" type="number" value="{{ old("mobile")?? $item->mobile }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Adresse Email</label>
                                                                <input class="form-control" name="email" type="email" value="{{ old("email")?? $item->email }}">
                                                            </div>
															<div class="form-group">
                                                                <label for="">Photo</label>
                                                                <input class="form-control" name="image" type="file">
																@if(!empty($item->image))
																	<img height="100" width="100" src="auteurs/image/{{ $item->image }}">
																@endif
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Biographie</label>
                                                                <textarea class="form-control" name="bio" id="" cols="10" rows="5">{{ $item->bio }}</textarea>
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
											@if(!empty($item->image))
											<img style="height: auto;" width="100" src="auteurs/image/{{ $item->image }}">
											@endif
										</td>
                                        <td>{{ $item->nom }}</td>
                                        <td>{{ $item->prenoms }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->mobile }}</td>
                                        <td>
                                            <a class="text-success mr-2" href="#" data-toggle="modal" data-target="#id{{ $item->id }}">
                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                            </a>
                                            <form action="{{ route('auteur.destroy', ['id' => $item->id]) }}" method="POST"  style="display:inline;">
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
                        <p>Aucun auteur enregistrer !'</p>
                @endif
            </div>
        </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <h4>Ajouter un auteur</h4>
            <div class="card mb-5">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <form action="{{ route('auteur.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Nom</label>
                                <input class="form-control" name="nom" type="text">
                            </div>
                            <div class="form-group">
                                <label for="">Prénoms</label>
                                <input class="form-control" name="prenoms" type="text">
                            </div>
                            <div class="form-group">
                                <label for="">Numéro de téléphone</label>
                                <input class="form-control" name="mobile" type="number">
                            </div>
                            <div class="form-group">
                                <label for="">Adresse E-mail</label>
                                <input class="form-control" name="email" type="email">
                            </div>
							<div class="form-group">
                                <label for="">Photo</label>
                                <input class="form-control" name="image" type="file">
                            </div>
                            <div class="form-group">
                                <label for="">Biographie</label>
                                <textarea class="form-control" name="bio" id="" cols="10" rows="5"></textarea>
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