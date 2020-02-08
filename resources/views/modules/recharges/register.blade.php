@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.manage') }}">Gestionar Recargos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.register') }}">Registrar Recargo</a></li>
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
                            <input type="text" name="since" id="since" class="datepicker" required>
                            <label for="since">Desde</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>
                            <input type="text" name="to" id="to" class="datepicker" required>
                            <label for="to">Hasta</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-text_fields prefix"></i>
                            <input type="text" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Solo puede escribir números y letra en mayúsculas." class="validate" minlength="5" maxlength="30" required>
                            <label for="name"> Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only only-number-positive"  maxlength="2"  required>
                            <label for="value">Valor</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-nature  prefix"></i>
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