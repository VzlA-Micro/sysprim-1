@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>li>
                    <li class="breadcrumb-item"><a href="{{ route('rate.manager') }}">Gestionar Tasas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rate.index') }}">Consultar Tasas</a></li>
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
                        <div class="card-content row">


                            @csrf
                            <input type="hidden" id="rate_id" name="id" value="{{$rate->id}}">

                            <div class="input-field col s12 m6">
                                <i class="icon-confirmation_number prefix"></i>
                                <input id="code" type="text" name="code"  required minlength="3" maxlength="10" value="{{$rate->code}}" readonly>
                                <label for="code">Código</label>
                            </div>


                            <div class="input-field col s12 m6">
                                <i class="icon-class prefix"></i>
                                <input id="name" type="text" name="name" required minlength="3" maxlength="100" value="{{$rate->name}}" readonly>
                                <label for="name">Nombre</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="icon-perm_contact_calendar prefix"></i>
                                <select name="type" id="type"  disabled>
                                    <option value="null" selected disabled>Elija un Ramo</option>
                                    <option value="Act.Eco" @if($rate->type=='Act.Eco'){{"selected"}}@endif>Actividad Economica</option>
                                    <option value="Pat.Vehiculo" @if($rate->type =='Pat.Vehiculo'){{"selected"}}@endif>Patente De Vehículo</option>
                                    <option value="Inmueble.Urb" @if($rate->type =='Inmueble.Urb'){{"selected"}}@endif>Inmuebles Urbanos</option>
                                    <option value="tasas"  @if($rate->type =='tasas'){{"selected"}}@endif>Tasa y Certificaciones</option>
                                </select>
                                <label for="type">Ramo</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input id="cant_tax_unit" type="text" name="cant_tax_unit" class="validate number-only only-number-positive" maxlength="5"  value="{{$rate->cant_tax_unit}}" required readonly>
                                <label for="cant_tax_unit">Cantidad de Unidad Tributarias</label>
                            </div>


                            <div class="input-field col s12 m6">
                                <i class="icon-import_export prefix"></i>
                                <select name="status" id="status" disabled>
                                    <option value="null" selected disabled>Elija un estado</option>
                                    <option value="active" @if($rate->status=='active'){{"selected"}}@endif>Activada</option>
                                    <option value="disabled" @if($rate->status=='disabled'){{"selected"}}@endif>Desactivar</option>
                                </select>
                                <label for="status">Estado</label>
                            </div>
                        </div>

                    </div>
                    @can('Actualizar Tasa')
            		<div class="card-footer center-align">
            			<a id="modify-btn" class="btn btn-large btn-rounded blue waves-effect waves-light">
                            <i class="icon-update right"></i>
            				Modificar
            			</a>
            			<button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="update-btn">
                            <i class="icon-save right"></i>
                            Guardar
                        </button>
            		</div>
            	    @endcan
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/rate-module.js') }}"></script>
@endsection