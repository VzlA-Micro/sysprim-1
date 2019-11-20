@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Empresa</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Pagar Impuestos</a>
                <a href="" class="breadcrumb">Detalles de Pago</a>
            </div>
            <div class="col s12 m10 offset-m1">
            	<form class="card payment-form">
	            	<ul class="tabs">
				        <li class="tab col s4"><a href="#payment-method"><i class="icon-filter_1"></i> Forma de Pago</a></li>
				        <li class="tab col s4"><a href="#payment-bank"><i class="icon-filter_2"></i> Seleccionar Banco</a></li>
				        <li class="tab col s4"><a href="#payment-receipt"><i class="icon-filter_3"></i> Obtener Recibo</a></li>
				    </ul>
					<div id="payment-method">
						<div class="card-content">
							<div class="row">
								<div class="col s12 m4">
									<input type="radio" id="ppv" name="method" value="">
									<label class="btn-radio peach" for="ppv">
										<i class="">
											<img src="{{ asset('images/png/001-point-of-service.png') }}" alt="">
										</i>
										<span class="truncate black-text">Taquilla SEMAT</span>
									</label>
								</div>
								<div class="col s12 m4">
									<input type="radio" id="ptb" name="method" value="">
									<label class="btn-radio peach" for="ptb">
										<i class="">
											<img src="{{ asset('images/png/009-smartphone-1.png') }}" alt="">
										</i>
										<span class="truncate black-text">Transferencia Bancaria</span>
									</label>
								</div>
								<div class="col s12 m4">
									<input type="radio" id="ppb" name="method" value="">
									<label class="btn-radio peach" for="ppb">
										<i class="">
											<img src="{{ asset('images/png/030-bank.png') }}" alt="">
										</i>
										<span class="truncate black-text">Punto de Venta</span>
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col s12 right-align">
									<a href="" class="btn peach waves-effect waves-light">
										<i class="icon-navigate_next right"></i>
										Siguiente
									</a>
								</div>
							</div>
						</div>
					</div>
					<div id="payment-bank">
						<div class="card-content">
							<div class="row">
								<div class="col s12 m4">
									<input type="radio" id="banesco" name="method" value="">
									<label class="btn-radio banesco-green" for="banesco">
										<i class="i-banesco-logo"></i>
									</label>
								</div>
								<div class="col s12 m4">
									<input type="radio" id="bnc" name="method" value="">
									<label class="btn-radio bnc-blue" for="bnc">
										<i class="i-bnc"></i>
									</label>
								</div>
								<div class="col s12 m4">
									<input type="radio" id="bod" name="method" value="">
									<label class="btn-radio bod-green" for="bod">
										<i class="i-bod"></i>
									</label>
								</div>
								<div class="col s12 m4">
									<input type="radio" id="percent-banco" name="method" value="">
									<label class="btn-radio x100-banco-yellow" for="percent-banco">
										<i class="i-percent-banco"></i>
									</label>
								</div>
								<div class="col s12 m4">
									<input type="radio" id="bicentenario" name="method" value="">
									<label class="btn-radio red darken-3" for="bicentenario">
										<i class="i-bicentenario"></i>
									</label>
								</div>
							</div>
							<div class="row">
                                <div class="col s6 left-align">
                                    <a href="#" class="btn peach waves-effect waves-light">
                                        <i class="icon-navigate_before left"></i>
                                        Anterior
                                    </a>
                                </div>
                                <div class="col s6 right-align">
                                    <a href="#" class="btn peach waves-effect waves-light" id="details-next">
                                        <i class="icon-navigate_next right"></i>
                                        Siguiente
                                    </a>
                                </div>
                            </div>
						</div>
					</div>
					<div id="payment-receipt">
						<div class="card-content">
							<div class="row">
								<div class="col s12 m6 offset-m3 center-align">
									<a href="" class="btn-app green">
										<i class="far fa-file-pdf"></i>
										<span class="truncate">Descargar PDF</span>
									</a>
								</div>
							</div>
						</div>
					</div>
            	</form>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection