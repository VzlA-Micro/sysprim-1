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
                    <li class="breadcrumb-item"><a href="{{route('rate.taxpayers.menu')}}">Mis Tasas</a></li>
                    <li class="breadcrumb-item"><a href="#">Declarar Tasa</a></li>
                </ul>
            </div>
            <div class="col s12 m8 l8 offset-m2 offset-l2">
                <form action="#" method="post" class="card" id="#">
                    <ul class="tabs">
                        <li class="tab col s6" id="one"><a href="#user-tab"><i class="icon-filter_1"></i>Datos Generales</a>
                        </li>
                        <li class="tab col s6 disabled" id="two"><a href="#rate-tab"><i class="icon-filter_2"></i> Datos
                                de la Tasa</a></li>
                    </ul>

                    <div id="user-tab">
                        <div class="card-header center-align">
                            <h4>Datos Generales</h4>
                        </div>
                        <div class="card-content row">
                            <input type="hidden" name="id" value="" id="id">
                            <input type="hidden" name="type" value="" id="type">


                            <div class="input-field col s6 m3 tooltipped" data-position="bottom"
                                 data-tooltip="V: Venezolano; E: Extranjero">
                                <i class="icon-public prefix"></i>
                                <select name="type_document" id="type_document" required>
                                    <option value="null" selected disabled>...</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                </select>
                                <label for="type_document"></label>
                            </div>

                            <div class="input-field col s6 m3 tooltipped" data-position="bottom"
                                 data-tooltip="Solo puede escribir números. Ej: 12345678">
                                <input id="document" type="text" name="document" data-validate="documento" maxlength="8"
                                       class="validate number-only rate" pattern="[0-9]+"
                                       title="Solo puede escribir números." required>
                                <label for="document">Cedula</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped name-div" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="name" type="text" name="name" class="validate rate" data-validate="nombre"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)." required maxlength="40">
                                <label for="name">Nombre</label>
                            </div>

                            <div class="input-field col s12 m3 tooltipped surname-div hide" data-position="bottom"
                                 data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-person prefix"></i>
                                <input id="surname-div" type="text" name="surname-div" class="validate " data-validate="apellido"
                                       pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                       title="Solo puede agregar letras (con acentos)." required maxlength="40">
                                <label for="surname-div">Apellido</label>
                            </div>

                            <input id="surname" type="hidden" name="surname" class="validate" value="">
                            <input id="user_name" type="hidden" name="name_user" class="validate" value="">





                            <div class="input-field col s12 m6">
                                <i class="icon-directions prefix"></i>
                                <textarea name="address" id="address" cols="30" rows="12" data-validate="direccion"
                                          class="materialize-textarea rate" required maxlength="200"></textarea>
                                <label for="address">Dirección</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                                <i class="icon-mail_outline prefix"></i>
                                <input id="email" type="email" name="email" class="validate rate" data-validate="email"  title="Solo puede agregar letras (con acentos)." required >
                                <label for="email">Correo</label>
                            </div>

                            <div class="input-field col s6 left-align ">
                                <a href="#" id="generate-correo" class="btn blue waves-effect waves light hide">
                                    Generar Correo
                                    <i class="icon-mail_outline left"></i>
                                </a>
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

                            <table class="centered highlight" id="rates" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Tasas</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($rates as $rate)
                                    <tr>
                                        <td>
                                            <p style="text-align: justify">
                                                <label>
                                                    <input type="checkbox" class="rate"  value="{{$rate->id}}"/>
                                                    <span>{{$rate->name}}</span>
                                                </label>
                                            </p>
                                        </td>
                                @endforeach

                                </tbody>
                            </table>
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

    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        $('#rates').DataTable({
            responsive: true,
            scroller: true,
            "scrollX": true,
            "pageLength": 10,
            "aaSorting": [],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Todavia este contribuyente ningun pago.",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "<i class='icon-navigate_next'></i>",
                    "sPrevious": "<i class='icon-navigate_before'></i>"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            }
        });
    </script>

    <script src="{{ asset('js/data/rate.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection