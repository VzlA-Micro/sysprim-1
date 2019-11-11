@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Estadísticas</a>
            </div>
            <div class="col s12 m6" data-aos="zoom-in">
				<div class="widget bootstrap-widget stats">
					<div class="widget-stats-icon green white-text">
                        <i class="icon-thumb_up"></i>
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
						<i class="icon-Petro_sign"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title">Recaudación Total en Petros</span>
						<span class="widget-stats-number">
                            <span class="timer" data-to="100000000" ></span> P.
                        </span>
					</div>
				</div>
			</div>
            <div class="col s12 m6 l4">
				<div class="widget bootstrap-widget stats banesco-green white-text">
					<div class="widget-stats-icon white-text">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>Banesco</b></span>
						<span class="widget-stats-number">
                            <span id="banesco" class="" ></span> Bs.
                        </span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate animated slideInLeft" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m6 l4">
				<div class="widget bootstrap-widget stats x100-banco-yellow white-text">
					<div class="widget-stats-icon white-text">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>100% Banco</b></span>
						<span class="widget-stats-number">
                            <span class="" id="banco100"></span> Bs.
                        </span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate animated slideInLeft" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m6 l4">
				<div class="widget bootstrap-widget stats bod-green white-text">
					<div class="widget-stats-icon white-text">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>BOD </b>(Banco Occidental de Descuento)</span>
						<span class="widget-stats-number">
                            <span class="" id="bod"></span> Bs.
                        </span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate animated slideInLeft" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m6">
				<div class="widget bootstrap-widget stats red-gradient white-text">
					<div class="widget-stats-icon white-text">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>Banco Bicentenario</b></span>
						<span class="widget-stats-number">
                            <span class="" id="bicentenario"></span> Bs.
                        </span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate animated slideInLeft" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m6">
				<div class="widget bootstrap-widget stats bnc-blue white-text">
					<div class="widget-stats-icon white-text">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>BNC </b>(Banco Nacional de Crédito)</span>
						<span class="widget-stats-number">
                            <span class="" id="bnc"></span> Bs.
                        </span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate animated slideInLeft" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m12">
                <div class="card">
                    <div class="card-content">
                        <canvas id="tax-collection"></canvas>
                    </div>
                </div>
            </div>
            <div class="col s12 m12">
                <div class="card">
                    <div class="card-content">
                        <canvas id="bank-earnings"></canvas>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <ul class="collection with-header">
                    <li class="collection-header"><h4>Últimas Empresas que han pagado</h4></li>
                  <!-- @foreach ($company as $compa)
                    <li class="collection-item">
                        <span class="new badge red" data-badge-caption="Pendiente"></span>
                        <span class="title"><b>Empresa:</b></span><br>
                        <span class=""><b>Monto: </b> {{$compa->amount}}</span><br>
                        <a href="">Detalles...</a>
                        {{-- <a href="!#" class="secondary-content right"><i class="icon-find_in_page"></i></a> --}}
                    </li>-->
                    @endforeach
                </ul>
            </div>
            <div class="col s12 m6">
                <ul class="collection with-header">
                    <li class="collection-header"><h4>Top de Formas de Pago</h4></li>
                    <li class="collection-item">
                        <div>
                            {{-- <i class="icon-message circle"></i> --}}
                            <span class="title"><b>Transferencia:  {{$ptb}} </b></span><br>
                            <!-- <a href="#!" class="secondary-content" style="font-size:28px"><i class="icon-find_in_page"></i></a> -->
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span class="title"><b>Punto De Venta: </b>{{$ppb}}</span><br>
                            <!-- <a href="#!" class="secondary-content"><i class="icon-find_in_page"></i></a> -->
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col s12">
                <div id="map" style="width: 100%; height: 400px"></div>
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap" type="text/javascript"></script> 
@endsection