@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.vehicles') }}" class="breadcrumb">Gestionar Tipos De Vehiculos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.register') }}" class="breadcrumb">Registrar Tipos De Vehiculos</a></li>
                </ul>
            </div>
            <form method="post" action="{{url('/type-vehicles/save')}}" class="col s12 m8 offset-m2"
                  enctype="multipart/form-data" id="type">
                {{csrf_field()}}
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Tipo de Vehículo</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: Carga">
                            <i class="icon-motorcycle prefix"></i>
                            <input type="text" name="type_vehicle" id="type_vehicle" pattern="[a-zA-Z ]+"
                                   title="Solo puede escribir números y letra en mayúsculas." class="validate" required>
                            <label for="type_vehicle">Tipo de vehiculo</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-payment prefix"></i>
                            <input type="text" name="rate" id="rate" class="validate" pattern="[A-Za-z0-9,.]+"
                                   title="Solo puede escribir letras y numeros." required>
                            <label for="rate">Tarifa %</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-payment prefix"></i>
                            <input type="text" name="rate_ut" id="rate_ut" class="validate" pattern="[A-Za-z0-9,.]+"
                                   title="Solo puede escribir letras." required>
                            <label for="rate_ut">Tarifa U.T</label>
                        </div>
                        <div class="input-field col s12 center-align">
                            <button type="submit" class="btn btn-large btn-rounded peach waves-effect">Registrar
                            <i class="icon-send right"></i>
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
@endsection