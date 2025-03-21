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
                <h4 class="card-title mb-3">Historique des achats de livre</h4>
                @if($wallet_transactions->isNotEmpty() )
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom et prénoms</th>
                                    <th scope="col">Talent</th>
                                    <th scope="col">Type de transaction d'achat</th>
                                    <th scope="col">Livre</th>
                                    <th scope="col">Auteur</th>
                                    <th scope="col">Forfait</th>
                                    <th scope="col">Date d'achat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wallet_transactions as $key => $item)
                                    @php
                                        $dateString = $item->date_transaction;
                                        $formattedDate = (new DateTime($dateString))->format('d-m-Y \à H:i:s');
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->user->nom }} {{ $item->user->prenoms }}</td>
                                        <td>{{ $item->montant }}</td>
                                        <td>{{ $item->type_transaction }}</td>
                                        <td>{{ $item->livre->titre }}</td>
                                        <td>{{ $item->livre->auteur->nom }} {{ $item->livre->auteur->prenoms }}</td>
                                        <td>{{ $item->forfait->libelle ?? "" }}</td>
                                        <td>{{ $formattedDate }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p>Aucun abonnement enregistrer !'</p>
                @endif
            </div>
        </div>
        </div>
    </div>


@include('layouts.footer')