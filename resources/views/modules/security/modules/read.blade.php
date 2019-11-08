@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('security.manage') }}" class="breadcrumb">Seguridad</a>
                <a href="{{ route('modules.manage') }}" class="breadcrumb">Gestionar Módulos</a>
                <a href="{{ route('modules.read') }}" class="breadcrumb">Consultar Módulos</a>
            </div>
            <div class="col s12 m10 offset-m1">
            	<div class="card">
            		<div class="card-header center-align">
            			<h5>Ver Módulos</h5>
            		</div>
            		<div class="card-content">
            			<table class="centered striped">
            				<thead>
            					<tr>
            						<th>Nombre</th>
            						<th>Descripción</th>
            						<th></th>
            					</tr>
            				</thead>
            				<tbody>
            					<tr>
            						<td>Todo</td>
            						<td>Puede realizar cualquier acción y acceder a cualquier módulo.</td>
            						<td></td>
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