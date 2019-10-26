@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Estadísticas</a>
            </div>
            <div class="col s12 m6">
				<div class="widget bootstrap-widget stats">
					<div class="widget-stats-icon green white-text">
                        <i class="icon-thumb_up"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title">Dinero Total en Bolivares</span>
						<span class="widget-stats-number">100.000.000Bs</span>
					</div>
				</div>
            </div>
            <div class="col s12 m6">
				<div class="widget bootstrap-widget stats">
					<div class="widget-stats-icon green white-text">
						<i class="icon-thumb_up"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title">Dinero Total en Petros</span>
						<span class="widget-stats-number">0,0000215136136</span>
					</div>
				</div>
			</div>
            <div class="col s12 m6 l4">
				<div class="widget bootstrap-widget stats blue-gradient">
					<div class="widget-stats-icon white-text">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>Banesco</b></span>
						<span class="widget-stats-number">5 stars</span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m6 l4">
				<div class="widget bootstrap-widget stats green-gradient">
					<div class="widget-stats-icon white-text">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>100% Banco</b></span>
						<span class="widget-stats-number">5 stars</span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m6 l4">
				<div class="widget bootstrap-widget stats green-gradient">
					<div class="widget-stats-icon white-text">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>BOD </b>(Banco Occidental de Descuento)</span>
						<span class="widget-stats-number">5 stars</span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m6">
				<div class="widget bootstrap-widget stats">
					<div class="widget-stats-icon white-text red">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>Banco Bicentenario</b></span>
						<span class="widget-stats-number">5 stars</span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m6">
				<div class="widget bootstrap-widget stats green-gradient">
					<div class="widget-stats-icon white-text">
						<i class="icon-star"></i>
					</div>
					<div class="widget-stats-content">
						<span class="widget-stats-title"><b>BNC </b>(Banco Nacional de Crédito)</span>
						<span class="widget-stats-number">5 stars</span>
                    </div>
                    <div class="widget-progress">
						<div class="progress">
							<div class="determinate" style="width: 30%"></div>
						</div>
					</div>
					<div class="widget-description">
						 20% Increase in 30 Days 
					</div>
				</div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <canvas id="tax-collection"></canvas>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <canvas id="bank-earnings"></canvas>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <ul class="collection with-header">
                    <li class="collection-header"><h4>Últimas Empresas que han pagado</h4></li>
                    <li class="collection-item">
                        <span class="new badge red" data-badge-caption="Pendiente"></span>
                        <span class="title"><b>Empresa:</b> Jhon Doe</span><br>
                        <span class=""><b>Monto: </b> 300.000Bs - 0,000352626 P</span><br>
                        <a href="">Detalles...</a>
                        {{-- <a href="!#" class="secondary-content right"><i class="icon-find_in_page"></i></a> --}}
                    </li>
                    <li class="collection-item">
                        <span class="new badge red" data-badge-caption="Pendiente"></span>
                        <span class="title"><b>Empresa:</b> Jhon Doe</span><br>
                        <span class=""><b>Monto: </b> 300.000Bs - 0,000352626 P</span><br>
                        <a href="">Detalles...</a>
                    </li>
                    <li class="collection-item">
                        <span class="new badge red" data-badge-caption="Pendiente"></span>
                        <span class="title"><b>Empresa:</b> Jhon Doe</span><br>
                        <span class=""><b>Monto: </b> 300.000Bs - 0,000352626 P</span><br>
                        <a href="">Detalles...</a>
                    </li>
                    <li class="collection-item">
                        <span class="new badge red" data-badge-caption="Pendiente"></span>
                        <span class="title"><b>Empresa:</b> Jhon Doe</span><br>
                        <span class=""><b>Monto: </b> 300.000Bs - 0,000352626 P</span><br>
                        <a href="">Detalles...</a>
                    </li>
                    <li class="collection-item">
                        <span class="new badge red" data-badge-caption="Pendiente"></span>
                        <span class="title"><b>Empresa:</b> Jhon Doe</span><br>
                        <span class=""><b>Monto: </b> 300.000Bs - 0,000352626 P</span><br>
                        <a href="">Detalles...</a>
                    </li>
                </ul>
            </div>
            <div class="col s12 m6">
                <ul class="collection with-header">
                    <li class="collection-header"><h4>Top de Formas de Pago</h4></li>
                    <li class="collection-item">
                        <div>
                            {{-- <i class="icon-message circle"></i> --}}
                            <span class="title"><b>1: </b>Camisa normal</span><br>
                            <span><b>Ventas totales: </b>135</span>
                            <!-- <a href="#!" class="secondary-content" style="font-size:28px"><i class="icon-find_in_page"></i></a> -->
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span class="title"><b>Producto: </b>Camisa normal</span><br>
                            <span><b>Ventas totales: </b>135</span>
                            <!-- <a href="#!" class="secondary-content"><i class="icon-find_in_page"></i></a> -->
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span class="title"><b>Producto: </b>Camisa normal</span><br>
                            <span><b>Ventas totales: </b>135</span>
                            <!-- <a href="#!" class="secondary-content"><i class="icon-find_in_page"></i></a> -->
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span class="title"><b>Producto: </b>Camisa normal</span><br>
                            <span><b>Ventas totales: </b>135</span>
                            <!-- <a href="#!" class="secondary-content"><i class="icon-find_in_page"></i></a> -->
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span class="title"><b>Producto: </b>Camisa normal</span><br>
                            <span><b>Ventas totales: </b>135</span>
                            <!-- <a href="#!" class="secondary-content"><i class="icon-find_in_page"></i></a> -->
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span class="title"><b>Producto: </b>Camisa normal</span><br>
                            <span><b>Ventas totales: </b>135</span>
                            <!-- <a href="#!" class="secondary-content"><i class="icon-find_in_page"></i></a> -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/jquery.countTo.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>    
@endsection