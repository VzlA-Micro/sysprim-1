@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
    <style>
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticket-office.pay.web') }}">Lista de Planillas</a>
                    </li>
                </ul>
            </div>

            <div class="col s12">
                <div class="card">
                    <div class="card-content">

                        <table class="centered highlight" id="payments" style="width: 100%">
                            <thead>
                            <tr>
                                <th>PLANILLA</th>
                                <th>Fecha</th>
                                <th>Forma de Pago</th>
                                <th>Banco</th>
                                <th>Ramo</th>
                                <th>Status</th>
                                <th>Monto</th>
                                @can('Detalles Planilla')
                                    <th>Detalles</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($taxes as $taxe)
                                <tr>
                                    <td>{{$taxe->code}}</td>
                                    <td>{{$taxe->created_at->format('d-m-Y')}}</td>
                                    <td>{{$taxe->typePayment}}</td>
                                    <td>{{$taxe->bankName}}</td>
                                    <td>{{$taxe->branch}}</td>
                                    <td>{{$taxe->statusName}}</td>
                                    <td>{{number_format($taxe->amount,2)}}</td>
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
                                        @elseif($taxe->branch==='Prop. y Publicidad')
                                            <td>
                                                <a href="{{ route('publicity.ticket-office.payments.details', ['id' => $taxe->id])  }}"
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


    <script>

        var name = $('.email').text();
        var amount_total = $('#amount_total').val();


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
                    "sFirst": "Primero",
                    "sLast": "Último",
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
                    title: 'LISTA DE PLANILLAS',
                    className: 'btn orange waves-effect waves-light',
                },
                {
                    extend: 'pdfHtml5',
                    title: 'LISTA DE PLANILLAS',
                    download: 'open',
                    className: 'btn orange waves-effect waves-light',
                    messageTop: 'Usuario:' + name,


                    customize: function (doc) {
                        doc.styles['td:nth-child(2)'] = {
                            width: '100px',
                            'max-width': '100px',
                            alignment: 'center',
                        }, doc.styles.tableHeader = {
                            fillColor: '#247bff',
                            color: '#FFF',
                            fontSize: '9',
                            alignment: 'center',
                            bold: true

                        },
                            doc.defaultStyle.fontSize = 8;

                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6]
                    }
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