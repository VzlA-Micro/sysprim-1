@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.manage') }}" class="breadcrumb">Gestionar Recargos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.register') }}" class="breadcrumb">Registrar Recargo</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" enctype="multipart/form-data" id="register">
                    @csrf
                    <div class="card-header center-align">
                        <h4>Registrar Recargo</h4>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <i class="icon-perm_contact_calendar prefix"></i>
                            <input type="text" name="since" id="since" class="datepicker">
                            <label for="since">Desde</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-perm_contact_calendar prefix"></i>
                            <input type="text" name="to" id="to" class="datepicker">
                            <label for="to">Hasta</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-time_to_leave prefix"></i>
                            <input type="text" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Solo puede escribir números y letra en mayúsculas." class="validate" required>
                            <label for="name"> Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-time_to_leave prefix"></i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only" required>
                            <label for="value">Valor</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-perm_contact_calendar prefix"></i>
                            <select name="branch" id="branch">
                                <option value="null" selected disabled>Elija un ramo</option>
                                <option value="Act.Eco">Actividad Economica</option>
                                <option value="Pat.Vehiculo">Patente De Vehículo</option>
                                <option value="Inmueble.Urb">Inmuebles Urbanos</option>
                                <option value="Publicidad">Publicidad</option>
                                <option value="Espectaculo">Espectaculos</option>
                            </select>
                            <label for="branch">Ramo</label>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/recharges.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection