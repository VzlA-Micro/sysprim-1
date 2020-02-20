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
                    <li class="breadcrumb-item"><a href="{{ route('settings.property') }}">Configuración de Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.terreno.manage') }}">Gestionar Valor  Catastral de  Terreno</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.terreno.register') }}">Registrar Valor  Catastral de Terreno</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" id="register">
                    <div class="card-header center-align">
                        <h4>Registrar </h4>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <i class="icon-text_fields prefix"></i>
                            <input type="text" name="name" id="name" minlength="3" maxlength="100" required>
                            <label for="name">Nombre</label>
                        </div>

                        <div class="input-field col m6 s12">
                            <i class="icon-satellite prefix"></i>
                            <select  name="parish_id" id="parish_id" required>
                                <option value="null" disabled selected>Seleccionar una parroquia</option>
                                @foreach($parish as $parish):
                                <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                                @endforeach
                            </select>
                            <label for="parish_id">Parroquia</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-verified_user prefix"></i>
                            <input type="text" name="sector_nueva" id="sector_nueva" maxlength="5"  minlength="1" class="validate number-date">
                            <label for="sector_nueva">Sector nueva Nomenclatura</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-directions_run prefix"></i>
                            <input type="text" name="sector_catastral" id="sector_catastral" maxlength="5"  minlength="1" class="validate number-date" required>
                            <label for="sector_catastral">Sector Catastral</label>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/catastral_terreno.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection