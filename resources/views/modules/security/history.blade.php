@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('security.manage') }}" class="breadcrumb">Seguridad</a>
                <a href="{{ route('bitacora') }}" class="breadcrumb">Bitácora</a>
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