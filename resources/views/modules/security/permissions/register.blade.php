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
                    <li class="breadcrumb-item"><a href="{{ route('permissions.register') }}">Registrar Permiso</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
            	<form action="" method="post" class="card">
            		<div class="card-header center-align">
            			<h5>Registrar Permiso</h5>
            		</div>
            		<div class="card-content row">
            			<div class="input-field col s12 m6">
                            <i class="icon-assignment prefix"></i>
                            <input type="text" name="name" id="name" class="validate"   required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-directions prefix"></i>
                            <textarea name="description" id="description" cols="30" rows="10" class="materialize-textarea" required></textarea>
                            <label for="description">Descripción</label>
                        </div>
            		</div>
            		<div class="card-footer center-align">
            			<a href="" class="btn btn-large btn-rounded peach waves-effect waves-light">
            				Registrar
            				<i class="icon-send right"></i>
            			</a>
            		</div>
            	</form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection