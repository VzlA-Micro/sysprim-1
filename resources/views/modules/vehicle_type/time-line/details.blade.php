@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.vehicle') }}">Configuración de Vehículos</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.vehicles') }}">Gestionar Tipos De
                            Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('type-vehicle.timeline.manage') }}">Línea Del Tiempo -
                            Tipo De Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('type-vehicles.timeline.read') }}">Ver Línea Del
                            Tiempo</a></li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('type-vehicles.timeline.details',['id'=>$timeline->id]) }}">Detalles
                            Línea Del Tiempo</a></li>
                </ul>
            </div>
            <div class="col s12 m10 l8 offset-m1 offset-l2">
                <form id="update-timeline" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles De Línea De Tiempo</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <!--<div class="input-field col s12">

                        </div>-->
                        <input id="id" type="hidden" name="id" value="{{ $timeline->id }}">
                        <input id="id" type="hidden" name="typeVehicleId" value="{{ $timeline->type_vehicle_id}}">

                        <div class="input-field col s12">
                            <i class="icon-motorcycle prefix"></i>
                            <select name="type_vehicle" id="type_vehicle" disabled required>
                                <option value="{{$timeline->type_vehicle_id}}">{{$timeline->type->name}}</option>
                            </select>
                            <label for="type_vehicle">Tipo de vehículo</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-swap_vert prefix"></i>
                            <input type="text" name="rate" id="rate" value="{{$timeline->rate}}"
                                   class="validate number-only-positve number-date"
                                   pattern="[A-Za-z0-9,.]+"
                                   title="Solo puede escribir letras y numeros." maxlength="5" disabled required>
                            <label for="rate">Tarifa menor a 3 años(U.T).</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-swap_vert prefix"></i>
                            <input type="text" name="rate_ut" id="rate_ut"
                                   class="validate  only-number-positive number-date" disabled
                                   value="{{$timeline->rate_UT}}" pattern="[A-Za-z0-9,.]+"
                                   title="Solo puede escribir letras." required maxlength="5">
                            <label for="rate_ut">Tarifa mayor a 3 años(U.T)</label>
                        </div>


                        {{--<div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>
                            <input type="text" name="since" disabled id="dateStart" value="{{$timeline->since}}" class="datepicker">
                            <label for="date_start">Fecha de Inicio</label>
                        </div>--}}

                        @php
                            $cont=(int)date('Y');
                        $cont--;

                        @endphp

                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>
                            <select name="since" id="dateStart" disabled>
                                <option value="null" selected disabled>Seleccione</option>
                                @while($cont <= 2030)

                                    @if($timeline->since==$cont.'-01-01')
                                        <option value="{{$cont.'-01-01'}}" selected>{{$cont}}</option>
                                    @else
                                        <option value="{{$cont.'-01-01'}}">{{$cont}}</option>
                                    @endif

                                    @php $cont++; @endphp
                                @endwhile
                            </select>
                            <label for="since">Año</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>
                            <input type="text" name="date_end" disabled value="{{$timeline->to}}" id="dateEnd"
                                   class="datepicker">
                            <label for="date_end">Fecha de Fin</label>
                        </div>
                    </div>
                    @can('Actualizar Linea de Tiempo')
                    <div class="card-action center">

                            <a id="btn-modify" class="btn btn-large btn-rounded blue waves-effect waves-light">
                                <i class="icon-update right"></i>
                                Modificar
                            </a>
                            <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide"
                                    id="btn-update">
                                <i class="icon-save right"></i>
                                Guardar
                            </button>

                        {{--<a href="#" class="btn btn-rounded red waves-effect waves-light">Eliminar</a>--}}
                    </div>
                    @endcan

                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/data/timeline-type-vehicle.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection