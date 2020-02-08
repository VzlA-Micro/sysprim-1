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
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.construction.manage') }}">Gestionar Valor de Contrucción Catastral</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.construction.read') }}">Consultar  Valor de Contrucción Catastral</a></li>
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
            			<input type="hidden" name="id" id="id" value="{{ $catastral->id }}">


                        <div class="input-field col s12 m6">
                            <i class="icon-data_usage prefix"></i>
                            <input type="text" name="name" id="name" minlength="3" maxlength="10"  value="{{$catastral->name}}" required readonly>
                            <label for="name">Nombre</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-verified_user prefix"></i>
                            <input type="text" name="value_edification" id="value" maxlength="5"  minlength="1" class="validate number-date only-number-positive"  value="{{$catastral->value_edificacion}}"  required readonly >
                            <label for="value">Valor de edificación (UT)</label>
                        </div>

                        <div class="input-field col s12 m12">
                            <i class="icon-question_answer prefix"></i>
                            <select name="regimen_horizontal" id="regimen_horizontal" disabled>
                                <option value="null" selected disabled>...</option>
                                <option value="1"  @if ($catastral->regimen_horizontal=='1'){{"selected"}}  @endif>Si</option>
                                <option value="0"  @if ($catastral->regimen_horizontal=='0'){{"selected"}}  @endif >No</option>
                            </select>
                            <label for="regime_horizontal">Regimen Horizontal</label>
                        </div>
                    </div>
                    @can('Actualizar Valor Construccion')
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
    <script src="{{ asset('js/data/catastral_construction.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection