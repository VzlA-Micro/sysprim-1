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
                    <li class="breadcrumb-item"><a href="{{ route('prologue.manage') }}">Gestionar Dias de Cobros</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('prologue.index') }}">Consultar Dias de Cobros</a></li>
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
            			<input type="hidden" name="id" id="id" value="{{ $prologue->id }}">

                        <div class="input-field col s12 m6">
                            <i class="icon-description prefix"></i>
                            <input type="text" name="name" id="name" value="{{ $prologue->name }}" readonly>
                            <label for="name">Nombre</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-archive prefix"></i>
                            <input type="text" name="branch" id="branch" value="{{ $prologue->name }}" readonly>
                            <label for="branch">Ramo</label>
                        </div>



                        <div class="input-field col s12 m12">
                            <i class="icon-date_range  prefix"></i>
                            <input type="text" name="date_limit" class="datepiker" id="date_limit" value="{{( $prologue->date_limit) }}">
                            <label for="date_limit">Fecha</label>
                        </div>


            		</div>
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
            	</form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/prologue.js') }}"></script>
@endsection