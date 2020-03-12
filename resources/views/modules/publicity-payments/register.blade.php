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
                    @if(session()->has('company'))
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => session('company')->id]) }}">{{ session('company')->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.details', ['id' => $publicity->id]) }}">{{ $publicity->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.payments.manage', ['id' => $publicity->id]) }}">Mis Declaraciones</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.payments.create', ['id' => $publicity->id]) }}">Declarar Publicidad</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                @if($statusTax == 'process')
                    <div class="card center-align col s12">
                        <h5>Pago Declarado</h5>
                        <h1><i class="icon-access_alarms orange-text"></i></h1>
                        <p>Ya has declarado tu pago, actualmete se encuentra en proceso de verificación.</p>
                    </div>
                @elseif($statusTax == 'verified')
                    <div class="card center-align col s12">
                        <h5>Pago Verificado</h5>
                        <h1><i class="icon-check green-text"></i></h1>
                        <p>Su pago ha sido verificado éxitosamente.</p>
                    </div>
                @else
            	<form method="post" action="" class="card" enctype="multipart/form-data" id="register">
                    <div class="card-header center-align">
            			<h4>Resumen de Autoliquidación</h4>
                        
                    </div>
                    <div class="card-content row">
                        <div class="col s12 m6">
                            <ul>
                                @if($owner_type == 'user')
                                    <li><b>Propietario: </b>{{ $owner->name . ' ' . $owner->surname }}</li>
                                    <li><b>Cédula: </b>{{ $owner->ci }}</li>
                                @elseif($owner_type == 'company')
                                    <li><b>Propietario: </b>{{ $owner->name }}</li>
                                    <li><b>RIF: </b>{{ $owner->RIF }}</li>
                                @endif
                                <li><b>Código de Publicidad: </b>{{ $publicity->code }}</li>
                                    {{-- <li><b>Tipo de Publicidad </b>{{ $publicity->advertisingType->name }}</li> --}}
                                <li><b>Nombre: </b>{{ $publicity->name }}</li>

                            </ul>
                        </div>
                        <div class="col s12 m6">
                            <ul>
                                <li><b>Fecha de Inicio: </b>{{ $publicity->date_start }}</li>
                                <li><b>Fecha de Fin: </b>{{ $publicity->date_end }}</li>
                                {{--<li><b>Direccion: </b>{{ $property[0]->address }}</li>--}}
                                {{--<li><b>Periodo Fiscal: {{ $response['period'] }} </b></li>--}}
                            </ul>
                        </div>
                    </div>
            		<div class="card-header center-align">
                        <h4>Detalles del Impuesto</h4>
            		</div>
            		<div class="card-content row">
            			@csrf
                        <input type="hidden" name="publicity_id" id="publicity_id" value="{{ $publicity->id }}">
                        <input type="hidden" name="type" id="type" value="{{ $taxeType }}">
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
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="Image" width="100%" height="100%">
                            </i>
                            <input type="text" name="base_imponible" id="base_imponible" value="{{ $baseImponible }}" readonly required>
                            <label for="base_imponible">Base Imponible<b> (Bs)</b></label>
                        </div>
                        {{--<div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="interest" id="interest" class="validate money" value="{{ $interest }}" readonly>
                            <label for="interest">Interés por Mora:(Bs)</label>
                        </div>--}}
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="increment" id="increment" class="validate money" value="{{ $increment }}" readonly required>
                            <label for="increment">Incremento</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input type="text" name="fiscal_credit" id="fiscal_credit" class="validate money_keyup">
                            <label for="fiscal_credit">Crédito Fiscal</label>
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
                                                @if($publicity->advertisingType->id == 1)
                                                    <th>DÍAS DE EXHIBICIÓN</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $publicity->advertisingType->name }}</td>
                                                <td>{{ $publicity->advertisingType->value }}</td>
                                                @if($publicity->advertisingType->id == 1)
                                                    <td>{{ $daysDiff }}</td>
                                                @endif
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
                                    @if($publicity->licor == "SI")
                                    <table class="centered responsive-table" style="font-size: 10px;!important;">
                                        <thead>
                                            <tr>
                                                <th>REFERENTE A LICORES O CIGARRILLOS</th>
                                                <th>TARIFA (U.T)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $publicity->licor }}</td>
                                                <td>5000UT</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @endif
                                    @if($publicity->state_location == "SI")
                                    <table class="centered responsive-table" style="font-size: 10px;!important;">
                                        <thead>
                                        <tr>
                                            <th>UBICADO EN ESPACIOS RESERVADOS DE LA ALCALDÍA</th>
                                            <th>TARIFA (U.T)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{ $publicity->state_location }}</td>
                                            <td>5000UT</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @endif
                                </div>
                                <div class="col s12 m6">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input type="text" name="amount" id="amount" class="validate" value="{{ $amount }}" readonly>
                                            <label for="amount">Total a Pagar:(Bs)</label>
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
                @endif
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