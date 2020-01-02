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
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.brand.manage') }}" class="breadcrumb">Gestionar
                            Recargos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.brand.register') }}" class="breadcrumb">Registrar
                            Recargos</a></li>
                </ul>
            </div>

            <form method="#" action="#" class="col s12 m8 offset-m2"
                  enctype="multipart/form-data" id="register">
                {{csrf_field()}}
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Recargo</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: Toyota">
                            <i class="icon-time_to_leave prefix"></i>
                            <input type="text" name="name" id="name" pattern="[a-zA-Z0-9 ]+"
                                   title="Solo puede escribir números y letra en mayúsculas." class="validate" required>
                            <label for="name"> Nombre</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: Toyota">
                            <i class="icon-time_to_leave prefix"></i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+"
                                   title="Solo puede escribir números." class="validate" required>
                            <label for="brand"> Valor</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-perm_contact_calendar prefix tooltipped" data-position="bottom" data-tooltip=""></i>
                            <select name="branch" id="branch">
                                <option value="null" selected disabled>...</option>
                                <option value="Act.Economica">Actividad Economica</option>
                                <option value="Pat.Vehiculo">Patente De Vehiculo</option>
                                <option value="Inmueble.Urb">Inmuebles Urbano</option>
                                <option value="Espectaculo">Espectaculos</option>
                                <option value="Publicidad">Publicidad</option>

                            </select>
                            <label for="document_type">Documento</label>
                        </div>
                        <div class="input-field col s12 center-align">
                            <button type="submit" id="brandRegister" class="btn btn-rounded green waves-effect">
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