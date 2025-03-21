@include('layouts.header')
@include('layouts.menu')

@include('layouts.fileariane')

      <div class="row">
         <!-- ICON BG-->
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
               <div class="card-body text-center">
                  <i class="i-Add-User"></i>
                  <div class="content">
                     <p class="text-muted mt-2 mb-0">Utilisateurs</p>
                     <p class="text-primary text-24 line-height-1 mb-2">{{ $totalUsers }}</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
               <div class="card-body text-center">
                  <i class="i-Financial"></i>
                  <div class="content">
                     <p class="text-muted mt-2 mb-0">Total livres achetés</p>
                     <p class="text-primary text-24 line-height-1 mb-2">
                        {{ $totalWalletTransaction }}
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
               <div class="card-body text-center">
                  <i class="i-Financial"></i>
                  <div class="content">
                     <p class="text-muted mt-2 mb-0">Montant livres achetés</p>
                     <p class="text-primary text-24 line-height-1 mb-2">
                        {{ (floor($totalAmountBuyLivre) == $totalAmountBuyLivre) ? number_format($totalAmountBuyLivre, 0, '', ' ') : number_format($totalAmountBuyLivre, 2, ',', ' ') }}
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
               <div class="card-body text-center">
                  <i class="i-Checkout-Basket"></i>
                  <div class="content">
                     <p class="text-muted mt-2 mb-0">Livres</p>
                     <p class="text-primary text-24 line-height-1 mb-2">{{ $totalLivre }}</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
               <div class="card-body text-center">
                  <i class="i-Money-2"></i>
                  <div class="content">
                     <p class="text-muted mt-2 mb-0">Abonnements</p>
                     <p class="text-primary text-24 line-height-1 mb-2">{{ $totalAbonnement }}</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
               <div class="card-body">
                  <div class="card-title">Ventes de cette année</div>
                  {{-- <div id="echartBar" style="height: 300px"></div> --}}
                  <canvas id="salesChart"></canvas>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-sm-12">
            <div class="card mb-4">
               <div class="card-body">
                  <div class="card-title">Ventes par pays</div>
                  {{-- <div id="echartPie" style="height: 300px"></div> --}}
                  <canvas id="salesChartCountry"></canvas>
               </div>
            </div>
         </div>
      </div>

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
                        <div class="col-md-6 text-right">
                            <div class="mb-3">
                                <a href="{{ route('livre.create') }}" class="btn btn-primary pd-x-20">Enregistrer un livre</a>
                            </div>
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
                            <p>Aucun livre acheté !</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
      document.addEventListener("DOMContentLoaded", function () {
          // Récupérer les données depuis PHP
          const salesData = @json($sales);

          // Convertir les mois en noms lisibles
          const labels = salesData.map(item => {
              const months = ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"];
              return months[item.month - 1];
          });

          const salesAmounts = salesData.map(item => item.total);

          const ctx = document.getElementById('salesChart').getContext('2d');
          new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: labels,
                  datasets: [{
                      label: 'Total des ventes en F CFA',
                      data: salesAmounts,
                      backgroundColor: 'rgba(75, 192, 192, 0.5)',
                      borderColor: 'rgba(75, 192, 192, 1)',
                      borderWidth: 1
                  }]
              },
              options: {
                  responsive: true,
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });
      });
      </script>
      <script>
          var ctx = document.getElementById('salesChartCountry').getContext('2d');

          var salesData = {
              labels: {!! json_encode($salesByCountry->pluck('country')) !!},
              datasets: [{
                  data: {!! json_encode($salesByCountry->pluck('total_sales')) !!},
                  backgroundColor: ['#6A5ACD', '#8A2BE2', '#7B68EE', '#483D8B', '#9370DB']
              }]
          };

          new Chart(ctx, {
              type: 'pie',
              data: salesData,
              options: {
                  responsive: true,
                  plugins: {
                      legend: {
                          position: 'right'
                      }
                  }
              }
          });
      </script>

@include('layouts.footer')
