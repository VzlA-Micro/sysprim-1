@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                </ul>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" method="post" class="card" id="#">
                    <ul class="tabs">
                        <li class="tab col s6" id="one"><a href="#user-tab"><i class="icon-filter_1"></i>Datos del Pago</a>
                        </li>
                        <li class="tab col s6 disabled" id="two"><a href="#rate-tab"><i class="icon-filter_2"></i> Obtener Link</a></li>
                    </ul>

                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h4>Datos del Pago</h4>
                        </div>
                        <div class="card-content row">

                            <div class="input-field col s6 m4 tooltipped" data-position="bottom"
                                 data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="type_document" id="type_document" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                </select>
                                <label for="type_document">Nacionalidad</label>
                            </div>



                            <div class="input-field col s12 m8 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <i class="icon-payment prefix"></i>
                                <input id="document" type="text" name="document" data-validate="documento" maxlength="8"
                                       class="validate number-only rate" pattern="[0-9]+"
                                       title="Solo puede escribir números." required>
                                <label for="document">Cedula</label>
                            </div>


                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <i class="icon-payment prefix"></i>
                                <input id="title" type="text" name="title" data-validate="title" maxlength="8"
                                       class="validate number-only rate" pattern="[0-9]+"
                                       title="Solo puede escribir números." required>
                                <label for="title">Titulo</label>
                            </div>

                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <i class="icon-payment prefix"></i>
                                <input id="description" type="text" name="description" data-validate="description" maxlength="8"
                                       class="validate number-only rate" pattern="[0-9]+"
                                       title="Solo puede escribir números." required>
                                <label for="description">Descripción</label>
                            </div>



                            <div class="input-field col s12 m12 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <i class="icon-mail_outline prefix"></i>
                                <input id="description" type="email" name="email" data-validate="email" maxlength="8"
                                       class="validate number-only rate" pattern="[0-9]+"
                                       title="Solo puede escribir números." required>
                                <label for="email">Email</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="icon-phone prefix tooltipped" data-position="S" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251: Local"></i>
                                <select name="country_code" id="country_code_company" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="0412" >(412)</option>
                                    <option value="0414" >(414)</option>
                                    <option value="0416" >(416)</option>
                                    <option value="0424" >(424)</option>
                                    <option value="0426" >(426)</option>
                                </select>
                                <label for="country_code">Operadora</label>
                            </div>
                            <div class="input-field col s6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                                <label for="phone">Teléfono</label>
                                <input id="phone" type="tel" name="phone" value="" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required>
                            </div>


                            <div class="input-field col s12 right-align">
                                <a href="#" id='data-next' class="btn peach waves-effect waves-light">
                                    Siguiente
                                    <i class="icon-navigate_next right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="rate-tab">
                        <div class="card-header center-align">
                            <h4>Obtener Link de Pago</h4>
                        </div>


                        <div class="col l12">


                        </div>


                        <div class="card-content row">
                            <div class="input-field col s12 right-align">
                                <a href="#" class="btn peach waves-effect waves light" id="register-rates">
                                    Siguiente
                                    <i class="icon-navigate_next right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="{{ asset('js/validations.js') }}"></script>
@endsection