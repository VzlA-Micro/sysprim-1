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
                    <li class="breadcrumb-item"><a href="{{ route('settings.vehicle') }}">Configuración de Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.models.vehicles') }}">Gestionar Modelos De Vehículos</a></li>
                </ul>
            </div>
            @can('Registrar Modelo de Vehiculo')
            <div class="col s6 m6 l4 animated bounceIn">
                    <a href="{{ route('vehicles.models.register') }}" class="btn-app white purple-text">
                        <i class="icon-add_circle"></i>
                        <span class="truncate">Registrar Modelos De Vehículo</span>
                    </a>
                </div>
            @endcan
            @can('Consultar Modelos de Vehiculos')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('vehicles.models.read') }}" class="btn-app white amber-text">
                    <i class="icon-directions_car"></i>
                    <span class="truncate">Ver Modelos De Vehículos</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection