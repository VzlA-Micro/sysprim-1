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
                </ul>
            </div>
            @can('Gestionar CIIU')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('ciu.manage') }}" class="btn-app white deep-purple-text">
                    <i class="icon-assignment"></i>
                    <span class="truncate">Gestionar CIIU</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Unidad Tribuaria')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('tax-unit.manage') }}" class="btn-app white blue-text text-darken-2">
                    <i class="icon-attach_money"></i>
                    <span class="truncate">Gestionar Unidad Tributaria</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Tipos de Vehiculos')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('vehicles.type.vehicles') }}" class="btn-app white purple-text">
                    <i class="icon-local_shipping"></i>
                    <span class="truncate">Gestionar Tipos de Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Marcas de Vehiculos')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('vehicles.brand.manage') }}" class="btn-app white deep-purple-text">
                    <i class="icon-directions_car"></i>
                    <span class="truncate">Gestionar Marcas de Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Modelos de Vehiculos')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('vehicles.models.vehicles') }}" class="btn-app white brown-text">
                    <i class="icon-airport_shuttle"></i>
                    <span class="truncate">Gestionar Modelos de Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Recargos')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('recharges.manage') }}" class="btn-app white deep-purple-text">
                    <i class="icon-trending_up"></i>
                    <span class="truncate">Gestionar Recargos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Accesorios')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('accessories.manage') }}" class="btn-app white green-text">
                    <i class="icon-filter_tilt_shift"></i>
                    <span class="truncate">Gestionar Accesorios</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Tipos de Publicidad')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('advertising-type.manage') }}" class="btn-app white amber-text text-darken-2">
                    <i class="icon-folder_special"></i>
                    <span class="truncate">Gestionar Tipos de Publicidad</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection