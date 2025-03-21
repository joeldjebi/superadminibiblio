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
                <h4 class="card-title mb-3">Historique d'achat de talent</h4>
                @if($historique_achat_jetons->isNotEmpty() )
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom et prénoms</th>
                                    <th scope="col">Talent</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Date de paiement</th>
                                    <th scope="col">Référence</th>
                                    <th scope="col">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historique_achat_jetons as $key => $item)
                                    @php
                                        $dateString = $item->paid_at;
                                        $formattedDate = (new DateTime($dateString))->format('d-m-Y \à H:i:s');
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->user->nom }} {{ $item->user->prenoms }}</td>
                                        <td>{{ $item->jeton->piece }}</td>
                                        <td>{{ $item->jeton->amount }}</td>
                                        <td>{{ $formattedDate }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p>Aucun talent enregistrer !'</p>
                @endif
            </div>
        </div>
        </div>
    </div>


@include('layouts.footer')