@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/imagePreview.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas
                        </a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.publicity.home') }}">Taquilla Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.managePublicity')}}">Gestionar Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.register')}}">Registrar
                            Publicidad</a></li>
                </ul>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" class="card" id="register">
                    <ul class="tabs">
                        <li class="tab col s4" id="user-tab-one">
                            <a href="#user-tab">
                                <i class="icon-filter_1"></i>
                                Usuario Web
                            </a>
                        </li>
                        <li class="tab col s4 disabled" id="two">
                            <a href="#typePublicity-tab">
                                <i class="icon-filter_2"></i>
                                Tipo de publicidad
                            </a>
                        </li>
                        <li class="tab col s4 disabled" id="there">
                            <a href="#publicity-tab">
                                <i class="icon-filter_2"></i>
                                Datos de publicidad
                            </a>
                        </li>
                    </ul>
                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h5>Datos Generales</h5>
                        </div>
                        <div class="card-content row">
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom"
                                 data-tooltip="V: Venezolano<br>E: Extranjero<br>J: Juridico">
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
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="document_full" type="text" name="document_full" data-validate="documento"
                                       maxlength="8" class="validate number-date rate" pattern="[0-9]+"
                                       title="Solo puede escribir números." required>
                                <label for="document_full">Identificación</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name_full" type="text" name="name_full" class="validate rate"
                                       data-validate="nombre"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)." required>
                                <label for="name_full">Nombre</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <i class="icon-directions prefix"></i>
                                <textarea name="address" id="address_full" cols="30" rows="12" data-validate="direccion"
                                          class="materialize-textarea rate" required></textarea>
                                <label for="address_full">Dirección</label>
                            </div>
                            <input id="surname" type="hidden" name="surname" class="validate" value="">
                            <input id="user_name" type="hidden" name="name_user" class="validate" value="">


                            <div class="input-field col s12 hide" id="condition">
                                <i class="icon-person prefix"></i>
                                <select name="status_view" id="status_view" required>
                                    <option value="null" disabled selected>Selecciona Condicion</option>
                                    <option value="propietario">Propietario</option>
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
                    <div id="typePublicity-tab">
                        <div class="card-header center-align">
                            <h4>Tipo de publicidad</h4>
                        </div>

                        <div class="card-content row">
                            <input type="hidden" name="id" value="" id="id">
                            <input type="hidden" name="person_id" value="" id="person_id">
                            <input type="hidden" name="status" value="" id="status">
                            <input type="hidden" name="type" value="" id="type">

                            <div class="col s12 m6 animated bounceIn">
                                <button type="button" id="f1" name="f1" style="border: none"
                                        class="btn-app white blue-text" value="4">
                                    <i class="icon-add_circle"></i>
                                    <span class="truncate">Publicidad eventual u ocacional</span>
                                </button>
                            </div>

                            <div class="col s12 m6 animated bounceIn">
                                <button type="button" id="f2" name="f2" style="border: none"
                                        class="btn-app white blue-text" value="1">
                                    <i class="icon-add_circle"></i>
                                    <span class="truncate">Publicidad por tiempo</span>
                                </button>
                            </div>

                            <div class="col s12 m4 animated bounceIn">
                                <button type="button" id="f3" name="f3" style="border: none"
                                        class="btn-app white blue-text" value="2">
                                    <i class="icon-add_circle"></i>
                                    <span class="truncate">Publicidad por tamaño</span>
                                </button>
                            </div>
                            <div class="col s12 m4 animated bounceIn">
                                <button type="button" id="f4" name="f4" style="border: none"
                                        class="btn-app white blue-text" value="3">
                                    <i class="icon-add_circle"></i>
                                    <span class="truncate">Publicidad por cantidad</span>
                                </button>
                            </div>
                            <div class="col s12 m4 animated bounceIn">
                                <button type="button" id="f5" name="f5" style="border: none"
                                        class="btn-app white blue-text" value="5">
                                    <i class="icon-add_circle"></i>
                                    <span class="truncate">Publicidad por vallas</span>
                                </button>
                            </div>

                            <div class="input-field col s6 left-align">
                                <a href="#" id="publicity-previous"
                                   class="btn peach waves-effect waves light">
                                    Anterior
                                    <i class="icon-navigate_before left"></i>
                                </a>
                            </div>
                            <div class="input-field col s6  right-align">
                                <a href="#" id='data1-next' class="btn peach waves-effect waves-light">
                                    Siguiente
                                    <i class="icon-navigate_next right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="publicity-tab">

                        <div class="card-header center-align">
                            <h4>Datos de la publicidad</h4>
                        </div>

                        <div class="card-content row" id="form-1">
                            <div class="input-field col s12">
                                <select name="advertising_type_id" id="type_id-1">
                                    <option value="null" disabled selected>Elija un tipo</option>
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12">
                                <input type="text" name="name" id="name">
                                <label for="name">Nombre</label>
                            </div>
                            <div class="col s12">
                                {{-- <img src="{{ asset('images/bqto-4.jpg') }}" class="responsive-img" alt=""> --}}
                                <div class="preview img-wrapper center-align valing-wrapper">
                                    <i class="icon-add_a_photo medium"></i>
                                </div>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="image" id="image" class="file-upload-native"
                                           accept="image/*"/>
                                    <input type="text" disabled placeholder="Subir imagen" class="file-upload-text"/>
                                </div>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_start" id="date_start" class="datepicker date_start">
                                <label for="date_start">Fecha de Inicio</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_end" id="date_end" class="datepicker">
                                <label for="date_end">Fecha de Fin</label>
                            </div>
                            <div class="col s12 input-field">
                                <i class="icon-straighten prefix"></i>
                                <select name="unit" id="unit">
                                    <option value="null" disabled>Elige la unidad</option>
                                    <option value="mts" selected>Metro</option>
                                    <option value="qnt" disabled>Cantidad</option>
                                </select>
                                <label>Unidad</label>
                            </div>
                            <div class="col s12">
                                <label for="width">Ancho</label>
                                <input type="text" class="js-range-slider width" name="width" id="width" value="">
                            </div>
                            <div class="col s12">
                                <label for="height">Alto</label>
                                <input type="text" class="js-range-slider height" name="height" id="height" value="">
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-exposure_plus_1 prefix"></i>
                                <input type="text" name="quantity" id="quantity">
                                <label for="quantity">Cantidad de Lugares</label>
                            </div>

                            <div class="input-field col s6 left-align">
                                <a href="#" id="publicity-previous"
                                   class="btn   peach waves-effect waves light">
                                    Anterior
                                    <i class="icon-navigate_before left"></i>
                                </a>
                            </div>
                            <div class="input-field col s6 right-align">
                                <button type="submit" class="btn peach waves-effect waves-light"
                                        id="button-publicity">
                                    <i class="icon-send right"></i>
                                    Registrar
                                </button>
                            </div>

                        </div>
                        <div class="card-content row" id="form-2">

                            <div class="input-field col s12">
                                <select name="advertising_type_id" id="type_id-2">
                                    <option value="null" disabled selected>Elija un tipo</option>
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name">
                                <label for="name">Nombre</label>
                            </div>
                            <div class="col s12">
                                {{-- <img src="{{ asset('images/bqto-4.jpg') }}" class="responsive-img" alt=""> --}}
                                <div class="preview img-wrapper center-align valing-wrapper">
                                    <i class="icon-add_a_photo medium"></i>
                                </div>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="image" id="image" class="file-upload-native"
                                           accept="image/*"/>
                                    <input type="text" disabled placeholder="Subir imagen" class="file-upload-text"/>
                                </div>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_start" id="date_start" class="datepicker date_start">
                                <label for="date_start">Fecha de Inicio</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_end" id="date_end" class="datepicker">
                                <label for="date_end">Fecha de Fin</label>
                            </div>
                            <div class="col s12 input-field">
                                <i class="icon-straighten prefix"></i>
                                <select name="unit" id="unit">
                                    <option value="null" disabled>Elige la unidad</option>
                                    <option value="mts" disabled>Metro</option>
                                    <option value="qnt" selected>Cantidad</option>
                                </select>
                                <label>Unidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-chrome_reader_mode prefix"></i>
                                <input type="text" name="quantity" id="quantity">
                                <label for="quantity">Ejemplares</label>
                            </div>

                            <div class="input-field col s6 left-align">
                                <a href="#" id="publicity-previous"
                                   class="btn   peach waves-effect waves light">
                                    Anterior
                                    <i class="icon-navigate_before left"></i>
                                </a>
                            </div>
                            <div class="input-field col s6 right-align">
                                <button type="submit" class="btn peach waves-effect waves-light"
                                        id="button-publicity">
                                    <i class="icon-send right"></i>
                                    Registrar
                                </button>
                            </div>

                        </div>
                        <div class="card-content row" id="form-3">
                            <div class="input-field col s12">
                                <select name="advertising_type_id" id="type_id-3">
                                    <option value="null" disabled selected>Elija un tipo</option>
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name">
                                <label for="name">Nombre</label>
                            </div>
                            <div class="col s12">
                                {{-- <img src="{{ asset('images/bqto-4.jpg') }}" class="responsive-img" alt=""> --}}
                                <div class="preview img-wrapper center-align valing-wrapper">
                                    <i class="icon-add_a_photo medium"></i>
                                </div>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="image" id="image" class="file-upload-native"
                                           accept="image/*"/>
                                    <input type="text" disabled placeholder="Subir imagen" class="file-upload-text"/>
                                </div>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_start" id="date_start" class="datepicker">
                                <label for="date_start">Fecha de Inicio</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_end" id="date_end" class="datepicker">
                                <label for="date_end">Fecha de Fin</label>
                            </div>

                            <div class="input-field col s6 left-align">
                                <a href="#" id="publicity-previous"
                                   class="btn   peach waves-effect waves light">
                                    Anterior
                                    <i class="icon-navigate_before left"></i>
                                </a>
                            </div>
                            <div class="input-field col s6 right-align">
                                <button type="submit" class="btn peach waves-effect waves-light"
                                        id="button-publicity">
                                    <i class="icon-send right"></i>
                                    Registrar
                                </button>
                            </div>

                        </div>
                        <div class="card-content row" id="form-4">
                            <div class="input-field col s12">
                                <select name="advertising_type_id" id="type_id-4">
                                    <option value="null" disabled selected>Elija un tipo</option>
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name">
                                <label for="name">Nombre</label>
                            </div>
                            <div class="col s12">
                                {{-- <img src="{{ asset('images/bqto-4.jpg') }}" class="responsive-img" alt=""> --}}
                                <div class="preview img-wrapper center-align valing-wrapper">
                                    <i class="icon-add_a_photo medium"></i>
                                </div>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="image" id="image" class="file-upload-native"
                                           accept="image/*"/>
                                    <input type="text" disabled placeholder="Subir imagen" class="file-upload-text"/>
                                </div>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_start" id="date_start" class="datepicker date_start">
                                <label for="date_start">Fecha de Inicio</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_end" id="date_end" class="datepicker">
                                <label for="date_end">Fecha de Fin</label>
                            </div>
                            <div class="col s12 input-field">
                                <i class="icon-straighten prefix"></i>
                                <select name="unit" id="unit">
                                    <option value="null" disabled>Elige la unidad</option>
                                    <option value="mts" selected>Metro</option>
                                    <option value="qnt" disabled>Cantidad</option>
                                </select>
                                <label>Unidad</label>
                            </div>
                            <div class="col s12">
                                <label for="width">Ancho</label>
                                <input type="text" class="js-range-slider width" name="width" id="width" value="">
                            </div>
                            <div class="col s12">
                                <label for="height">Alto</label>
                                <input type="text" class="js-range-slider height" name="height" id="height" value="">
                            </div>

                            <div class="input-field col s6 left-align">
                                <a href="#" id="publicity-previous"
                                   class="btn   peach waves-effect waves light">
                                    Anterior
                                    <i class="icon-navigate_before left"></i>
                                </a>
                            </div>
                            <div class="input-field col s6 right-align">
                                <button type="submit" class="btn peach waves-effect waves-light"
                                        id="button-publicity">
                                    <i class="icon-send right"></i>
                                    Registrar
                                </button>
                            </div>

                        </div>
                        <div class="card-content row" id="form-5">
                            <div class="input-field col s12">
                                <select name="advertising_type_id" id="type_id-5">
                                    <option value="null" disabled selected>Elija un tipo</option>
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name">
                                <label for="name">Nombre</label>
                            </div>
                            <div class="col s12">
                                {{-- <img src="{{ asset('images/bqto-4.jpg') }}" class="responsive-img" alt=""> --}}
                                <div class="preview img-wrapper center-align valing-wrapper">
                                    <i class="icon-add_a_photo medium"></i>
                                </div>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="image" id="image" class="file-upload-native"
                                           accept="image/*"/>
                                    <input type="text" disabled placeholder="Subir imagen" class="file-upload-text"/>
                                </div>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_start" id="date_start" class="datepicker date_start">
                                <label for="date_start">Fecha de Inicio</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-date_range prefix"></i>
                                <input type="text" name="date_end" id="date_end" class="datepicker">
                                <label for="date_end">Fecha de Fin</label>
                            </div>
                            <div class="col s12 input-field">
                                <i class="icon-straighten prefix"></i>
                                <select name="unit" id="unit">
                                    <option value="null" disabled>Elige la unidad</option>
                                    <option value="mts" selected>Metro</option>
                                    <option value="qnt" disabled>Cantidad</option>
                                </select>
                                <label>Unidad</label>
                            </div>
                            <div class="col s12">
                                <label for="width">Ancho</label>
                                <input type="text" class="js-range-slider" name="width" id="width" value="">
                            </div>
                            <div class="col s12">
                                <label for="height">Alto o Pisos</label>
                                <input type="text" class="js-range-slider" name="height" id="height" value="">
                            </div>
                            {{-- <div class="input-field col s12">
                                <input type="text" name="quantity" id="quantity">
                                <label for="quantity">Cantidad de Lugares</label>
                            </div> --}}
                            <div class="input-field col s12">
                                <i class="icon-exposure_plus_1 prefix"></i>
                                <input type="text" name="side" id="side">
                                <label for="side">Cantidad de Caras</label>
                            </div>
                            {{-- <div class="input-field col s12">
                                <input type="text" name="floor" id="floor">
                                <label for="floor">Pisos</label>
                            </div> --}}

                            <div class="input-field col s6 left-align">
                                <a href="#" id="publicity-previous"
                                   class="btn   peach waves-effect waves light">
                                    Anterior
                                    <i class="icon-navigate_before left"></i>
                                </a>
                            </div>
                            <div class="input-field col s6 right-align">
                                <button type="submit" class="btn peach waves-effect waves-light"
                                        id="button-publicity">
                                    <i class="icon-send right"></i>
                                    Registrar
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/imagePreview.js') }}"></script>
    <script src="{{ asset('js/data/publicityTicketOffice.js') }}"></script>
    {{--<script src="{{ asset('js/dev/vehicleTicketOffice.js') }}"></script>--}}
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection