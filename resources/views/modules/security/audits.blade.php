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
                    <li class="breadcrumb-item"><a href="{{ route('security.manage') }}">Seguridad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('audits') }}">Bitácora</a></li>
                </ul>
            </div>
            <div class="col s12">
            	<div class="card">
            		<div class="card-header center-align">
            			<h5>Bitácora</h5>
            		</div>
            		<div class="card-content">
		            	<table class="centered striped" width="100%" id="audits">
		            		<thead>
		            			<tr>
		            				<th>Usuario</th>
		            				<th>Rol</th>
		            				<th>Evento</th>
		            				<th>Tipo</th>
		            				<th>Valores Viejos</th>
		            				<th>Valores Nuevos</th>
		            				<th>URL</th>
		            				<th>Dirección IP</th>
		            			</tr>
		            		</thead>
		            		<tbody>
		            			@foreach ($audits as $audit)
		            			<tr>
		            				<td>{{ $audit->user_id }}</td>
		            				<td>{{ $audit->user_type }}</td>
		            				<td>{{ $audit->event }}</td>
		            				<td>{{ $audit->auditable_type }}</td>
		            				<td>{{ serialize($audit->old_values) }}</td>
		            				<td>{{ serialize($audit->new_values) }}</td>
		            				<td>{{ $audit->url }}</td>
		            				<td>{{ $audit->ip_address }}</td>

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
	    $('#audits').DataTable({
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