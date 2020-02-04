@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.vehicles') }}">Gestionar Tipos De Vehiculos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.register') }}">Registrar Tipos De Vehiculos</a></li>
                </ul>
            </div>

            <form method="post" action="#"  class="col s12 m8 offset-m2" enctype="multipart/form-data"  id="register">
                @csrf
                <div class="card">
                    <div class="card-header center-align">
<<<<<<< HEAD
                        <h5>Registrar Tipo de Vehículo</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: Carga">
                            <i class="icon-motorcycle prefix"></i>
=======
                        <h5>Registrar  Tipo  de Vehículo</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: Carga">
                            <i class="icon-merge_type prefix"></i>

>>>>>>> 5dee84feb1ed1e3be3105366a08c3c4bc917256d
                            <input type="text" name="type_vehicle" id="type_vehicle" pattern="[a-zA-Z ]+"
                                   title="Solo puede escribir números y letra en mayúsculas." minlength="3" maxlength="100" class="validate" required>
                            <label for="type_vehicle">Tipo de vehiculo</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-swap_vert prefix"></i>
                            <input type="text" name="rate" id="rate" class="validate number-only-float" pattern="[A-Za-z0-9,.]+"
                                   title="Solo puede escribir letras y numeros."  maxlength="2" required>
                            <label for="rate">Tarifa menor a 3 años(U.T).</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-swap_vert prefix"></i>
                            <input type="text" name="rate_ut" id="rate_ut" class="validate  only-number-positive" pattern="[A-Za-z0-9,.]+"
                                   title="Solo puede escribir letras." required maxlength="5">
                            <label for="rate_ut">Tarifa mayor a 3 años(U.T)</label>
                        </div>
                        <div class="input-field col s12 center-align">
                            <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                                <i class="icon-send right"></i>Registrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/dev/typeVehicle.js') }}"></script>
@endsection