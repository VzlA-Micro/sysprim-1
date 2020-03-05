@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.vehicle') }}">Configuración de Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.brand.manage') }}">Gestionar Marcas De Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.brand.register') }}">Registrar Marcas De Vehículos</a></li>
                </ul>
            </div>

            <form method="#" action="#" class="col s12 m8 offset-m2"
                  enctype="multipart/form-data" id="register">
                {{csrf_field()}}
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Marcas De Vehículos</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 tooltipped" data-position="bottom" data-tooltip="Ej: Toyota">
                            <i class="icon-time_to_leave prefix"></i>
                            <input type="text" name="brand" id="brand" pattern="[a-zA-Z0-9 ]+"
                                   title="Solo puede escribir números y letra en mayúsculas." class="validate" maxlength="40" minlength="2" required>
                            <label for="brand"> Marca de Vehículo</label>
                        </div>
                        <div class="input-field col s12 center-align">
                            <button type="submit" id="brandRegister" class="btn btn-rounded btn-large peach waves-effect">
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
    <script src="{{ asset('js/dev/brandVehicle.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection