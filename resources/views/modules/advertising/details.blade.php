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
                    <li class="breadcrumb-item"><a href="{{ route('settings.publicity') }}">Configuración de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('advertising-type.manage') }}">Gestionar Tipo de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('advertising-type.read') }}">Consultar Tipo de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="#!">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m12">
            	<form method="post" class="card" id="update">
            		<div class="card-header center-align">
            			<h4>Detalles</h4>
            		</div>
            		<div class="card-content row">
            			@csrf



                        <input type="hidden" name="id" id="id" value="{{ $type->id }}">
                        <div class="input-field col s12">
                            <i class="icon-featured_play_list prefix"></i>
                            <select name="group_id" id="group_id" required disabled>
                                <option value="#" disabled selected>Elije una opción...</option>
                                @foreach($groups as $group)
                                    @if($type->group_publicity_id==$group->id )
                                        <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                    @else
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="type">Grupo de Publicidad</label>
                        </div>


                        <div class="input-field col s12">
                            <i class="icon-local_library prefix"></i>
                            <input type="text" name="name" id="name" value="{{ $type->name }}" readonly  minlength="3"  required maxlength="100">
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-looks_one prefix"></i>
                            <input type="text" name="value" id="value" required maxlength="6" class="validate number-date only-number-positive" value="{{ $type->value }}" readonly>
                            <label for="value">Valor UTC</label>
                        </div>
            		</div>
                    @can('Actualizar Tipos de Publicidad')
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
    <script src="{{ asset('js/data/advertising-type.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection