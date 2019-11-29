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
                    <li class="breadcrumb-item"><a href="{{ route('roles.manage') }}">Gestionar Roles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permissions.read') }}">Consultar Permisos</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
            	<div class="card">
            		<div class="card-header center-align">
            			<h5>Ver Permisos</h5>
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