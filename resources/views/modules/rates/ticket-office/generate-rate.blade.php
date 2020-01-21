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
                    <li class="breadcrumb-item"><a href="{{ route('rate.ticketoffice.menu') }}">Taquilla - Tasas y Certificaciones</a></li>
                    <li class="breadcrumb-item"><a href="#">Generar Planilla</a></li>

                </ul>
            </div>




            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" method="post" class="card" id="#">
                    <ul class="tabs">
                        <li class="tab col s6" id="one"><a href="#user-tab"><i class="icon-filter_1"></i>Datos Generales</a></li>
                        <li class="tab col s6 disabled" id="two"><a href="#rate-tab"><i class="icon-filter_2"></i> Datos de la Tasa</a></li>
                    </ul>

                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h5>Datos Generales-Taquilla</h5>
                        </div>
                        <div class="card-content row">
                            <input type="hidden" name="id" value="" id="id">
                            <input type="hidden" name="type" value="" id="type">


                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="type_document" id="type_document" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="J">J</option>
                                    <option value="G">G</option>
                                </select>
                                <label for="type_document"></label>
                            </div>
                            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="document" type="text" name="document" data-validate="documento" maxlength="8" class="validate number-only rate" pattern="[0-9]+" title="Solo puede escribir números." required>
                                <label for="document">Cedula o RIF</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name" type="text" name="name" class="validate rate" data-validate="nombre" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required >
                                <label for="name">Nombre</label>
                            </div>

                            <input id="surname" type="hidden" name="surname" class="validate" value="" >
                            <input id="user_name" type="hidden" name="name_user" class="validate" value="" >


                            <input id="user" type="hidden" name="user" class="validate" value="true">




                            <div class="input-field col s12 m12">
                                <i class="icon-directions prefix"></i>
                                <textarea name="address" id="address" cols="30" rows="12" data-validate="direccion" class="materialize-textarea rate" required></textarea>
                                <label for="address">Dirección</label>
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
                            <h4>Datos de la Tasa</h4>
                        </div>


                        <div class="col l12">


                        @foreach($rates as $rate)
                        <div class="input-field col s3 m3">
                            <p>
                                <label>
                                    <input type="checkbox" class="rate"  value="{{$rate->id}}"/>
                                    <span>{{$rate->name}}</span>
                                </label>
                            </p>
                        </div>

                        @endforeach

                        </div>


                        <div class="card-content row">
                            <div class="input-field col s12 right-align">
                                <a href="#" class="btn peach waves-effect waves light" id="register-rates">
                                    Finalizar
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
    <script src="{{ asset('js/data/rate-tickoffice.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection