@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection

@section('content')
    {{-- @include('includes.petro-data') --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Estadísticas</a></li>
                </ul>
            </div>
           
            @can('Estadisticas - SuperUsuario')
            <div class="col s12 m12">
                    <h4>Registros de SysPRIM</h4>
            </div>
            <div class="row">
                    <div class="col s12 m6">
                            <div class="widget bootstrap-widget stats">
                                <div class="widget-stats-icon blue-gradient">
                                    <a href="{{ route('users.read') }}" class="white-text">
                                        <i class="fas fa-user-tag"></i>
                                    </a>
                                </div>
                                <div class="widget-stats-content">
                                    <span class="widget-stats-title">Usuarios Registrados</span>
                                    <span class="widget-stats-number">{{ $users }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6">
                            <div class="widget bootstrap-widget stats ">
                                <div class="widget-stats-icon red-gradient">
                                    <a href="{{ route('companies.read') }}" class="white-text">
                                        <i class="fas fa-building"></i>
                                    </a>
                                </div>
                                <div class="widget-stats-content">
                                    <span class="widget-stats-title">Empresas Registradas</span>
                                    <span class="widget-stats-number">{{ $companies }}</span>
                                </div>
                            </div>
                        </div>
 
                <div class="col s12 m6">
                    <div class="widget bootstrap-widget stats">
                        <div class="widget-stats-icon orange-gradient">
                            <a href="{{ route('ticketOffice.vehicle.read') }}" class="white-text">
                                <i class="fas fa-car-alt"></i>
                            </a>                          
                        </div>
                        <div class="widget-stats-content">
                            <span class="widget-stats-title">Vehículos Registrados</span>
                            <span class="widget-stats-number">{{ $vehicles }}</span>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="widget bootstrap-widget stats">
                        <div class="widget-stats-icon green-gradient">
                            <a href="{{ route('property.ticket-office.read-property') }}" class="white-text">
                                <i class="fas fa-city"></i>
                            </a>    
                        </div>
                        <div class="widget-stats-content">
                            <span class="widget-stats-title">Inmuebles Registrados</span>
                            <span class="widget-stats-number">{{ $property }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
           <!--  <div class="col s12 m6">
               <div class="widget bootstrap-widget stats">
                   <div class="widget-stats-icon red white-text">
                       <i class="i-petro-logo"></i>
                   </div>
                   <div class="widget-stats-content">
                       <span class="widget-stats-title">Recaudación Total en Petros</span>
                       <span class="widget-stats-number">
                           <span class="timer" id="petro"></span>  </i>
                       </span>
                   </div>
               </div>
           </div> -->
           @can('Estadisticas - Bancos')
           <div class="row">
                <div class="col s12 m12">
                    <h4>Bancos</h4>
                </div>
                <div class="col s12 m6">
                    <div class="widget bootstrap-widget stats">
                        <div class="widget-stats-icon white-text bod-green">
                            <i class="i-bod"></i>
                        </div>
                        <div class="widget-stats-content">
                            <span class="widget-stats-title"><b>BOD </b>(Banco Occidental de Descuento)</span>
                            <span class="widget-stats-number">
                                <span class="" id="bod"></span> Bs.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">    
                    <div class="widget bootstrap-widget stats">
                        <div class="widget-stats-icon white-text bnc-blue">
                            <i class="i-bnc"></i>
                        </div>
                        <div class="widget-stats-content">
                            <span class="widget-stats-title"><b>BNC </b>(Banco Nacional de Crédito)</span>
                            <span class="widget-stats-number">
                                <span class="" id="bnc"></span> Bs.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="widget bootstrap-widget stats">
                        <div class="widget-stats-icon white-text banesco-green">
                            <i class="i-banesco"></i>
                        </div>
                        <div class="widget-stats-content">
                            <span class="widget-stats-title"><b>Banesco</b></span>
                            <span class="widget-stats-number">
                            <span id="banesco" class=""></span> Bs.</span>        
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="widget bootstrap-widget stats">
                        <div class="widget-stats-icon white-text x100-banco-yellow">
                            <i class="i-percent-banco" style="font-size:25px; line-height: 20px"></i>
                        </div>
                        <div class="widget-stats-content">
                            <span class="widget-stats-title"><b>100% Banco</b></span>
                            <span class="widget-stats-number">
                                <span class="" id="banco100"></span> Bs.</span>    
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="widget bootstrap-widget stats">
                        <div class="widget-stats-icon white-text red-gradient">
                            <i class="i-bicentenario" style="font-size: 30px"></i>
                        </div>
                        <div class="widget-stats-content">
                            <span class="widget-stats-title"><b>Banco Bicentenario</b></span>
                            <span class="widget-stats-number">
                                <span class="" id="bicentenario"></span> Bs.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
            @can('Estadisticas - Pagos')
            <div class="row">
                <div class="col s12 m12">
                    <h4>Recaudaciones</h4>
                </div>
                <div class="col s12" data-aos="zoom-in">
                    <div class="widget bootstrap-widget stats">
                        <div class="widget-stats-icon green white-text">
                            <i class="i-bss"></i>
                        </div>
                        <div class="widget-stats-content">
                            <span class="widget-stats-title">Recaudación Total en Bolivares</span>
                            <span class="widget-stats-number">
                                <span id="recaudacion" class="timer"></span> Bs.</span>
                        </div>
                    </div>
                </div>     
            </div>
            
           <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                            <canvas id="tax-collection" style="/* position: relative; height:40vh; width:80vw */"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                            <canvas id="bank-earnings"  style="/* position: relative; height:100vh; width:80vw */"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                            <canvas id="typeTaxes"  style="/*position: relative; height:100vh; width:80vw */"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            @endcan

            @can('Estadisticas - Pagos')
            <div class="row">
                    <div class="col s12 m12">
                            <h4>Pagos</h4>
                    </div>
                    <div class="col s12 m6">
                            <ul class="collection with-header">
                               <li class="collection-header"><h5>Últimas Empresas que han pagado</h5></li>
                                @foreach ($company as $compa)
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s12 m7">
                                                    <span class="title"><b>Empresa:</b>{{$compa->companies[0]->name}}</span><br>
                                                    <span class=""><b>Monto: </b> {{$compa->amount}}</span><br>
                                            </div>
                                            <div class="col s12 m5">
                                                    <a href="{{route('tickOffice.companies.details', ['id'=>$compa->companies[0]->id])}}" class="btn waves-effect waves-light red">
                                                        <i class="icon-control_point right"></i>
                                                        Detalles 
                                                    </a>                   
                                            </div>
                                        </div>                                     
                                    </li>
        
                                @endforeach
                            </ul>
                        </div>
                        <div class="col s12 m6">
                            <ul class="collection with-header">
                                <li class="collection-header"><a href="{{route('ticket-office.type.payments')}}" class="black-text"><h5>Formas de Pago</h5></a></li>
                                {{----}}<li class="collection-item">
                                    <div>
                                        <!--<i class="icon-message circle"></i> -->
                                        <span class="title"><b>Transferencia: {{$ptb}} </b></span><br>
                                        <!-- <a href="#!" class="secondary-content" style="font-size:28px"><i class="icon-find_in_page"></i></a> -->
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div>
                                        <span class="title"><b>Punto De Venta: </b>{{$ppv}}</span><br>
                                        <!-- <a href="#!" class="secondary-content"><i class="icon-find_in_page"></i></a> -->
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div>
                                        <!-- <i class="icon-message circle"></i> -->
                                        <span class="title"><b>Cheque: {{$ppc}} </b></span><br>
                                        <!-- <a href="#!" class="secondary-content" style="font-size:28px"><i class="icon-find_in_page"></i></a> -->
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div>
                                        <span class="title"><b>Efectivo: </b>{{$ppe}}</span><br>
                                        <!-- <a href="#!" class="secondary-content"><i class="icon-find_in_page"></i></a> -->
                                    </div>
                                </li>{{----}}
                            </ul>
                        </div>
            </div>
                

            <div class="row">
                <div class="col s12 m6">
                        <div class="card">
                            <div class="card-content">
                                <h5 class="center">Formas de Pago</h5>
                                <canvas id="donus" style="/* position: relative; height:120vh; width:160vw */"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6">
                            <div class="card">
                                <div class="card-content">
                                    <canvas id="dear" style="/* position: relative; height:160vh; width:160vw */"></canvas>
                                </div>
                            </div>
                    </div>
                </div>
            @endcan    
                
                
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Resumen</span>
                            <div class="divider"></div>
                            <table class="centered highlight" id="dear-table" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>Impuesto</th>
                                    <th>Recaudado</th>
                                    <th>En Espera</th>
                                    <th>Total</th>
                                    <th>Porcentaje</th>
                                    <th>Estimado</th>
                                    <th>Incremento</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{----}}<tr>
                                    <td>{{$dear['company']['taxes']}}</td>
                                    <td>{{$dear['company']['Recaudado']}} Bs</td>
                                    <td>{{$dear['company']['Espera']}} Bs</td>
                                    <td>{{$dear['company']['Total']}} Bs</td>
                                    <td>
                                        <div>
                                            <div class="progress">
                                                <div class="determinate red" style="width:{{$dear['company']['Porcentaje']}}%"><span>{{$dear['company']['Porcentaje']}}%</span></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$dear['company']['Estimado']}} Bs</td>
                                    <td><i class="icon-arrow_upward text-success"> </i>{{$dear['company']['Incremento']}} Bs</td>
                                </tr>
                                <tr>
                                    <td>{{$dear['vehicle']['taxes']}}</td>
                                    <td>{{$dear['vehicle']['Recaudado']}} Bs</td>
                                    <td>{{$dear['vehicle']['Espera']}} Bs</td>
                                    <td>{{$dear['vehicle']['Total']}} Bs</td>
                                    <td>
                                        <div>
                                            <div class="progress">
                                                <div class="determinate red" style="width:{{$dear['vehicle']['Porcentaje']}}%"><span>{{$dear['vehicle']['Porcentaje']}}%</span></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$dear['vehicle']['Estimado']}} Bs</td>
                                    <td><i class="icon-arrow_upward text-success"> </i>{{$dear['vehicle']['Incremento']}} Bs</td>
                                </tr>{{----}}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col s12">
                    <div id="map" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>
    </div>

        @endsection
        @section('scripts')
            <script src="{{ asset('js/jquery.countTo.js') }}"></script>
            <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
            <script src="{{ asset('js/aos.js') }}"></script>
            <script src="{{ asset('js/Chart.min.js') }}"></script>
            <script src="{{ asset('js/dashboard.js') }}"></script>
            <script src="{{ asset('js/dev/geosysprim.js') }}"></script>
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap"
                    type="text/javascript"></script>
            <script src="{{ asset('js/datatables.js') }}"></script>
            <script>
                $('#dear-table').DataTable({
                    responsive: true,
                    "scrollX": true,
                    "pageLength": 10,
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "No hay registros que mostrar.",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "<i class='icon-first_page'>",
                            "sLast":     "<i class='icon-last_page'></i>",
                            "sNext":     "<i class='icon-navigate_next'></i>",
                            "sPrevious": "<i class='icon-navigate_before'></i>"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        },
                        "buttons": {
                            "copy": "Copiar",
                            "colvis": "Visibilidad"
                        }
                    }
                });
            </script>
@endsection