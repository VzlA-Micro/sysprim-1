@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">        
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mis Empresas</a>
                <a href="#!" class="breadcrumb">{{ session('company') }}</a>
                <a href="{{ route('companies.my-payments', ['company' => $company->name]) }}" class="breadcrumb">Mis Pagos</a>
                <a href="{{ route('payments.history',['company'=>session('company')]) }}" class="breadcrumb">Historial de Pagos</a>
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
                        <table class="centered highlight responsive-table" id="history" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Periodo Fiscal</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taxes as $taxe)
                                <tr>
                                    <td>{{ $taxe->code }}</td>

                                    <td>{{ \App\Helpers\TaxesMonth::convertFiscalPeriod($taxe->fiscal_period)}}</td>
                                    @if($taxe->status==='process')
                                        <td>SIN CONCILIAR AÚN</td>
                                        <td><a href="{{url('pdf/'.$taxe->id)}}" class="btn orange waves-effect waves-light"><i class="icon-description left"></i>Descargar planilla.</a></td>
                                    @else
                                            <td>
                                                <button class="btn disabled">
                                                    <i class="icon-more_horiz left"></i>
                                                    {{ $taxe->status }}
                                                </button>
                                            </td>
                                            @if($taxe->status==='verified')
                                                <td>
                                                    <a href="{{url('payments/taxes/'.$taxe->id)  }}" class="btn indigo waves-effect waves-light"><i class="icon-pageview left"></i>Detalles</a>
                                                </td>
                                            @else
                                                <td>
                                                    <a href="{{url('pdf/'.$taxe->id)}}" class="btn orange waves-effect waves-light"><i class="icon-description left"></i>Descargar planilla.</a>
                                                </td>
                                            @endif
                                    @endif
                                </tr>
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
            scroller: true,
            "scrollX": true,
            "pageLength": 2,
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