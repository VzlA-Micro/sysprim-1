@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/imagePreview.css') }}">

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.details', ['id' => $publicity->id]) }}">{{ $publicity->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Editar</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
            	<form method="post" action="{{ route('publicity.save') }}" class="card" enctype="multipart/form-data" id="register">
            		<div class="card-header center-align">
            			<h4>Registrar Publicidad</h4>
            		</div>
            		<div class="card-content row">
            			@csrf
            			<div class="input-field col s12">
            				<select name="advertising_type_id" id="advertising_type_id" multiple>
      							<option value="null" disabled selected>Elija un tipo</option>
      							@foreach($advertisingTypes as $type)
      							<option value="{{ $type->id }}" @if($publicity->advertising_type_id == $type->id){{ "selected" }} @endif>{{ $type->name }}</option>
      							@endforeach
      						</select>
    						<label>Tipo de Publicidad</label>
            			</div>
            			<div class="input-field col s12">
            				<input type="text" name="name" id="name" value="{{ $publicity->name }}">
            				<label for="name">Nombre</label>
            			</div>
            			{{-- <div class="input-field col s12 m6">
            				<input type="text" name="date_start" id="date_start" class="datepicker">
            				<label for="date_start">Fecha de Inicio</label>
            			</div>
            			<div class="input-field col s12 m6">
            				<input type="text" name="date_end" id="date_end" class="datepicker">
            				<label for="date_end">Fecha de Fin</label>
            			</div> --}}
            			<div class="col s12">
            				{{-- <img src="{{ asset('images/bqto-4.jpg') }}" class="responsive-img" alt=""> --}}
                            <div class="preview img-wrapper center-align valing-wrapper">
                                <i class="icon-add_a_photo medium"></i>
                            </div>
                            <div class="file-upload-wrapper">
                                <input type="file" name="image" id="image" class="file-upload-native" accept="image/*" />
                                <input type="text" disabled placeholder="Subir imagen" class="file-upload-text" />
                            </div>
           				</div>
                        {{-- <div class="col s12 input-field">
                            <select name="unit" id="unit">
                                <option value="null" disabled selected>Elige la unidad</option>
                                <option value="mts">Metro</option>
                                <option value="qnt">Cantidad</option>
                            </select>
                            <label>Unidad</label>
                        </div> --}}
                        <div id="content"></div>
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
    			max: 50,
    			min: 0,
    			grid: true,
    			step: 0.1,
    			postfix: ' m'
    		});
    
            var date = new Date();
            $('#date_end').datepicker({
                maxDate:  null,
                format: 'yyyy-mm-dd', // Configure the date format
                // yearRange: [1900,date.getFullYear()],
                showClearBtn: false,
                i18n: {
                    cancel: 'Cerrar',
                    clear: 'Reiniciar',
                    done: 'Hecho',
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
                }

            }); 
    	})
    </script>
    <script src="{{ asset('js/imagePreview.js') }}"></script>
    <script src="{{ asset('js/data/publicity.js') }}"></script>

@endsection