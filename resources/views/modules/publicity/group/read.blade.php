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
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.publicity') }}">Configuración de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('group-publicity.manage') }}">Gestionar Grupo de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="#" >Ver
                            Grupo de Publicidad</a></li>
                </ul>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Grupos de Publicidad</h5>
                    </div>
                    <div class="card-content">
                        <table class="centered striped" id="groupPublicity" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Nombre del Grupo</th>
                                <th>Fecha de creación</th>
                                @can('Detalles Grupo de Publicidad')
                                <th>Detalles</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($showGroups as $showGroup)
                                <tr>
                                    <td>{{$showGroup->name}}</td>
                                    <td>{{$showGroup->created_at->format('d-m-Y h:m:s')}}</td>
                                    @can('Detalles Grupo de Publicidad')
                                    <td>
                                        <a href="{{route('group-publicity.details',['id'=>$showGroup->id])}}" class="btn btn-floating orange waves-light"><i
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
        $('#groupPublicity').DataTable({
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