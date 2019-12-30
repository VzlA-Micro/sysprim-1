@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.register') }}">Registrar</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
            	<form method="post" action="" class="card" enctype="multipart/form-data">
            		<div class="card-header center-align">
            			<h4>Registrar Publicidad</h4>
            		</div>
            		<div class="card-content row">
            			@csrf
            			<div class="input-field col s12">
            				<select multiple>
      							<option value="null" disabled selected>Elija un tipo</option>
      							@foreach($advertisingTypes as $type)
      							<option value="{{ $type->id }}">{{ $type->name }}</option>
      							@endforeach
      						</select>
    						<label>Tipo de Publicidad</label>
            			</div>
            			<div class="input-field col s12">
            				<input type="text" name="name" id="name">
            				<label for="name">Nombre</label>
            			</div>
            			<div class="input-field col s12 m6">
            				<input type="text" name="date_start" id="date_start" class="datepicker">
            				<label for="date_start">Fecha de Inicio</label>
            			</div>
            			<div class="input-field col s12 m6">
            				<input type="text" name="date_end" id="date_end" class="datepicker">
            				<label for="date_end">Fecha de Fin</label>
            			</div>
            			<div class="col s12">
            				<img src="{{ asset('images/bqto-4.jpg') }}" class="responsive-img" alt="">
           				</div>
            			<div class="col s12">
           					<label for="width">Ancho</label>
        					<input type="text" class="js-range-slider" name="width" id="width" value="">
            			</div>
            			<div class="col s12">
           					<label for="height">Alto</label>
        					<input type="text" class="js-range-slider" name="height" id="height" value="">
            			</div>
            			<div class="input-field col s12 m6"></div>
            			<div class="input-field col s12 m6"></div>
            		</div>
            		<div class="card-footer center-align">
            			<button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
            				<i class="icon-send right"></i>
            				Registrar
            			</button>
            		</div>
            	</form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/ion.rangeSlider.js') }}"></script>
    <script>
    	$(document).ready(function() {
    		$(".js-range-slider").ionRangeSlider({
    			skin: "modern",
    			max: 25,
    			min: 0,
    			grid: true,
    			step: 0.1,
    			postfix: ' m'
    		});
 
    	})
    </script>
@endsection