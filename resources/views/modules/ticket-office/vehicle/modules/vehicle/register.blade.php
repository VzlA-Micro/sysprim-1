@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla Vehículo</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.manage') }}">Gestionar Vehículo</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tickOffice.companies.register') }}">Registrar
                            Vehículos</a></li>
                </ul>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" method="post" class="card" id="vehicle-register-ticket">
                    <ul class="tabs">
                        <li class="tab col s6" id="user-tab-one"><a href="#user-tab"><i class="icon-filter_1"></i>Usuario
                                Web</a></li>
                        <li class="tab col s6 disabled" id="vehicle-tab-two"><a href="#company-tab"><i
                                        class="icon-filter_2"></i> Datos del vehículo</a></li>
                    </ul>
                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h4>Usuario Web</h4>
                        </div>
                        <div class="card-content row">
                            <input type="hidden" name="user_id" value="" id="user_id">
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom"
                                 data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="nationality" id="nationality" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                </select>

                                <label for="nationality">Nacionalidad</label>
                            </div>
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="ci" type="text" name="ci" maxlength="8" class="validate number-only"
                                       pattern="[0-9]+" title="Solo puede escribir números." required>
                                <label for="ci">Cedula</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name_user" type="text" name="name_user" class="validate"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)." required readonly>
                                <label for="name_user">Nombre</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="surname" type="text" name="surname" class="validate"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)." required readonly>
                                <label for="surname">Apellido</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Ej: correo@mail.com" readonly>
                                <i class="icon-mail_outline prefix"></i>
                                <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}"
                                       required readonly>
                                <label for="email">E-mail</label>
                            </div>
                            <div class="input-field col s12 right-align">
                                <a href="#" id='user-next' class="btn peach waves-effect waves-light">
                                    Siguiente
                                    <i class="icon-navigate_next right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="company-tab">
                        <div class="card-header center-align">
                            <h4>Datos del Vehículo</h4>
                        </div>
                        <div class="card-content row">
                            <div class="input-field col s12">
                                <i class="icon-person prefix"></i>
                                <select name="status" id="status" required>
                                    {{--<option value="null" disabled selected>Selecciona Condicion</option>--}}
                                    <option value="propietario">Propietario</option>
                                    <option value="responsable">Responsable</option>
                                </select>
                                <label for="model">Condición Legal</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Ej: L1S2M3">
                                <i class="icon-crop_16_9 prefix"></i>
                                <input type="text" name="license_plate" id="license_plate" minlength="7" maxlength="7"
                                       pattern="[0-9A-Za-z]+"
                                       title="Solo puede escribir números y letra en mayúsculas." class="validate"
                                       required>
                                <label for="license_plate">Placa</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="icon-airport_shuttle prefix"></i>
                                <select name="type" id="type" required>
                                    {{--<option value="null" disabled selected>Selecciona el tipo de vehiculo</option>--}}
                                    @foreach($type as $types)
                                        <option value="{{$types->id}}">{{$types->name}}</option>
                                    @endforeach
                                </select>
                                <label for="type">Tipo De Vehiculo</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="bodySerial" id="bodySerial" class="validate"
                                       pattern="[A-Za-z0-9]+"
                                       title="Solo puede escribir letras y numeros." required>
                                <label for="bodySerial">Serial de carroceria</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-opacity prefix"></i>
                                <input type="text" name="color" id="color" class="validate" pattern="[A-Za-z]+"
                                       title="Solo puede escribir letras." required>
                                <label for="color">Color</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-select_all prefix"></i>
                                <input type="text" name="serialEngine" id="serialEngine" class="validate"
                                       pattern="[A-Za-z0-9]+" title="Solo puede escribir letras y numeros." required>
                                <label for="serialEngine">Serial del motor</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-event_note prefix"></i>
                                <input type="text" name="year" id="year" class="validate" pattern="[0-9]+" minlength="4"
                                       maxlength="4"
                                       title="Solo puede escribir numeros." required>
                                <label for="year">Año</label>
                            </div>
                            <div id="group-MB">
                                <div class="input-field col s6">
                                    <i class="icon-directions_car prefix"></i>
                                    <select name="brand" id="brand" required>
                                        <option value="null" disabled selected>Selecciona la marca</option>
                                        @foreach($brand as $brands)
                                            <option value="{{$brands->id}}">{{$brands->name}}</option>
                                        @endforeach

                                    </select>
                                    <label for="brand">Marca</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="icon-local_shipping prefix"></i>
                                    <select name="model" id="model" required>
                                        <option value="null" disabled selected>Selecciona el módelo</option>
                                    </select>
                                    <label for="model">Módelo</label>
                                </div>
                            </div>
                            <div id="group-new-MB">

                            </div>
                            <div class="input-field col s12 center-align">
                                <a href="#" id="button-brand" class="btn btn-rounded green waves-effect">Registrar Marca<i
                                            class="icon-file_upload right"></i></a>
                            </div>
                        </div>
                        <div class="input-field col s6 left-align">
                            <a href="#" id="company-previous" class="btn peach waves-effect waves light">
                                Anterior
                                <i class="icon-navigate_before left"></i>
                            </a>
                        </div>
                        <div class="input-field col s6 right-align">
                            <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light" id="button-company">
                                <i class="icon-send right"></i>
                                Registar
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/vehicle.js') }}"></script>
    <script src="{{ asset('js/dev/ticketOffice.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection