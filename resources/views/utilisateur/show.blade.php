@include('layouts.header')
@include('layouts.menu')

@include('layouts.fileariane')


<section class="ul-product-detail">
    <div class="row">
       <div class="col-12">
          <div class="card">
             <div class="card-body">
                <div class="row">
                    @if (!empty($user->avatar))
                    @php
                        $avatarUrl = asset('storage/' . $user->avatar);
                    @endphp
                        <div class="col-lg-3">
                            <img src="http://192.168.1.11:8000/storage/{{ $user->avatar }}" alt="" class="w-100 p-4">
                        </div>
                    @endif
                   <div class="col-lg-9">
                      <div class="mb-4">
                         <h5 class="heading">{{ $user->nom }} {{ $user->prenoms }}</h5>
                         <span class="text-mute">Membre depuis: {{ (new DateTime($user->created_at))->format('d-m-Y à H:i:s') }}</span>
                      </div>
                      <div class="d-flex align-items-baseline">
                         <h3 class="font-weight-700 text-primary mb-0 me-2">{{ $user->wallet }} </h3>
                         <span class="text-mute font-weight-800 me-2"> Pièce(s)</span>
                      </div>
                      <div class="ul-product-detail__features mt-3">
                         <ul class="m-0 p-0">
                            <li class="d-flex align-items-center gap-1"><i class="i-Telephone text-primary text-15 align-middle font-weight-700"></i><span> {{ $user->indicatif }} {{ $user->mobile }}</span></li>
                            @if (!empty($user->email))
                                <li class="d-flex align-items-center gap-1"><i class="i-Email text-primary text-15 align-middle font-weight-700"></i> <span style="margin-left: 5px"> {{ $user->email }}</span></li>
                            @endif
                         </ul>
                      </div>
                      <button type="button" class="mt-3 btn btn-danger">Desactiver</button>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>

 <section>
    <div class="row">
       <div class="mt-4 text-center col-lg-3 col-md-6">
          <div class="card">
             <div class="card-body">
                <div class="ul-product-detail--icon mb-2">
                    <i class="i-Book text-success text-25 font-weight-500"></i>
                </div>
                <h5 class="heading">12</h5>
                <p class="text-muted text-13">Livre acheté</p>
             </div>
          </div>
       </div>
       <div class="mt-4 text-center col-lg-3 col-md-6">
          <div class="card">
             <div class="card-body">
                <div class="ul-product-detail--icon mb-2"><i class="i-Book text-danger text-25 font-weight-500"></i></div>
                <h5 class="heading">24</h5>
                <p class="text-muted text-13">Magazine acheté</p>
             </div>
          </div>
       </div>
       <div class="mt-4 text-center col-lg-3 col-md-6">
          <div class="card">
             <div class="card-body">
                <div class="ul-product-detail--icon mb-2"><i class="i-Music-Note-2 text-info text-25 font-weight-500"></i></div>
                <h5 class="heading">55</h5>
                <p class="text-muted text-13">Podcast acheté</p>
             </div>
          </div>
       </div>
       <div class="mt-4 text-center col-lg-3 col-md-6">
          <div class="card">
             <div class="card-body">
                <div class="ul-product-detail--icon mb-2"><i class="i-Next-Music text-warning text-25 font-weight-500"></i></div>
                <h5 class="heading">78</h5>
                <p class="text-muted text-13">Audio Book acheté</p>
             </div>
          </div>
       </div>
    </div>
 </section>

 <section class="mt-3">
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
                            <h4 class="card-title mb-3">Les livres achetés</h4>
                        </div>
                    </div>
                    @if($livreAchetes->isNotEmpty() )
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
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($livreAchetes as $key => $item)
                                        @php
                                            // Génération de l'URL temporaire si l'URL de l'image existe
                                            $url = !empty($item->livre->image_cover_url) ? Storage::disk('wasabi')->temporaryUrl(
                                                $item->livre->image_cover_url, now()->addMinutes(20)
                                            ) : null;
                                            // Formatage du montant
                                            $nombre_formate = number_format($item->livre->amount, 0, '', ' ');
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
                                            <td>{{ $item->livre->titre }}</td>
                                            <td>{{ $nombre_formate }} </td>
                                            <td>{{ $item->livre->auteur->nom }} {{ $item->livre->auteur->prenoms }}</td>
                                            <td>{{ $item->livre->editeur->nom }} {{ $item->livre->editeur->prenoms }}</td>
                                            <td>{{ $item->livre->type_publication->libelle }}</td>
                                            <td>{{ $item->livre->download }}</td>
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
 </section>

@include('layouts.footer')
