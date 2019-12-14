@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
    <style>
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticket-office.type.payments') }}">Ver Pagos</a></li>
                    <li class="breadcrumb-item"><a href="#!">Transferencias</a></li>
                </ul>
            </div>

            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <input type="text" class="hide" id="amount_total" value="{{number_format($amount_taxes,2)}}">
                            <table class="centered highlight" id="payments" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Forma de Pago</th>
                                    <th>Banco</th>
                                    <th>Banco Destino</th>
                                    <th>Ref</th>
                                    <th>Status</th>
                                    <th>Planilla</th>
                                    <th>Monto</th>
                                    @can('Detalles Pagos')
                                    <th>Detalles</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>

                                @if($taxes!==null)
                                    @foreach($taxes as $taxe)
                                        <tr>
                                            <td>{{$taxe->created_at->format('d-m-Y')}}</td>
                                            <td>{{$taxe->name}}</td>
                                            <td>{{$taxe->phone}}</td>
                                            <td>{{$taxe->type_payment}}</td>
                                            <td>{{$taxe->bankName}}</td>
                                            <td>{{$taxe->taxes[0]->bankName}}</td>
                                            <td>{{$taxe->ref}}</td>
                                            @if($taxe->lot)
                                                <td>{{$taxe->lot}}</td>
                                            @else
                                                @if($taxe->taxes[0]->status=='verified')
                                                    <td>Verificado <i class="icon-check green-text"
                                                                      style="font-size: 20px"></i></td>
                                                @elseif($taxe->taxes[0]->status=='process')
                                                    <td>Sin Conciliar aún.<i class="icon-alarm blue-text"
                                                                             style="font-size: 20px"></i></td>
                                                @else
                                                    <td>Cancelado.<i class="icon-close red-text"
                                                                     style="font-size: 20px"></i></td>
                                                @endif
                                            @endif

                                            <td>{{$taxe->taxes[0]->code}}</td>
                                            <td>{{number_format($taxe->amount,2)." Bs"}}</td>
                                            @can('Detalles Pagos')
                                            <td>
                                                <a href="{{url('payments/taxes/'.$taxe->taxes[0]->id)  }}"
                                                   class="btn btn-floating orange waves-effect waves-light"><i
                                                            class="icon-pageview"></i></a>
                                            </td>
                                            @endcan


                                        </tr>
                                    @endforeach
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
    <script src="{{ asset('js/dev/generate-receipt.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{asset('js/jszip.min.js')}}"></script>
    <script src="{{asset('js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>

    <script>

        var name = $('.email').text();
        var amount_total = $('#amount_total').val();
        console.log(name);

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
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'REGISTROS DE PAGO',
                    className: 'btn orange waves-effect waves-light',
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REGISTROS DE PAGO/TRANSFERENCIA',
                    download: 'open',
                    className: 'btn orange waves-effect waves-light',
                    messageTop: 'Usuario:' + name,

                    customize: function (doc) {
                        doc.styles.title = {
                            fontSize: '20',
                            alignment: 'center'
                        },doc.styles['td:nth-child(2)'] = {
                            width: '100px',
                            'max-width': '100px'
                        }, doc.styles.tableHeader = {
                            fillColor:'#247bff',
                            color:'#FFF',
                            fontSize: '6',
                            alignment: 'center',
                            bold: true

                        },doc.defaultStyle.fontSize =6;

                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6,7,8,9]
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