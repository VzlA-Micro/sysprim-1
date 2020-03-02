@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquilla Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.vehicle.manage') }}">Gestionar
                            Vehículo</a></li>
                    <li class="breadcrumb-item"><a href="#">Registrar
                            Vehículos</a></li>
                </ul>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" class="card" id="vehicle-register-ticket">
                    <ul class="tabs">
                        <li class="tab col s6" id="user-tab-one"><a href="#user-tab"><i class="icon-filter_1"></i>Usuario
                                Web</a></li>
                        <li class="tab col s6 disabled" id="two"><a href="#vehicle-tab"><i
                                        class="icon-filter_2"></i> Datos del vehículo</a></li>
                    </ul>
                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h5>Datos Generales</h5>
                        </div>
                        <div class="card-content row">
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="V: Venezolano<br>E: Extranjero<br>J: Juridico">
                                <i class="icon-public prefix"></i>
                                <select name="type_document" id="type_document_full" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="J">J</option>
                                    <option value="G">G</option>
                                    <!--<option value="J">J</option>-->
                                </select>
                                <label for="type_document_full">Documento</label>
                            </div>
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="document_full" type="text" name="document_full" data-validate="documento" maxlength="8" class="validate number-date rate" pattern="[0-9]+" title="Solo puede escribir números." required>
                                <label for="document_full">Identificación</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name_full" type="text" name="name_full" class="validate rate" data-validate="nombre"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)." required>
                                <label for="name_full">Nombre</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="email_full" type="email" name="email" class="validate rate" data-validate="email"  title="Solo puede agregar letras (con acentos)." required >
                                <label for="email_full">Correo</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-directions prefix"></i>
                                <textarea name="address" id="address_full" cols="30" rows="12" data-validate="direccion" class="materialize-textarea rate" required></textarea>
                                <label for="address_full">Dirección</label>
                            </div>
                            <input id="surname" type="hidden" name="surname" class="validate" value="">
                            <input id="user_name" type="hidden" name="name_user" class="validate" value="">


                            <div class="input-field col s12" id="condition">
                                <i class="icon-person prefix"></i>
                                <select name="status_view" id="status_view" required>
                                    <option value="null" disabled selected>Selecciona Condicion</option>
                                    <option value="propietario" >Propietario</option>
                                    <option value="responsable">Responsable</option>
                                </select>
                                <label for="status_view">Condición Legal</label>
                            </div>

                            <div id="content">

                            </div>
                        </div>
                        <div class="card-footer right-align">
                            <a href="#" id='data-next' class="btn peach waves-effect waves-light">
                                Siguiente
                                <i class="icon-navigate_next right"></i>
                            </a>
                        </div>
                    </div>
                    <div id="vehicle-tab">
                        <div class="card-header center-align">
                            <h4>Datos del Vehículo</h4>
                        </div>

                        <input type="hidden" name="id" value="" id="id">
                        <input type="hidden" name="person_id" value="" id="person_id" >
                        <input type="hidden" name="status" value="" id="status" >
                        <input type="hidden" name="type" value="" id="type">
                        <div class="card-content row">
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Ej: L1S2M3">
                                <i class="icon-crop_16_9 prefix"></i>
                                <input type="text" name="license_plates" id="license_plates" minlength="7" maxlength="7"
                                       pattern="[0-9A-Za-z]+" autocomplete="off"
                                       title="Solo puede escribir números y letra en mayúsculas." class="validate"
                                       required>
                                <label for="license_plates">Placa</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="icon-airport_shuttle prefix"></i>
                                <select name="typeV" id="typev" required>
                                    {{--<option value="null" disabled selected>Selecciona el tipo de vehiculo</option>--}}
                                    @foreach($type as $types)
                                        <option value="{{$types->id}}">{{$types->name}}</option>
                                    @endforeach
                                </select>
                                <label for="typeV">Tipo De Vehiculo</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="bodySerials" id="bodySerials" class="validate"
                                       pattern="[A-Za-z0-9]+" autocomplete="off"
                                       title="Solo puede escribir letras y numeros." minlength="12" maxlength="17"
                                       required>
                                <label for="bodySerials">Serial de carroceria</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-opacity prefix"></i>
                                <input type="text" name="color" id="color" class="validate" pattern="[A-Za-z]+"
                                       title="Solo puede escribir letras." minlength="2" maxlength="20" required>
                                <label for="color">Color</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-select_all prefix"></i>
                                <input type="text" name="serialEngines" id="serialEngines" class="validate"
                                       pattern="[A-Za-z0-9]+" title="Solo puede escribir letras y numeros."
                                       minlength="12" maxlength="20" autocomplete="off" required>
                                <label for="serialEngines">Serial del motor</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-event_note prefix"></i>
                                <input type="text" name="year" id="year" class="validate number-only" pattern="[0-9]+"
                                       minlength="4"
                                       maxlength="4"
                                       title="Solo puede escribir numeros." required>
                                <label for="year">Año</label>
                            </div>
                            <div id="group-MB">
                                <div class="input-field col s12 s6">
                                    <i class="icon-directions_car prefix"></i>
                                    <select name="brand" id="brand" required>
                                        <option value="null" disabled selected>Selecciona la marca</option>
                                        @foreach($brand as $brands)
                                            <option value="{{$brands->id}}">{{$brands->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="brand">Marca</label>
                                </div>
                                <div class="input-field col s12 s6">
                                    <i class="icon-local_shipping prefix"></i>
                                    <select name="model" id="model" required>
                                        <option value="null" disabled selected>Selecciona el módelo</option>
                                    </select>
                                    <label for="model">Módelo</label>
                                </div>
                            </div>
                            <div id="group-new-MB">

                            </div>
                            <div class="container">
                                <p><span class=""><b>NOTA: </b></span>En caso que la marca o modelo de su vehiculo no se
                                    encuentre registrado en nuestro sistema, presiona el botón de <b>REGISTRAR MARCA</b>
                                    e introduce los siguientes datos:<br> <b>1- Marca</b><br> <b>2- Modelo</b><br></p>
                            </div>
                            <div class="input-field col s12 center-align">
                                <a href="#" id="button-brand" class="btn btn-rounded blue waves-effect">Registrar Marca<i
                                            class="icon-file_upload right"></i></a>
                            </div>
                            <div class="col s6 left-align">
                                <a  id="vehicles-previous" class="btn btn-large btn-rounded peach waves-effect waves light truncate">
                                    Anterior
                                    <i class="icon-navigate_before left"></i>
                                </a>
                            </div>
                            <div class="col s6 right-align">
                                <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light"
                                        id="button-company">
                                    <i class="icon-send right"></i>
                                    <span class="truncate">Registrar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/vehicle-module.js') }}"></script>
    {{--<script src="{{ asset('js/dev/vehicleTicketOffice.js') }}"></script>--}}
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection