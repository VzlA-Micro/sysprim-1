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
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.terreno.manage') }}">Gestionar Valor  Catastral de  Terreno</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.terreno.read') }}">Consultar  Valor  Catastral de Terreno</a></li>
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
                            <i class="icon-text_fields prefix"></i>
                            <input type="text" name="name" id="name" minlength="3" maxlength="100" required readonly value="{{$catastral->name}}">
                            <label for="name">Nombre</label>
                        </div>


                        <div class="input-field col m6 s12">
                            <i class="icon-satellite prefix"></i>
                            <select  name="parish_id" id="parish_id" required disabled>
                                <option value="null" disabled selected>Seleccionar una parroquia</option>
                                @foreach($parish as $parish)
                                @if($parish->id===$catastral->parish_id)
                                    <option value="{{ $parish->id }}" selected>{{ $parish->name }}</option>
                                @else
                                    <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                @endif

                                @endforeach
                            </select>
                            <label for="parish_id">Parroquia</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-verified_user prefix"></i>
                            <input type="text" name="sector_nueva" id="sector_nueva" maxlength="5"  minlength="1" class="validate number-date" value="{{$catastral->sector_nueva_nomenclatura}}" readonly>
                            <label for="sector_nueva">Sector nueva Nomenclatura</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-directions_run prefix"></i>
                            <input type="text" name="sector_catastral" id="sector_catastral" maxlength="5"  minlength="1" class="validate number-date"  value="{{$catastral->sector_catastral}}" readonly required>
                            <label for="sector_catastral">Sector Catastral</label>

                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-build prefix"></i>
                            <input type="text" name="value_terreno_construccion" id="value_terreno_construccion" maxlength="5"  minlength="1" class="validate number-date only-number-positive"   value="{{$catastral->value_terreno_construccion}}"   readonly required >
                            <label for="value_terreno_construccion">Valor de Terreno en construción (UT)</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-terrain prefix"></i>
                            <input type="text" name="value_terreno_vacio" id="value_terreno_vacio" maxlength="5"  minlength="1" class="validate number-date only-number-positive"    value="{{$catastral->value_terreno_vacio}}" readonly  required >
                            <label for="value_terreno_vacio">Valor de Terreno Vacio (UT)</label>
                        </div>

                    </div>

                    @can('Actualizar Valor Terreno'')
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
    <script src="{{ asset('js/data/catastral_terreno.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection