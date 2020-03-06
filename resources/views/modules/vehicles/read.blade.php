@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('vehicles.my-vehicles') }}" class="breadcrumb">Mis Vehículos</a>
                <a href="{{ route('vehicles.register') }}" class="breadcrumb">Ver mis Vehículo</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mis Vehículos</h5>
                    </div>
                    <div class="card-content">
                        <table class="centered striped responsive-table" id="vehicle">
                            <thead>
                            <tr>
                                <th>Licencia</th>
                                <th>Color</th>
                                <th>Marca</th>
                                <th>Módelo</th>
                                <th>Año</th>
                                <th>Fecha de creación</th>
                                @can('Detalles Mis Vehiculos')
                                <th>Detalles</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($show as $vehicle)
                                <tr>
                                    <td>{{$vehicle->license_plate}}</td>
                                    <td>{{$vehicle->color}}</td>
                                    <td>{{$vehicle->model->brand->name}}</td>
                                    <td>{{$vehicle->model->name}}</td>
                                    <td>{{$vehicle->year}}</td>
                                    <td>{{$vehicle->created_at->format('d-m-Y h:m:s')}}</td>
                                    @can('Detalles Mis Vehiculos')
                                    <td>
                                        <a href="{{route('vehicles.details',['id'=>$vehicle->id])}}" class="btn btn-floating orange waves-light"><i
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
        $('#vehicle').DataTable({
            responsive: true,
            "pageLength": 10,
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
                }

            }
        });
    </script>
@endsection