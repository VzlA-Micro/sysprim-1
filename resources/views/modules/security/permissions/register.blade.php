@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('security.manage') }}" class="breadcrumb">Seguridad</a>
                <a href="{{ route('permissions.manage') }}" class="breadcrumb">Gestionar Permisos</a>
                <a href="{{ route('permissions.register') }}" class="breadcrumb">Registrar Permiso</a>
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