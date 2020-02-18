@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.vehicle') }}">Configuración de Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.models.vehicles') }}">Gestionar Modelos De Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.models.read') }}">Ver Modelos De Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.models.details',['id'=>$models->id]) }}">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m10 l8 offset-m1 offset-l2">
                <form id="updateType"  method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles De Modelo de Vehiculo</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <!--<div class="input-field col s12">

                        </div>-->
                        <input id="id" type="hidden" name="id" value="{{ $models->id }}">

                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <input id="name" type="text" name="name" readonly value="{{ $models->name }}">
                            <label for="name">Modelo</label>
                        </div>






                        <div class="input-field col s12 m6">
                            <i class="icon-featured_play_list prefix"></i>
                            <select name="brand" id="brand_id"  disabled>
                                <option value="#" disabled selected>Elije una opción...</option>
                                @foreach($brands as $brand)
                                    @if($brand->id==$models->brand_id )
                                        <option value="{{ $brand->id}}" selected>{{ $brand->name }}</option>
                                    @else
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="brand">Marca</label>
                        </div>



                    </div>
                    <div class="card-action center">
                        @can('Actualizar Modelos de Vehiculos')

                            <a id="btn-modify" class="btn btn-large btn-rounded blue waves-effect waves-light">
                                <i class="icon-update right"></i>
                                Modificar
                            </a>

                            <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="btn-update">
                                <i class="icon-save right"></i>
                                Guardar
                            </button>


                        @endcan
                        {{--<a href="#" class="btn btn-rounded red waves-effect waves-light">Eliminar</a>--}}
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