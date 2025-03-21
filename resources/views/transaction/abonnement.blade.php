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
                <h4 class="card-title mb-3">Historique des abonnements</h4>
                @if($abonnements->isNotEmpty() )
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom et prénoms</th>
                                    <th scope="col">Forfait</th>
                                    <th scope="col">Montant</th>
                                    <th scope="col">Durée</th>
                                    <th scope="col">Date de début</th>
                                    <th scope="col">Date de fin</th>
                                    <th scope="col">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($abonnements as $key => $item)
                                    @php
                                        $dateStringDebut = $item->date_debut;
                                        $formattedDateDebut = (new DateTime($dateStringDebut))->format('d-m-Y \à H:i:s');

                                        $dateStringFin = $item->date_fin;
                                        $formattedDateFin = (new DateTime($dateStringFin))->format('d-m-Y \à H:i:s');
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->user->nom }} {{ $item->user->prenoms }}</td>
                                        <td>{{ $item->forfait->libelle }}</td>
                                        <td>{{ $item->forfait->prix }}</td>
                                        <td>{{ $item->forfait->duree }}</td>
                                        <td>{{ $formattedDateDebut }}</td>
                                        <td>{{ $formattedDateFin }}</td>
                                        <td>{{ $item->status }}</td>
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