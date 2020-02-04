@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.brand.register') }}">Gestionar Marcas De Vehiculos</a></li>
                </ul>
            </div>
            @can('Registrar Marca de Vehiculo')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('vehicles.brand.register') }}" class="btn-app white green-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Marcas De Vehículo</span>
                </a>
            </div>
            @endcan
            @can('Consultar Marcas de Vehiculos')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('vehicles.brand.read') }}" class="btn-app white amber-text">
                    <i class="icon-directions_car"></i>
                    <span class="truncate">Ver Marcas De Vehículos</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection