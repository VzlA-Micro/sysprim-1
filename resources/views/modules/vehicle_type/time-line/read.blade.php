@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="col s12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('settings.vehicle') }}">Configuración de Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.type.vehicles') }}">Gestionar Tipos De Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('type-vehicle.timeline.manage') }}">Línea Del Tiempo - Tipo De Vehículos</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('type-vehicles.timeline.read') }}">Ver Línea Del Tiempo</a></li>
                    </ul>
                </div>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Línea De Tiempo - Tipo de Vehículo</h5>
                    </div>
                    <div class="card-content">
                        <table class="centered striped" id="typeVehicle" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Valor Menor A 3 Años</th>
                                <th>Valor Mayor A 3 Años</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                {{--<th>Tarifa U.T menor a 3 años</th>
                                <th>Tarifa U.T mayor a 3 años</th>--}}
                                @can('Detalles Tipo de Vehiculos')
                                    <th>Detalles</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($timeline as $tl)
                                <tr>
                                    <td>{{$tl->type->name}}</td>
                                    <td>{{$tl->rate}} U.T</td>
                                    <td>{{$tl->rate_UT}} U.T</td>
                                    <td>{{$tl->since}}</td>
                                    <td>{{$tl->to}}</td>
                                    {{--<td>{{$type->rate}}</td>
                                    <td>{{$type->rate_UT}}</td>--}}
                                    @can('Detalles Tipo de Vehiculos')
                                        <td>
                                            <a href="{{route('type-vehicles.timeline.details',['id'=>$tl->id])}}"
                                               class="btn btn-floating orange waves-light"><i
                                                        class="icon-pageview"></i></a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        $('#typeVehicle').DataTable({
            responsive: true,
            "scrollX": true,
            "pageLength": 10,
            "aaSorting": [],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "<i class='icon-first_page'>",
                    "sLast": "<i class='icon-last_page'></i>",
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
@endsection