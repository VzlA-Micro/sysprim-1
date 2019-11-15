@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">            
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('home.ticket-office') }}" class="breadcrumb">Taquilla</a>
                <a href="{{ route('payments.manage') }}" class="breadcrumb">Gestionar Pagos</a>
                <a href="#!" class="breadcrumb">Ver Pagos</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <table class="centered highlight" id="payments" style="width: 100%">

                            <thead>
                                <tr>
                                    <th>Contribuyente</th>
                                    <th>Forma de Pago</th>
                                    <th>Banco</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>N°. Referencia</th>
                                    {{-- <th>Detalles</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($taxes as $taxe)
                                <tr>
                                    <td>{{$taxe->taxes->companies[0]->name}}</td>
                                    <td>{{$taxe->taxes->typePayment}}</td>
                                    <td>{{$taxe->taxes->bankName}}</td>
                                    <td>{{$taxe->created_at->format('d-m-Y')}}</td>
                                    <td>{{number_format($taxe->amount,2)}}</td>
                                    <td>{{$taxe->ref}}</td>
                                    {{-- <td>
                                        <a href="" class="btn btn-floating orange waves-effect waves-light"><i class="icon-pageview"></i></a>
                                    </td> --}}
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
        $('#payments').DataTable({
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