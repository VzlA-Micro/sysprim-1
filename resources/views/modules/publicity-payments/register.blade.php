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
                    <li class="breadcrumb-item"><a href="{{ route('publicity.payments.manage', ['id' => $publicity->id]) }}">Mis Declaraciones</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.payments.create', ['id' => $publicity->id]) }}">Declarar Publicidad</a></li>

                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
            	<form method="post" action="" class="card" enctype="multipart/form-data" id="register">
                    <div class="card-header center-align">
            			<h4>Resumen de Autoliquidación</h4>
                        
                    </div>
                    <div class="card-content row">
                        <div class="col s12 m6">
                            <ul>
                                {{-- <li><b>Tipo de Publicidad </b>{{ $publicity->advertisingType->name }}</li> --}}
                                <li><b>Nombre: </b>{{ $publicity->name }}</li>
                                <li><b>Fecha de Inicio: </b>{{ $publicity->date_start }}</li>
                                <li><b>Fecha de Fin: </b>{{ $publicity->date_end }}</li>
                            </ul>
                        </div>
                        <div class="col s12 m6"></div>
                    </div>
            		<div class="card-header center-align">
                        <h4>Detalles del Impuesto</h4>
            		</div>
            		<div class="card-content row">
            			@csrf
                        <input type="hidden" name="id" id="id" value="{{ $publicity->id }}">
            			<div class="input-field col s8 m9">
                            <i class="icon-confirmation_number prefix"></i>
                            <select name="advertising_type_id" id="advertising_type_id" disabled>
                                <option value="null" disabled selected>Elija un tipo</option>
                                @foreach($advertisingTypes as $type)
                                <option value="{{ $type->id }}" @if($publicity->advertising_type_id == $type->id){{ "selected" }} @endif>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <label>Tipo de Publicidad</label>
                        </div>
                        <div class="input-field col s4 m3">
                            <i class="icon-assignment prefix"></i>
                            <input type="text" name="value" id="value" value="{{ $publicity->advertisingType->value }}" readonly>
                            <label for="value">Valor U.T</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="base" id="base" value="{{ $baseImponible }}" readonly>
                            <label for="base">Base Imponible<b> (Bs)</b></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="tasa[]" id="tasa" class="validate" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                            <label for="tasa">Interés por Mora<b> (Bs)</b></label>
                        </div>
                        <div class="input-field col s12">
                            <div class="divider"></div>
                        </div>
                        <div class="col s12">
                            <div class="row">
                                <div class="col s12 m6">
                                    <table class="centered responsive-table" style="font-size: 10px;!important;">
                                        <thead>
                                            <tr>
                                                <th>TIPO DE PUBLICIDAD</th>
                                                <th>TARIFA (U.T)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $publicity->advertisingType->name }}</td>
                                                <td>{{ $publicity->advertisingType->value }}</td>
                                            </tr>
                                        </tbody>

                                        {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th>RECARGO</th>--}}
                                            {{--<th>VALOR</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tbody>--}}
                                        {{--<tr>--}}
                                            {{--<td>{{'20%'}}</td>--}}
                                            {{--<td>{{$recharge}}</td>--}}
                                        {{--</tr>--}}
                                        {{--</tbody>--}}
                                    </table>
                                </div>
                                <div class="col s12 m6">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input type="text" name="total" class="validate" value="" readonly>
                                            <label for="total_pagar">Total a Pagar:(Bs)</label>
                                        </div>
                                        <div class="col s12"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
            		</div>
            		<div class="card-footer center-align">
            			<button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
            				<i class="icon-send right"></i>
            				Declarar
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
    <script src="{{ asset('js/data/publicity-payments.js') }}"></script>
@endsection