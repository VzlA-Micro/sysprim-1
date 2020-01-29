@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.manage') }}" class="breadcrumb">Gestionar Recargos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.read') }}" class="breadcrumb">Consultar Recargos</a></li>
                </ul>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h4>Consultar Recargos</h4>
                    </div>
                    <div class="card-content">
                        <table class="highlight centered" id="recharges-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                    <th>Valor</th>
                                    <th>Ramo</th>
                                    @can('Detalles Recargo')
                                    <th>Detalles</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recharges as $recharge)
                                <tr>
                                    <td>{{ $recharge->name }}</td>
                                    <td>{{ $recharge->since }}</td>
                                    <td>{{ $recharge->to }}</td>
                                    <td>{{ $recharge->value }}%</td>
                                    <td>{{ $recharge->branch }}</td>
                                    @can('Detalles Recargo')
                                    <td>
                                        <a href="{{ route('recharges.details', ['id' => $recharge->id]) }}" class="btn btn-floating blue waves-effect waves-light">
                                            <i class="icon-pageview"></i>
                                        </a>
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
        $('#recharges-table').DataTable({
            responsive: true,
            "scrollX": true,
            "pageLength": 10,
            language: {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "<i class='icon-first_page'>",
                    "sLast":     "<i class='icon-last_page'></i>",
                    "sNext":     "<i class='icon-navigate_next'></i>",
                    "sPrevious": "<i class='icon-navigate_before'></i>"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
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