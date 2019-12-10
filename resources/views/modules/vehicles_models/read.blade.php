@extends('layouts.app')

@section('styles')

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
                        <h5>Tipos Vehículos</h5>
                    </div>
                    <div class="card-content">
                        <table class="centered striped responsive-table" id="typeVehicle" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Modelo</th>
                                <th>Año</th>
                                <th>Marca</th>
                                <th>Detalles</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($showModels as $models)
                                <tr>
                                    <td>{{$models->name}}</td>
                                    <td>{{$models->year}}</td>
                                    <td>{{$models->brand->name}}</td>

                                    <td>
                                        <a href="{{route('vehicles.models.details',['id'=>$models->id])}}" class="btn btn-floating orange waves-light"><i
                                                    class="icon-pageview"></i></a>
                                    </td>
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