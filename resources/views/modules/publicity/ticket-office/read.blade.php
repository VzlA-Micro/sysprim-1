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
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas
                        </a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.publicity.home') }}">Taquilla - Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.managePublicity')}}">Gestionar Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.register')}}">Ver Publicidad</a></li>
                </ul>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Publicidad Registradas</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight centered" style="width: 100%" id="publicity" >
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Name</th>
                                <th>Tipo</th>
                                @can('Detalles Publicidad')
                                <th>Detalles</th>
                                @endcan
                            </tr>
                            </thead>

                            <tbody>
                            @if(isset($show))
                                @foreach($show as $publicity)
                                    <tr>
                                        <td>{{$publicity->code}}</td>
                                        <td>{{$publicity->name}}</td>
                                        <td>{{$publicity->advertisingType->name}}</td>
                                        @can('Detalles Publicidad')
                                        <td>
                                            <a href="{{route('ticketOffice.publicity.detailsPublicity',['id'=>$publicity->id])}}" class="btn btn-floating orange waves-light">
                                                <i class="icon-pageview"></i>
                                            </a>
                                        </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>No hay publicidad registradas hasta el momento</td>
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
        $('#publicity').DataTable({
            responsive: true,
            "pageLength": 10,
            "scrollX": true,
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