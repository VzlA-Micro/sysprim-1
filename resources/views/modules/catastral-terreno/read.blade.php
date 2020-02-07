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
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.terreno.manage') }}">Gestionar Valor  Catastral de  Terreno</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.terreno.read') }}">Consultar  Valor  Catastral de Terreno</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
            	<div class="card">
            		<div class="card-header center-align">
            			<h4>Consultar Valores Catastrales de Terreno</h4>
            		</div>
            		<div class="card-content">
		            	<table class="highlight centered" id="accessories-table" style="width: 100%">
		            		<thead>
		            			<tr>
		            				<th>Nombre</th>
                                    <th>Valor de terreno en construcción</th>
                                    <th>Valor de terreno vacio</th>
                                    @can('Detalles Valor Terreno')
		            				<th>Detalles</th>
                                    @endcan
		            			</tr>
		            		</thead>
		            		<tbody>
                            @foreach($catastral as $cat)
                                <tr>
                                    <td>{{ $cat->name }}</td>
                                    <td>{{ $cat->value_terreno_construccion}} UT</td>
                                    <td>{{ $cat->value_terreno_vacio}} UT</td>
                                    @can('Detalles Valor Terreno')
                                    <td>
                                        <a href="{{ route('catrastal.terreno.details', ['id' => $cat->id]) }}"
                                            class="btn btn-floating blue waves-effect waves-light">
                                            <i class="icon-pageview"></i>
                                        </a>
                                    </td>
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
    <script src="{{ asset('js/data/accessories.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>	
 	<script>
 		$('#accessories-table').DataTable({
            responsive: true,
            "scrollX": true,
            "pageLength": 10,
            "aaSorting": [],
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