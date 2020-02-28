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
                    <li class="breadcrumb-item"><a href="#!">Configuración de Vehiculos</a></li>
                </ul>
            </div>
            
            @can('Gestionar Tipos de Vehiculos')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('vehicles.type.vehicles') }}" class="btn-app white orange-text text-darken-1 ">
                    <i class="icon-local_shipping"></i>
                    <span class="truncate">Gestionar Tipos de Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Marcas de Vehiculos')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('vehicles.brand.manage') }}" class="btn-app white amber-text">
                    <i class="icon-directions_car"></i>
                    <span class="truncate">Gestionar Marcas de Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Modelos de Vehiculos')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('vehicles.models.vehicles') }}" class="btn-app white light-green-text text-darken-4 ">
                    <i class="icon-airport_shuttle"></i>
                    <span class="truncate">Gestionar Modelos de Vehículos</span>
                </a>
            </div>
            @endcan

        </div>
    </div>
@endsection

@section('scripts')
    
@endsection