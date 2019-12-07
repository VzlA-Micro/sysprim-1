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
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticket-office.pay.web') }}">Planillas</a></li>
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
                                        <th>Contribuyente</th>
                                        <th>Forma de Pago</th>
                                        <th>Ramo</th>
                                        <th>Periodo</th>
                                        <th>Status</th>
                                        <th>Monto</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($taxes as $taxe)
                                        <tr>
                                            <td>{{$taxe->code}}</td>
                                            <td>{{$taxe->created_at->format('d-m-Y')}}</td>
                                            <td>{{$taxe->companies[0]->name}}</td>
                                            <td>{{$taxe->typePayment}}</td>
                                            <td>{{$taxe->branch}}</td>
                                            <td>{{\App\Helpers\TaxesMonth::convertFiscalPeriod($taxe->fiscal_period)}}</td>
                                            <td>{{$taxe->statusName}}</td>
                                            <td>{{number_format($taxe->amount,2)}}</td>
                                            <td>
                                                <a href="{{url('payments/taxes/'.$taxe->id)  }}"
                                                   class="btn btn-floating orange waves-effect waves-light"><i
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
                    title: 'REGISTROS DE PAGO',
                    className: 'btn orange waves-effect waves-light',
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REGISTROS DE PAGO',
                    download: 'open',
                    className: 'btn orange waves-effect waves-light',
                    messageTop: 'Usuario:' + name,


                    messageBottom: 'TOTAL RECAUDADO:' + amount_total + ".Bs",


                    customize: function (doc) {
                        doc.styles.title = {
                            fontSize: '25',
                            alignment: 'center'
                        },
                            doc.styles['td:nth-child(2)'] = {
                                width: '100px',
                                'max-width': '100px'
                            },
                            doc.styles.tableHeader.fontSize = 14,
                            doc.defaultStyle.alignment = 'left'

                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
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