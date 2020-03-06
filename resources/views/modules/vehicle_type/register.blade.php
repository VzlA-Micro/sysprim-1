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
                    <li class="breadcrumb-item"><a href="{{ route('settings.vehicle') }}">Configuración de Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.vehicles') }}">Gestionar Tipos De Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.register') }}">Registrar Tipos De Vehículos</a></li>
                </ul>
            </div>

            <form method="post" action="#"  class="col s12 m8 offset-m2" enctype="multipart/form-data"  id="register">
                @csrf
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Tipo de Vehículo</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m12 tooltipped" data-position="bottom" data-tooltip="Ej: Carga">
                            <i class="icon-motorcycle prefix"></i>
                            <input type="text" name="type_vehicle" id="type_vehicle" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ0-9 ]+"
                                   title="Solo puede escribir números y letra en mayúsculas." minlength="3" maxlength="50" class="validate" required>
                            <label for="type_vehicle">Tipo de Vehículo</label>
                        </div>

                        {{--<div class="input-field col s12 m6">
                            <i class="icon-swap_vert prefix"></i>
                            <input type="text" name="rate" id="rate" class="validate number-only-positve number-date" pattern="[A-Za-z0-9,.]+"
                                   title="Solo puede escribir letras y numeros."  maxlength="5" required>
                            <label for="rate">Tarifa menor a 3 años(U.T).</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-swap_vert prefix"></i>
                            <input type="text" name="rate_ut" id="rate_ut" class="validate  only-number-positive number-date" pattern="[A-Za-z0-9,.]+"
                                   title="Solo puede escribir letras." required maxlength="5">
                            <label for="rate_ut">Tarifa mayor a 3 años(U.T)</label>
                        </div>
                        --}}
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