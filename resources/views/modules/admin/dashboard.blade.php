@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    @include('includes.petro-data')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Estadísticas</a>
            </div>
            <div class="col s12 m6" data-aos="zoom-in">
                <div class="widget bootstrap-widget stats">
                    <div class="widget-stats-icon green white-text">
                        <i class="i-bss"></i>
                    </div>
                    <div class="widget-stats-content">
                        <span class="widget-stats-title">Recaudación Total en Bolivares</span>
                        <span class="widget-stats-number">
                            <span id="recaudacion" class="timer"></span> Bs.
                        </span>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
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
            </div>
            <div class="col s12 m6 l4">
                <div class="widget bootstrap-widget stats">
                    <div class="widget-stats-icon white-text banesco-green">
                        <i class="i-banesco"></i>
                    </div>
                    <div class="widget-stats-content">
                        <span class="widget-stats-title"><b>Banesco</b></span>
                        <span class="widget-stats-number">
                            <span id="banesco" class=""></span> Bs.
                        </span>
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
                            <span class="" id="banco100"></span> Bs.
                        </span>
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
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                            <canvas id="tax-collection" style="position: relative; height:40vh; width:80vw"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                            <canvas id="bank-earnings" style="position: relative; height:40vh; width:80vw"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                            <canvas id="typeTaxes" style="position: relative; height:40vh; width:80vw"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <ul class="collection with-header">
                        <li class="collection-header"><h5>Últimas Empresas que han pagado</h5></li>
                        @foreach ($company as $compa)


                            <li class="collection-item">
                                <span class="title"><b>Empresa:</b>{{$compa->companies[0]->name}}</span><br>
                                <span class=""><b>Monto: </b> {{$compa->amount}}</span><br>
                                <a href="">Detalles...</a>
                                {{-- <a href="!#" class="secondary-content right"><i class="icon-find_in_page"></i></a> --}}
                            </li>

                        @endforeach
                    </ul>
                </div>
                <div class="col s12 m6">
                    <ul class="collection with-header">
                        <li class="collection-header"><h5>Formas de Pago</h5></li>
                        <li class="collection-item">
                            <div>
                                {{-- <i class="icon-message circle"></i> --}}
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
                                {{-- <i class="icon-message circle"></i> --}}
                                <span class="title"><b>Cheque: {{$ppc}} </b></span><br>
                                <!-- <a href="#!" class="secondary-content" style="font-size:28px"><i class="icon-find_in_page"></i></a> -->
                            </div>
                        </li>
                        <li class="collection-item">
                            <div>
                                <span class="title"><b>Efectivo: </b>{{$ppe}}</span><br>
                                <!-- <a href="#!" class="secondary-content"><i class="icon-find_in_page"></i></a> -->
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col s12 m6">
                    <div class="card">
                        <div class="card-content">
                            <h5 class="center">Formas de Pago</h5>
                            <canvas id="donus" style="position: relative; height:120vh; width:160vw"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                            <table>
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
                                <tr>
                                    <td>{{$dear['taxes']}}</td>
                                    <td>{{$dear['Recaudado']}} Bs</td>
                                    <td>{{$dear['Espera']}} Bs</td>
                                    <td>{{$dear['Total']}} Bs</td>
                                    <td>
                                        <div>
                                            {{$dear['Porcentaje']}}%
                                            <div class="progress">
                                                <div class="determinate bg-danger"
                                                     style="width:{{$dear['Porcentaje']}}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$dear['Estimado']}} Bs</td>
                                    <td><i class="icon-arrow_upward text-success"> </i>{{$dear['Incremento']}} Bs</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card">
                        <div class="card-content">
                            <canvas id="dear" style="position: relative; height:160vh; width:160vw"></canvas>
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
            <script src="{{ asset('js/aos.js') }}"></script>
            <script src="{{ asset('js/Chart.min.js') }}"></script>
            <script src="{{ asset('js/dashboard.js') }}"></script>
            <script src="{{ asset('js/dev/geosysprim.js') }}"></script>
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap"
                    type="text/javascript"></script>
@endsection