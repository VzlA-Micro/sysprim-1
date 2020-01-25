@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.vehicles') }}" class="breadcrumb">Gestionar Tipos De Vehiculos</a></li>
                </ul>
            </div>
            @can('Registrar Tipo de Vehiculo')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('vehicles.type.register') }}" class="btn-app white green-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Tipo De Vehículo</span>
                </a>
            </div>
            @endcan
            @can('Consultar Tipos de Vehiculos')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('type-vehicles.read') }}" class="btn-app white amber-text">
                    <i class="icon-directions_car"></i>
                    <span class="truncate">Ver Tipos De Vehículos</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection