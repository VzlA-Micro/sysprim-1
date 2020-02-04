@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.vehicles') }}">Gestionar Tipos De Vehiculos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('type-vehicles.read') }}">Ver Tipos De Vehiculos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('typeVehicle.details') }}">Detalles De Tipo De Vehiculos</a></li>
                </ul>
            </div>
            <div class="col s12 m10 l8 offset-m1 offset-l2">
                <form id="updateType"  method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles De Tipo De Vehiculo</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <!--<div class="input-field col s12">

                        </div>-->
                        <input id="id" type="hidden" name="id" value="{{ $type->id }}">

                        <div class="input-field col s12">
                            <i class="icon-check prefix"></i>
                            <input id="name" type="text" name="name" readonly value="{{ $type->name }}" minlength="3" maxlength="100" required>
                            <label for="name">Tipo de vehiculo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <input id="rate" type="text" name="rate" readonly value="{{ $type->rate }}" maxlength="2" required>
                            <label for="name">Tarifa U.T menor a 3 años</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input id="rate_ut" type="text" name="rate_ut" readonly maxlength="5"  class="only-number-positive" value="{{ $type->rate_UT}}"  required>
                            <label for="rate_ut">Tarifa U.T mayor a 3 años</label>
                        </div>
                    </div>
                    <div class="card-action center">
                        @can('Actualizar Tipos de Vehiculos')

                            <a id="btn-modify" class="btn btn-large btn-rounded blue waves-effect waves-light">
                                <i class="icon-update right"></i>
                                Modificar
                            </a>
                            <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="btn-update">
                                <i class="icon-save right"></i>
                                Guardar
                            </button>

                        @endcan
                        {{--<a href="#" class="btn btn-rounded red waves-effect waves-light">Eliminar</a>--}}
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/typeVehicle.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection