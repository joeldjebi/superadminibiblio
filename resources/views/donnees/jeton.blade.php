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
                <h4 class="card-title mb-3">Les jetons</h4>
                @if($jetons->isNotEmpty() )
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Pièce</th>
                                    <th scope="col">Montant</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jetons as $key => $item)
                                    <div class="modal fade" id="id{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier un jeton</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('jeton.update', ['id' => $item->id]) }}" method="post">
                                                        @csrf
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Pièce</label>
                                                                <input class="form-control" name="piece" type="number" value="{{ old("piece")?? $item->piece }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Montant en Fcfa</label>
                                                                <input class="form-control" name="amount" type="number" value="{{ old("amount")?? $item->amount }}">
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
                                        <td>{{ number_format($item->piece, 0, ',', ' ') }}</td>
                                        <td>{{ number_format($item->amount, 0, ',', ' ') }} Fcfa</td>
                                        <td>
                                            <a class="text-success mr-2" href="#" data-toggle="modal" data-target="#id{{ $item->id }}">
                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                            </a>
                                            <form action="{{ route('jeton.destroy', ['id' => $item->id]) }}" method="POST"  style="display:inline;">
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
                        <p>Aucune pièce enregistrer !'</p>
                @endif
            </div>
        </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <h4>Ajouter une pièce</h4>
            <div class="card mb-5">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <form action="{{ route('jeton.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Pièce</label>
                                <input class="form-control" name="piece" type="number">
                            </div>
                            <div class="form-group">
                                <label for="">Montant en Fcfa</label>
                                <input class="form-control" name="amount" type="number">
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