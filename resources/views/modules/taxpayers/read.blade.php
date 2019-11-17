@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <<a href="{{ route('home.ticket-office') }}" class="breadcrumb">Taquilla</a>
                <a href="{{ route('taxpayers.manage') }}" class="breadcrumb">Gestionar Contribuyentes</a>
                <a href="{{ route('taxpayers.read') }}" class="breadcrumb">Ver Contribuyentes</a>
            </div>
			<div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Contribuyentes registrados</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight centered" style="width: 100%" id="collaborators">
                            <thead>
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>Doc. Identidad</th>
                                    <th>Teléfono</th>
                                    <th>E-mail</th>
                                    <th>Verificado</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name . " " . $user->surname }}</td>
                                    <td>{{$user->ci}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if(\Auth::user()->confirmed == 1)
                                        <i class="icon-check green-text" style="font-size: 20px"></i>
                                        @else
                                        <i class="icon-close red-text" style="font-size: 20px"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('taxpayers.details',['id' => $user->id]) }}" class="btn btn-floating orange waves-effect waves-light">
                                            <i class="icon-pageview"></i>
                                        </a>
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
        $('#collaborators').DataTable({
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
                    "sFirst":    "Primero",
                    "sLast":     "Último",
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