@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.models.vehicles') }}" class="breadcrumb">Gestionar Modelos De Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.models.read') }}" class="breadcrumb">Ver Modelos De Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.models.details') }}" class="breadcrumb">Detalles De Modelo De Vehículo</a></li>
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
                        <input id="id" type="hidden" name="id" value="{{ $models->id }}">

                        <div class="input-field col s12">
                            <i class="icon-check prefix"></i>
                            <input id="name" type="text" name="name" readonly value="{{ $models->name }}">
                            <label for="name">Modelo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <input id="year" type="text" name="year" readonly value="{{ $models->year }}">
                            <label for="year">Año</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input id="brand" type="text" name="brand" readonly value="{{ $models->brand->name}}">
                            <label for="brand">Marca</label>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button type="submit"  class="btn btn-rounded green waves-effect waves-light">Actualizar</button>
                        <a href="#" class="btn btn-rounded red waves-effect waves-light">Eliminar</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/modelsVehicle.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection