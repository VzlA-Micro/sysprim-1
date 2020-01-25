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
                    <li class="breadcrumb-item"><a href="{{ route('rate.manager') }}">Gestionar Tasas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rate.register') }}">Registrar</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" id="register">
                    <div class="card-header center-align">
                        <h4>Registrar Tasa</h4>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input id="code" type="text" name="code" required minlength="3" maxlength="10">
                            <label for="code">Código</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-class prefix"></i>
                            <input id="name" type="text" name="name" required minlength="3" maxlength="100">
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="icon-perm_contact_calendar prefix"></i>
                            <select name="type" id="type">
                                <option value="null" selected disabled>Elija un Ramo</option>
                                <option value="Act.Eco">Actividad Ecónomica</option>
                                <option value="Pat.Vehiculo">Patente De Vehículo</option>
                                <option value="Inmueble.Urb">Inmuebles Urbanos</option>
                                <option value="tasas">Tasa y Certificaciones</option>
                            </select>
                            <label for="type">Ramo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-format_list_numbered prefix"></i>
                            <input id="cant_tax_unit" type="text" name="cant_tax_unit" class="validate number-only" required>
                            <label for="cant_tax_unit">Cantidad de Unidad Tributarias</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-import_export prefix"></i>
                            <select name="status" id="status">
                                <option value="null" selected disabled>Elija un estado</option>
                                <option value="active">Activar</option>
                                <option value="disabled">Desactivar</option>
                            </select>
                            <label for="status">Estado</label>
                        </div>


                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/rate-module.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection