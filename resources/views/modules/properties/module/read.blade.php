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
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.home') }}">Taquilla - Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.manager-property') }}">Modulo - Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.read-property') }}">Consultar - Inmubles Urbanos</a></li>

                </ul>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Inmuebles Urbanos Registrados</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight centered" id="property"  style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Código Catastral</th>
                                    <th>Tipo de Inmueble</th>
                                    <th>Ubicación Catastral</th>
                                    <th>Parroquia </th>
                                    <th>Dirección</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($properties as $property)


                                <tr>
                                    <td>{{$property->code_cadastral}}</td>
                                    <td>{{$property->type->name}}</td>
                                    <td>{{$property->valueGround->name}}</td>
                                    <td>{{$property->parish->name}}</td>
                                    <td>{{$property->address}}</td>
                                    <td><a href="{{route('property.ticket-office.details-property',['id'=>$property->id])}}" class="btn btn-floating red"><i class="icon-pageview"></i></a></td>
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
        $('#property').DataTable({
            responsive: true,
            "scrollX": true,
            "pageLength": 10,
            "aaSorting": [],
            language: {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla.",
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