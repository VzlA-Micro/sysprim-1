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
            <form id="vehicle" action="#" method="post" class="col s12 m8 offset-m2" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Vehículo</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s6">
                            <select name="status" id="status" required>
                                <option value="null" disabled selected>Selecciona Condicion</option>
                                <option value="propietario">Propietario</option>
                                <option value="responsable">Responsable</option>
                            </select>
                            <label for="model">Condición Legal</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: L1S2M3">
                            <input type="text" name="license_plate" id="license_plate" minlength="7" maxlength="7" pattern="[0-9A-Za-z]+"
                                   title="Solo puede escribir números y letra en mayúsculas." class="validate" required>
                            <label for="license_plate">Placa</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="brand" id="brand" required>
                                <option value="null" disabled selected>Selecciona la marca</option>
                                @foreach($brand as $brands)
                                    <option value="{{$brands->id}}">{{$brands->name}}</option>
                                @endforeach

                            </select>
                            <label for="brand">Marca</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="model" id="model" required>
                                <option value="null" disabled selected>Selecciona el módelo</option>
                            </select>
                            <label for="model">Módelo</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="type" id="type" required>
                                <option value="null" disabled selected>Selecciona el tipo de vehiculo</option>
                                @foreach($type as $types)
                                    <option value="{{$types->id}}">{{$types->name}}</option>
                                @endforeach
                            </select>
                            <label for="type">Tipo De Vehiculo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="bodySerial" id="bodySerial" class="validate" pattern="[A-Za-z0-9]+"
                                   title="Solo puede escribir letras y numeros." required>
                            <label for="bodySerial">Serial de carroceria</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="color" id="color" class="validate" pattern="[A-Za-z]+"
                                   title="Solo puede escribir letras." required>
                            <label for="color">Color</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="serialEngine" id="serialEngine" class="validate"
                                   pattern="[A-Za-z0-9]+" title="Solo puede escribir letras y numeros." required>
                            <label for="serialEngine">Serial del motor</label>
                        </div>
                        <div class="file-field input-field col s12">
                            <div class="btn purple btn-rounded waves-light">
                                <span><i class="icon-photo_size_select_actual right"></i>Imagen</span>
                                <input type="file" name="image" id="image">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text"
                                       placeholder="Elige una imagen del vehículo.">
                            </div>
                        </div>
                        <div class="input-field col s12 center-align">
                            <button id="button-vehicle" type="submit" class="btn btn-rounded green waves-effect">Registrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/vehicle.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection