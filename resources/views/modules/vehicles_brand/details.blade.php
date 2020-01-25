@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.brand.manage') }}" class="breadcrumb">Gestionar
                            Marcas De Vehiculos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.brand.read') }}" class="breadcrumb">Ver
                            Marcas De Vehiculos</a></li>

                    <li class="breadcrumb-item"><a href="#" class="breadcrumb">Detalles De
                            Marcas De Vehiculos</a></li>
                </ul>
            </div>
            <div class="col s12 m10 l8 offset-m1 offset-l2">
                <form id="updateBrand" method="" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles De Marca De Vehiculo</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <input id="id" type="hidden" name="id" value="{{ $brand->id }}">

                        <div class="input-field col s12">
                            <i class="icon-time_to_leave prefix"></i>
                            <input id="name" type="text" name="name" readonly value="{{ $brand->name }}">
                            <label for="name">Marca</label>
                        </div>
                    </div>
                    <div class="card-action center">
                        @can('Actualizar Marcas de Vehiculos')
                        <button type="submit" class="btn btn-rounded green waves-effect waves-light">Actualizar <i class="icon-update right"></i></button>
                        @endcan
                        {{--<a href="#" class="btn btn-rounded red waves-effect waves-light">Eliminar  <i class="icon-delete right"></i></a>--}}
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/brandVehicle.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection