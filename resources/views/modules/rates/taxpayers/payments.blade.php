@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
					<li class="breadcrumb-item"><a href="{{route('rate.taxpayers.menu')}}">Gestión de Tasas</a></li>
					<li class="breadcrumb-item"><a href="{{route('rate.taxpayers.register')}}">Declarar Tasa</a></li>
					<li class="breadcrumb-item"><a href="{{route('rate.taxpayers.details',['id'=>$taxes_id])}}">Detalles de Autoliquidación</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
            	<div class="card payment-form ">
	            	<ul class="tabs">
				        <li class="tab col s4" id="one-payments"><a href="#payment-method"><i class="icon-filter_1"></i> Forma de Pago</a></li>
				        <li class="tab col s4 disabled" id="two-payments"><a href="#payment-bank"><i class="icon-filter_2"></i> Seleccionar Banco</a></li>
				        <li class="tab col s4 disabled" id="three-payments"><a href="#payment-receipt"><i class="icon-filter_3"></i> Obtener Planilla</a></li>
				    </ul>
					<div id="payment-method">
						<div class="card-content">
							<div class="row">
								<div class="card-header">
									<h4 class="center-align">Elige una forma de pago:</h4>
								</div>
								<div class="col s12 m4">
									<input type="radio" id="ppv" name="method" value="ppv" class="type_payment_event">
									<label class="btn-radio grey" for="ppv" >
										<i class="">
											<img src="{{ asset('images/png/001-point-of-service.png') }}"  style="height: 64px!important;width: 64px!important;" alt="Base Image" width="100%" height="100%">
										</i>
										<span class="truncate black-text">SEMAT(PUNTO DE VENTA)</span>
									</label>
								</div>
								<div class="col s12 m4">
									<input type="radio" id="ppt" name="method" value="ppt" class="type_payment_event">
									<label class="btn-radio grey" for="ptb">
										<i class="">
											<img src="{{ asset('images/png/009-smartphone-1.png') }}" style="height: 64px!important;width: 64px!important;" alt="Smartphone Image" width="100%" height="100%">
										</i>
										<span class="truncate black-text">Transferencia Bancaria</span>
									</label>
								</div>
								<div class="col s12 m4">
									<input type="radio" id="ppb" name="method" value="ppb" class="type_payment_event" >
									<label class="btn-radio grey" for="ppb">
										<i class="">
											<img src="{{ asset('images/png/030-bank.png') }}" style="height: 64px!important;width: 64px!important;" alt=" bank Image" width="100%" height="100%">
										</i>
										<span class="truncate black-text">Deposito Bancario</span>
									</label>
								</div>
							</div>



							<div class="row">

							</div>


						</div>
					</div>
					<div id="payment-bank">
						<div class="card-content">
							<div class="card-header">
								<h4 class="center-align">Seleciona el banco:</h4>
							</div>
							<div class="row">
								<div class="col s12 m6">
									<input type="radio" id="banesco" name="method" value="55" class="bank-div">
									<label class="btn-radio banesco-green" for="banesco">
										<i class="i-banesco-logo"></i>
									</label>
								</div>
								<div class="col s12 m6">
									<input type="radio" id="bnc" name="method" value="99" class="bank-div">
									<label class="btn-radio bnc-blue" for="bnc">
										<i class="i-bnc"></i>
									</label>
								</div>
								<div class="col s12 m6" id="bod-div">
									<input type="radio" id="bod" name="method" value="44" class="bank-div">
									<label class="btn-radio bod-green" for="bod">
										<i class="i-bod"></i>
									</label>
								</div>

								<div class="col s12 m6">
									<input type="radio" id="percent-banco" name="method" value="33" class="bank-div">
									<label class="btn-radio x100-banco-yellow" for="percent-banco">
										<i class="i-percent-banco"></i>
									</label>
								</div>
							</div>
							<div class="row">
                                <div class="col s6 left-align">
                                    <a href="#" class="btn peach waves-effect waves-light" id="previous-bank">
                                        <i class="icon-navigate_before left"></i>
                                        Anterior
                                    </a>
                                </div>
                                <div class="col s6 right-align">

                                </div>
                            </div>
						</div>
					</div>
					<div id="payment-receipt">
						<div class="card-content">
							<div class="card-header">
								<h4 class="center-align">Obtener Planilla:</h4>
							</div>
							<div class="row">
								@can('Obtener Mi Planilla')
								<div class="col s12 m6 offset-m3 center-align" id="div-send"  >
									<a href="#" class="btn-app green" >
										<i class="far fa-file-pdf"></i>
										<span class="truncate">Obtener Planilla</span>
									</a>
								</div>
								@endcan
							</div>
							<div class="row">
								<div class="col s6 left-align">
									<a href="#" class="btn peach waves-effect waves-light" id="previous-receipt">
										<i class="icon-navigate_before left"></i>
										Anterior
									</a>
								</div>
								<div class="col s6 right-align">

								</div>
							</div>
						</div>
					</div>
            	</div>

				<form id="form-payment" method="POST" action="{{route('rate.taxpayers.paymentStore')}}">
					<input type="hidden" class="#" name="type_payment" id="type_payment" >
					<input type="hidden" class="#" name="bank_payment" id="bank_payment" >
					<input type="hidden" class="#" name="id_taxes" id="id_taxes"  value="{{$taxes_id}}">
				</form>


            </div>
        </div>
    </div>
@endsection

@section('scripts')
	<script src="{{asset('js/dev/taxes-definitive.js')}}"></script>
@endsection