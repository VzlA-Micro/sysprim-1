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
            </ul>
        </div>
        <div class="col s12 m10 l10 offset-m1 offset-l1">
            <form action="#" method="post" class="card" id="#">
                <ul class="tabs">
                    <li class="tab col s12" id="one"><a href="#rate-tab"><i class="icon-filter_1"></i>Datos Generales</a></li>
                </ul>
                <div id="rate-tab">
                    <div class="card-header center-align">
                        <h4>Tasas a Generar</h4>
                    </div>

                    <div class="col l12">
                        <input type="hidden" name="id" value="{{$company->id}}" id="id">
                        <input type="hidden" name="type" value="company" id="type">


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