@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('security.manage') }}">Seguridad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bitacora') }}">Bitácora</a></li>
                </ul>
            </div>
            <div class="col s12">
            	<div class="card">
            		<div class="card-content">
		            	<table class="centered striped" width="100%">
		            		<thead>
		            			<tr>
		            				<th>Usuario</th>
		            				<th>Rol</th>
		            				<th>Módulo</th>
		            				<th>Acción</th>
		            			</tr>
		            		</thead>
		            		<tbody>
		            			<tr>
		            				<td>SysPRIM</td>
		            				<td>Superusuario</td>
		            				<td>Usuarios</td>
		            				<td>Registro</td>
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
    
@endsection