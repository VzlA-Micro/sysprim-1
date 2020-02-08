@extends('layouts.app')

@section('styles')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.verify.manage') }}">Verificación de Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bank.read') }}">Ver Pagos Verificados</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Pagos Verificados</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight centered responsive-table" id="payments" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Ramo</th>
                                    <th>Monto</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taxes as $taxe)
                                <tr>
                                    <td>{{$taxe->code}}</td>
                                    <td>{{$taxe->branch}}</td>
                                    <td>{{$taxe->amountFormat}}</td>
                                    @can('Detalles Planilla')
                                        @if($taxe->branch==='Act.Eco')

                                            @if($taxe->type!='definitive')

                                                <td>
                                                    <a href="{{url('ticket-office/taxes/ateco/details/'.$taxe->id)  }}"
                                                       class="btn btn-floating orange waves-effect waves-light"><i
                                                                class="icon-pageview"></i></a>
                                                </td>


                                            @else
                                                <td>
                                                    <a href="{{url('ticket-office/taxes/definitive/'.$taxe->id)  }}"
                                                       class="btn btn-floating orange waves-effect waves-light"><i
                                                                class="icon-pageview"></i></a>

                                                </td>
                                            @endif

                                        @elseif($taxe->branch==='Tasas y Cert')

                                            <td>
                                                <a href="{{url('rate/ticket-office/details/'.$taxe->id)  }}"
                                                   class="btn btn-floating orange waves-effect waves-light"><i
                                                            class="icon-pageview"></i></a>

                                            </td>
                                        @elseif($taxe->branch==='Pat.Veh')

                                            <td>
                                                <a href="{{url('ticketOffice/vehicle/viewDetails/'.$taxe->id)  }}"
                                                   class="btn btn-floating orange waves-effect waves-light"><i
                                                            class="icon-pageview"></i></a>

                                            </td>
                                        @elseif($taxe->branch==='Inm.Urbanos')
                                            <td>
                                                <a href="{{ route('properties.ticket-office.payments.details', ['id' => $taxe->id])  }}"
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
@endsection
@section('scripts')

    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{asset('js/jszip.min.js')}}"></script>
    <script src="{{asset('js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>
    <script>
        $('#payments').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            "scrollX": true,
            "pageLength": 10,
            "aaSorting": [],
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
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'REGISTROS DE PAGO',
                    className: 'btn orange waves-effect waves-light',
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REGISTROS DE PAGO/PUNTO DE VENTA',
                    download: 'open',
                    className: 'btn orange waves-effect waves-light',
                    messageTop: 'Usuario:' + name,


                    customize: function (doc) {
                        doc.styles.title = {
                            fontSize: '20',
                            alignment: 'center'
                        }, doc.styles['td:nth-child(2)'] = {
                            width: '100px',
                            'max-width': '100px'
                        }, doc.styles.tableHeader = {
                            fillColor: '#247bff',
                            color: '#FFF',
                            fontSize: '20',
                            alignment: 'center',
                            bold: true

                        }, doc.defaultStyle.fontSize = 12;


                    },
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },


                {
                    extend: 'copyHtml5',
                    title: 'REGISTROS DE PAGO',
                    className: 'btn orange waves-effect waves-light',

                },


                {
                    extend: 'csvHtml5',
                    title: 'REGISTROS DE PAGO',
                    className: 'btn orange waves-effect waves-light',
                },
            ]
        });
    </script>
@endsection