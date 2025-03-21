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
                    <h4 class="card-title mb-3">Les utilisateurs</h4>
                    @if($users->isNotEmpty() )
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Préoms</th>
                                        <th scope="col">Adresse Email</th>
                                        <th scope="col">Numéro de téléphone</th>
                                        <th scope="col">Wallet (Pièce)</th>
                                        <th scope="col">Pays d'origine</th>
                                        <th scope="col">Code ISO</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->nom }}</td>
                                            <td>{{ $item->prenoms }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->indicatif }}{{ $item->mobile }}</td>
                                            <td>{{ $item->wallet }}</td>
                                            <td>{{ $item->pays->libelle }}</td>
                                            <td>{{ $item->pays->devise->code_iso }}</td>
                                            <td>
                                                <a class="text-success mr-2" href="{{ route('utilisateur.show', ['id' => $item->id]) }}">
                                                    <i class="nav-icon i-Eye font-weight-bold" style="font-size: 20px;"></i>
                                                </a>
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
    </div>


@include('layouts.footer')