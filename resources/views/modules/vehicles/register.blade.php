@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('vehicles.my-vehicles') }}" class="breadcrumb">Mis Vehículos</a>   
                <a href="{{ route('vehicles.register') }}" class="breadcrumb">Registrar Vehículo</a>
            </div>
            <form method="post" action="" class="col s12 m8 offset-m2">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Vehículo</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: L1S2M3">
                            <input type="text" name="license_plate" id="license_plate" pattern="[0-9A-Z]+" title="Solo puede escribir números y letra en mayúsculas." class="validate" required>
                            <label for="license_plate">Placa</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="color" id="color" class="validate" pattern="[A-Za-z]+" title="Solo puede escribir letras." required>
                            <label for="color">Color</label>
                        </div>
                        <div class="file-field input-field col s12">
                            <div class="btn purple btn-rounded waves-light">
                                 <span><i class="icon-photo_size_select_actual right"></i>Imagen</span>
                                <input type="file" name="image" id="image">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Elige una imagen del vehículo.">
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <select  name="model" id="model" required>
                                <option value="null" disabled selected>Selecciona el módelo</option>
                                <option value="">Modelo 1</option>
                                <option value="">Modelo 2</option>
                            </select>
                            <label for="model">Módelo</label>
                        </div>
                        <div class="input-field col s12 center-align">
                            <button type="submit" class="btn btn-rounded green waves-effect">Registrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection