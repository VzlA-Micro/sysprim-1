@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu.manage') }}">Gestionar CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.manage') }}">Gestionar Ramos CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.read') }}">Ver Ramos CIIU's</a></li>
                    <li class="breadcrumb-item"><a href="#!">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m10 l8 offset-m1 offset-l2">
                <form id="updateType"  method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles De Vehiculo</h5>
                    </div>
                    <div class="card-content row">
                        <input id="id" type="hidden" name="id" value="{{ $vehicle->id }}">
                        <div class="input-field col s6">
                            <input type="text" name="Brand" id="brand" class="validate"
                                   title="" value="{{$vehicle->model->brand->name}}" required readonly>
                            <label for="brand">Marca</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="models" id="models" class="validate"
                                   title="" value="{{$vehicle->model->name}}" required readonly>
                            <label for="models">Modelo</label>
                        </div>
                        <div class="input-field col s12 m6 tooltipped" data-position="bottom">
                            <input type="text" name="license_plate" id="license_plate"
                                   title="" class="validate" value="{{$vehicle->license_plate}}" required readonly>
                            <label for="license_plate">Placa</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="bodySerial" id="bodySerial" class="validate"
                                   title="" value="{{$vehicle->body_serial}}" required readonly>
                            <label for="bodySerial">Serial de Carroceria</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="serialEngine" id="serialEngine" class="validate"
                                   title="" value="{{$vehicle->serial_engine}}" required readonly>
                            <label for="serialEngine">Serial del Motor</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="typeVehicle" id="typeVehicle" class="validate"
                                   title="" value="{{$vehicle->type->name}}" required readonly>
                            <label for="typeVehicle">Tipo de Vehiculo</label>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/modelsVehicle.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection