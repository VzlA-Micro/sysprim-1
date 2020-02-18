@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.general') }}">Configuración General</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accessories.manage') }}">Gestionar Tasa de Banco</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accessories.read') }}">Consultar Tasa de Banco</a></li>
                    <li class="breadcrumb-item"><a href="#!">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
            	<form method="post" class="card" id="update">
            		<div class="card-header center-align">
            			<h4>Detalles</h4>
            		</div>
            		<div class="card-content row">
            			@csrf
            			<input type="hidden" name="id" id="id" value="{{ $accessory->id }}">
                        <div class="input-field col s12 m6">
                            <input type="text" name="name" id="name" value="{{ $accessory->name }}" readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="value" id="value" value="{{ $accessory->value }}" readonly>
                            <label for="value">Valor UTC</label>
                        </div>
            		</div>
                    @can('Actualizar Tasa de Banco')
            		<div class="card-footer center-align">
            			<a id="modify-btn" class="btn btn-large btn-rounded blue waves-effect waves-light">
                            <i class="icon-update right"></i>
            				Modificar
            			</a>
            			<button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="update-btn">
                            <i class="icon-send right"></i>
                            Actualizar
                        </button>
            		</div>
                    @endcan
            	</form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/accessories.js') }}"></script>
@endsection