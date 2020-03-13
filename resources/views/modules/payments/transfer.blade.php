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
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
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
                                <th>Código</th>
                                <th>Fecha</th>
                                <th>Banco</th>
                                <th>Status</th>
                                <th>Planilla</th>
                                <th>Monto</th>
                                <th>Acción</th>
                                @can('Detalles Pagos')
                                    <th>Detalles</th>
                                @endcan
                            </tr>
                            </thead>

                            <tbody>
                            @if($taxes!==null)
                                @foreach($taxes as $taxe)
                                    <tr>
                                        <td>{{$taxe->code}}</td>
                                        <td>{{$taxe->created_at->format('d-m-Y')}}</td>
                                        {{--<td class="hide">{{$taxe->name}}</td>
                                        <td class="hide">{{$taxe->phone}}</td>--}}
                                        <td>{{$taxe->bank_name}}</td>
                                        <td>{{$taxe->statusName}}</td>
                                        <td>{{$taxe->taxes[0]->code}}</td>
                                        <td>{{number_format($taxe->amount,2)." Bs"}}</td>
                                        @can('Anular Pagos')
                                            <td>
                                                <div class="row">
                                                    @if($taxe->status==='cancel')
                                                        <div class="input-field col s12 m6">
                                                            <button type="button" disabled
                                                                    class="btn waves-effect waves-light  red"
                                                                    value="">
                                                                <i class="icon-do_not_disturb_alt"></i></button>
                                                        </div>
                                                    @elseif($taxe->status=='verified'||$taxe->status=='verified-sysprim')
                                                        <div class="input-field col s12 m6">
                                                            <button type="button" id="change-status"
                                                                    class="btn waves-effect waves-light green"
                                                                    value="" data-status="#">
                                                                <i class="icon-check"></i></button>
                                                        </div>
                                                    @else
                                                        <div class="input-field col s12 m6 ">
                                                            <button type="button"
                                                                    class="change-status btn waves-effect waves-light green"
                                                                    value="{{$taxe->id}}" data-status="verified">
                                                                <i class="icon-check"></i></button>
                                                        </div>

                                                        <div class="input-field col s12 m6 ">
                                                            <button type="button"
                                                                    class="change-status btn waves-effect waves-light red"
                                                                    value="{{$taxe->id}}" data-status="cancel">
                                                                <i class="icon-cancel"></i></button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        @endcan


                                        @can('Detalles Pagos')


                                            @if($taxe->taxes[0]->branch==='Act.Eco')

                                                @if($taxe->taxes[0]->type!='definitive')

                                                    <td>
                                                        <a href="{{url('ticket-office/taxes/ateco/details/'.$taxe->taxes[0]->id)  }}"
                                                           class="btn orange waves-effect waves-light"><i
                                                                    class="icon-pageview"></i></a>

                                                @else
                                                    <td>
                                                        <a href="{{url('ticket-office/taxes/definitive/'.$taxe->taxes[0]->id) }}"
                                                           class="btn orange waves-effect waves-light"><i
                                                                    class="icon-pageview"></i></a>

                                                @endif

                                            @elseif($taxe->taxes[0]->branch==='Tasas y Cert')

                                                <td>
                                                    <a href="{{url('rate/ticket-office/details/'.$taxe->taxes[0]->id)  }}"
                                                       class="btn orange waves-effect waves-light"><i
                                                                class="icon-pageview"></i></a>


                                            @elseif($taxe->taxes[0]->branch==='Pat.Veh')
                                                <td>
                                                    <a href="{{url('ticketOffice/vehicle/viewDetails/'.$taxe->taxes[0]->id)  }}"
                                                       class="btn orange waves-effect waves-light">
                                                        <i class="icon-pageview"></i>
                                                    </a>
                                            @elseif($taxe->taxes[0]->branch==='Inm.Urbanos')
                                                <td>
                                                    <a href="{{ route('properties.ticket-office.payments.details', ['id' => $taxe->taxes[0]->id])  }}"
                                                       class="btn orange waves-effect waves-light"><i
                                                                class="icon-pageview"></i></a>

                                               
                                            @elseif($taxe->taxes[0]->branch==='Prop. y Publicidad')
                                                <td>
                                                    <a href="{{ route('publicity.ticket-office.payments.details', ['id' => $taxe->taxes[0]->id])  }}"
                                                       class="btn orange waves-effect waves-light"><i
                                                                class="icon-pageview"></i></a>

                                               

                                            @endif
                                            
                                                <a href="#"
                                                   class="btn blue waves-effect waves-light details-payment"
                                                   data-bank="{{$taxe->bank_name}}" data-destino="{{$taxe->taxes[0]->bank_name}}"
                                                   data-phone="{{$taxe->phone}}"
                                                   data-name="{{$taxe->name}}"
                                                   data-reference="{{$taxe->ref}}">
                                                    <i class="icon-info"></i>
                                                </a>
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
    <script src="{{ asset('js/dev/payments.js') }}"></script>
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
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'REGISTROS DE PAGO/TRANSFERENCIA',
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
                        }, doc.styles['td:nth-child(2)'] = {
                            width: '100px',
                            'max-width': '100px'
                        }, doc.styles.tableHeader = {
                            fillColor: '#247bff',
                            color: '#FFF',
                            fontSize: '10',
                            alignment: 'center',
                            bold: true

                        }, doc.defaultStyle.fontSize = 7;

                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
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