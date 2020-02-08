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
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.vehicle.home') }}">Taquilla Vehículo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#" class="preview-view">Gestionar
                            Vehículo</a></li>
                    <li class="breadcrumb-item"><a href="#">Ver Vehículos</a></li>
                </ul>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Vehículos Registrados</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight centered" style="width: 100%" id="vehicle" >
                            <thead>
                            <tr>
                                <th>Licencia</th>
                                <th>Color</th>
                                <th>Marca</th>
                                <th>Módelo</th>
                                <th>Año</th>
                                @can('Detalles Vehiculos')
                                <th>Detalles</th>
                                @endcan
                            </tr>
                            </thead>

                            <tbody>
                            @if(isset($show))
                                @foreach($show as $vehicle)
                                    <tr>
                                        <td>{{$vehicle->license_plate}}</td>
                                        <td>{{$vehicle->color}}</td>
                                        <td>{{$vehicle->model->brand->name}}</td>
                                        <td>{{$vehicle->model->name}}</td>
                                        <td>{{$vehicle->year}}</td>
                                        @can('Detalles Vehiculos')
                                        <td>
                                            <a href="{{route('ticketOffice.vehicle.details',['id'=>$vehicle->id])}}" class="btn btn-floating orange waves-light">
                                                <i class="icon-pageview"></i>
                                            </a>
                                        </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>No hay vehículos registrados hasta el momento</td>
                                </tr>

                            @endif
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
        $('#vehicle').DataTable({
            responsive: true,
            "pageLength": 10,
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla.",
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
                }

            }
        });
    </script>
@endsection