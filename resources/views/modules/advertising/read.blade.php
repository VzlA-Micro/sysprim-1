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
                    <li class="breadcrumb-item"><a href="{{ route('advertising-type.manage') }}">Gestionar Tipos de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('advertising-type.read') }}">Consultar Tipos de Publicidad</a></li>
                </ul>
            </div>
            <div class="col s12 m12">
            	<div class="card">
            		<div class="card-header center-align">
            			<h4>Consultar Tipos de Publicidad</h4>
            		</div>
            		<div class="card-content">
		            	<table class="highlight centered" id="advertising-type-table" style="width: 100%">
		            		<thead>
		            			<tr>
		            				<th>Nombre</th>
		            				<th>Cantidad UT</th>
                                    @can('Detalles Tipo de Publicidad')
		            				<th>Detalles</th>
                                    @endcan
		            			</tr>
		            		</thead>
		            		<tbody>
		            			@foreach($advertisingType as $type)
		            			<tr>
		            				<td>{{ $type->name }}</td>
		            				<td>{{ $type->value }} UT</td>
                                    @can('Detalles Tipo de Publicidad')
		            				<td>
		            					<a href="{{ route('advertising-type.details', ['id' => $type->id]) }}" class="btn btn-floating blue waves-effect waves-light">
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
    <script src="{{ asset('js/data/advertising-type.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>	
 	<script>
 		$('#advertising-type-table').DataTable({
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