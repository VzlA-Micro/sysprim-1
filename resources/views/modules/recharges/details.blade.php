@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.manage') }}" class="breadcrumb">Gestionar Recargos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.register') }}" class="breadcrumb">Consultar Recargos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.details',['id' => $recharge->id]) }}" class="breadcrumb">Detalles</a></li>

                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" enctype="multipart/form-data" id="update">
                    @csrf
                    <div class="card-header center-align">
                        <h4>Detalles del Recargo</h4>
                    </div>
                    <div class="card-content row">
                        <input type="hidden" name="id" id="id" value="{{ $recharge->id }}">
                        <div class="input-field col s12 m6">
                            <i class="icon-perm_contact_calendar prefix"></i>
                            <input type="text" name="since" id="since" class="datepicker" value="{{ $recharge->since }}" readonly>
                            <label for="since">Desde</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-perm_contact_calendar prefix"></i>
                            <input type="text" name="to" id="to" class="datepicker" value="{{ $recharge->to }}" readonly>
                            <label for="to">Hasta</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-time_to_leave prefix"></i>
                            <input type="text" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Solo puede escribir números y letra en mayúsculas." class="validate" value="{{ $recharge->name }}" required readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-time_to_leave prefix"></i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only" value="{{ $recharge->value }}" required readonly>
                            <label for="value">Valor</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-perm_contact_calendar prefix"></i>
                            <select name="branch" id="branch" disabled>
                                <option value="null" selected disabled>Elija un ramo</option>
                                <option value="Act.Eco" @if($recharge->branch =='Act.Economica'){{"selected"}}@endif>Actividad Economica</option>
                                <option value="Pat.Vehiculo" @if($recharge->branch =='Pat.Vehiculo'){{"selected"}}@endif>Patente De Vehículo</option>
                                <option value="Inmueble.Urb" @if($recharge->branch =='Inmueble.Urb'){{"selected"}}@endif>Inmuebles Urbanos</option>
                                <option value="Publicidad" @if($recharge->branch =='Publicidad'){{"selected"}}@endif>Publicidad</option>
                                <option value="Espectaculo" @if($recharge->branch =='Espectaculo'){{"selected"}}@endif>Espectaculos</option>
                            </select>
                            <label for="branch">Ramo</label>
                        </div>
                    </div>
                    @can('Actualizar Recargos')
                    <div class="card-footer center-align">
                        <a href="#!" class="btn btn-large blue btn-rounded waves-effect waves-light" id="btn-modify">
                            <i class="icon-update right"></i>
                            Modificar
                        </a>
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="btn-update">
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
    <script src="{{ asset('js/data/recharges.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection