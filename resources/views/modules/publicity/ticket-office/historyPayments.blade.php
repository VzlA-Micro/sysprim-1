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
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.publicity.home') }}">Taquilla
                            Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.managePublicity')}}">Gestionar
                            Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.read')}}">Ver
                            Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.detailsPublicity',['id'=>$publicity->id])}}">Detalles De
                            Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="#">Historial de pago</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-header center-align">
                            <h5>Registro de Pagos</h5>
                        </div>
                        <div class="card-content">
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
                                @foreach($publicity->publicityTaxes()->get() as $taxe)
                                    <tr>

                                        <td>{{$taxe->created_at->format('d-m-Y H:i')}}</td>
                                        <td>{{$taxe->code}}</td>
                                        <td>{{$taxe->branch}}</td>


                                        @if($taxe->status==='process')
                                            <td>

                                                <button class="btn blue">
                                                    <i class="icon-refresh left"></i>
                                                    SIN CONCILIAR AÚN
                                                </button>
                                            </td>

                                        @elseif($taxe->status==='verified'||$taxe->status==='verified-sysprim')
                                            <td>
                                                <button class="btn green">
                                                    <i class="icon-check left"></i>
                                                    {{$taxe->statusName}}
                                                </button>
                                            </td>



                                        @elseif($taxe->status=='cancel')
                                            <td>
                                                <button class="btn" disabled>
                                                    <i class="icon-cancel left"></i>
                                                    CANCELADA.
                                                </button>
                                            </td>
                                        @elseif($taxe->status=='ticket-office')
                                            <td>
                                                <button class="btn amber">
                                                    <i class="icon-personal_video left"></i>
                                                    TAQUILLA.
                                                </button>
                                            </td>
                                        @endif

                                        @can('Detalles Planilla')


                                            @if($taxe->branch==='Prop. y Publicidad')

                                                <td>
                                                    <a href="{{url('/publicity/ticket-office/payments/details/',['id'=>$taxe->id])}}"
                                                       class="btn btn-floating orange waves-effect waves-light"><i
                                                                class="icon-pageview"></i></a>

                                                </td>
                                            @endif


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