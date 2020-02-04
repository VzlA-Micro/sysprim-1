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
                    <li class="breadcrumb-item"><a href="{{ route('properties.my-properties') }}">Mis Inmuebles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.details', ['id' => $property->id]) }}">{{ $property->code_cadastral }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.payments.manage', ['id' => $property->id]) }}">Mis Declaraciones</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.payments.history', ['id' => $property->id]) }}">Historial de Pagos</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                @if(Session::has('message'))
                    <div class="alert alert-warning center-align">
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Historial de Pagos</h5>
                    </div>
                    <div class="card-content">
                        {{-- Realizar verificacion --}}
                        @if ($taxes === null)
                            <h5 class="center-align">No hay registros para mostrar.</h5>
                        @else
                            <table class="centered highlight" id="history" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Código</th>
                                    <th>Ramo</th>
                                    <th class="tooltipped" data-position="right"
                                        data-tooltip="Sin conciliar aún<br>Cancelado<br>Verificado">Estado
                                    </th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($taxes as $taxe)
                                    @if($taxe->status=='verified' || $taxe->status=='verified-sysprim' || $taxe->status=='process'&&$taxe->created_at->format('d-m-Y')==\Carbon\Carbon::now()->format('d-m-Y')||$taxe->status=='cancel')

                                        <tr>
                                            <td>{{ $taxe->created_at->format('d-m-Y') }}</td>
                                            <td>{{ $taxe->code }}</td>
                                            <td>{{$taxe->branch}}</td>
                                            @if($taxe->status==='process')

                                                <td>

                                                    <button class="btn blue">
                                                        <i class="icon-more_horiz left"></i>
                                                        SIN CONCILIAR AÚN
                                                    </button>
                                                </td>
                                                <td><a href="{{ route('properties.taxpayers.pdf', ['id' => $taxe->id]) }}"
                                                       class="btn orange waves-effect waves-light"><i
                                                                class="icon-description left"></i>Descargar
                                                        planilla.</a></td>


                                            @elseif($taxe->status==='verified' || $taxe->status=='verified-sysprim' )
                                                <td>
                                                    <button class="btn green">
                                                        <i class="icon-check left"></i>
                                                        VERIFICADA.
                                                    </button>
                                                </td>



                                                <td>
                                                    <a href="{{ route('properties.taxpayers.pdf', ['id' => $taxe->id]) }}" class="btn orange waves-effect waves-light"><i class="icon-description left">
                                                        </i>Descargar Planilla.</a>
                                                </td>



                                            @elseif($taxe->status=='cancel')
                                                <td>
                                                    <button class="btn" disabled>
                                                        <i class="icon-block left"></i>
                                                        CANCELADA.
                                                    </button>
                                                </td>

                                                <td>
                                                    <a href="#"
                                                       class="btn indigo waves-effect waves-light" disabled><i
                                                                class="icon-pageview left"></i>Detalles</a>
                                                <!-- <a href="{{route('taxes.download',['id',$taxe->id])}}" class="btn orange waves-effect waves-light"><i class="icon-description left"></i>Descargar planilla.</a>-->
                                                </td>

                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        $('#history').DataTable({
            responsive: true,
            "scrollX": true,
            "pageLength": 10,
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "No hay registros que mostrar.",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "<i class='icon-first_page'>",
                    "sLast":     "<i class='icon-last_page'></i>",
                    "sNext":     "<i class='icon-navigate_next'></i>",
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