@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">        
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.manage') }}" class="breadcrumb">Gestionar Empresas</a>
                <a href="#!" class="breadcrumb">Ver Empresas</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Empresas Registradas</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight responsive-table centered" id="companies">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>RIF</th>
                                    <th>Licencia</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Abastecer CA</td>
                                    <td>J12325347347</td>
                                    <td>L124235</td>
                                    <td>+582511234567</td>
                                    <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolore delectus, iusto magnam atque aspernatur quis. Voluptatem sapiente harum quis nesciunt.</td>
                                    <td>
                                        <a href="" class="btn btn-floating red"><i class="icon-pageview"></i></a>
                                    </td>
                                </tr>
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
        $('#companies').DataTable({
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