@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                </ul>
            </div>
            <div class="col s12">
                <form action="" method="post" class="card" enctype="multipart/form-data" id="register">
                    @csrf
                    <div class="card-header center-align">
                        <h4>Filtrar</h4>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m4">
                            <input type="text" name="since" id="since" class="datepicker" required>
                            <label for="since">Desde</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="text" name="to" id="to" class="datepicker" required>
                            <label for="to">Hasta</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <select name="payment-type" id="payment-type">
                                <option value="" disabled selected>Elija una opción</option>
                                <option value="">Deposito</option>
                                <option value="">Transferencia</option>
                                <option value="">Punto de Venta</option>
                            </select>
                            <label for="payment-type">Forma de Pago</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <select name="bank" id="bank">
                                <option value="" disabled selected>Elija una opción</option>
                                <option value="">BOD</option>
                                <option value="">BANESCO</option>
                                <option value="">100% BANCO</option>
                                <option value="">BDV</option>
                                <option value="">BICENTENARIO</option>
                                <option value="">BNC</option>
                            </select>
                            <label for="bank">Banco</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <select name="branch" id="branch">
                                <option value="" disabled selected>Elija una opción</option>
                                <option value="">Actividad Económica</option>
                                <option value="">Inmuebles Urbanos</option>
                                <option value="">Vehículos</option>
                                <option value="">Tasas y Certificaciónes</option>
                                <option value="">Propaganda y Publicidad</option>
                                <option value="">Otro</option>
                            </select>
                            <label for="branch">Ramo</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <select name="status" id="status">
                                <option value="" disabled selected>Elija una opción</option>
                                <option value="">Actividad Económica</option>
                            </select>
                            <label for="status">Status</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <a href="" class="btn peach btn-large waves-effect waves-light col s12">
                                <i class="icon-filter right"></i>
                                <span class="truncate">Filtrar</span>
                            </a>
                        </div>
                        <div class="col s12">
                            <table class="highlight centered" id="filter-table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Forma de Pago</th>
                                        <th>Banco</th>
                                        <th>Ramo</th>
                                        <th>Status</th>
                                        <th>Recaudación</th>
                                        {{--@can('Detalles Linea de Tiempo')--}}
                                            <th>Detalles</th>
                                        {{--@endcan--}}
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/filter.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
    <script>
        $('#filter-table').DataTable({
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