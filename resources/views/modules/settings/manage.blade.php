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
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('ciu.manage') }}" class="btn-app white red-text text-darken-1">
                    <i class="icon-assignment"></i>
                    <span class="truncate">Gestionar CIIU</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Unidad Tribuaria')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('tax-unit.manage') }}" class="btn-app white red-text text-darken-4 ">
                    <i class="icon-exposure_plus_1"></i>
                    <span class="truncate">Gestionar Unidad Tributaria</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Tipos de Vehiculos')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('vehicles.type.vehicles') }}" class="btn-app white orange-text text-darken-1 ">
                    <i class="icon-local_shipping"></i>
                    <span class="truncate">Gestionar Tipos de Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Marcas de Vehiculos')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('vehicles.brand.manage') }}" class="btn-app white amber-text">
                    <i class="icon-directions_car"></i>
                    <span class="truncate">Gestionar Marcas de Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Modelos de Vehiculos')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('vehicles.models.vehicles') }}" class="btn-app white light-green-text text-darken-4 ">
                    <i class="icon-airport_shuttle"></i>
                    <span class="truncate">Gestionar Modelos de Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Recargos')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('recharges.manage') }}" class="btn-app white green-text ">
                    <i class="icon-trending_up"></i>
                    <span class="truncate">Gestionar Recargos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Accesorios')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('accessories.manage') }}" class="btn-app white green-text text-accent-3 ">
                    <i class="icon-filter_tilt_shift"></i>
                    <span class="truncate">Gestionar Accesorios</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Tipos de Publicidad')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('advertising-type.manage') }}" class="btn-app white teal-text">
                    <i class="icon-movie_filter"></i>
                    <span class="truncate">Gestionar Tipos de Publicidad</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Tasas del Banco')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('bank.rate.manage') }}" class="btn-app white indigo-text">
                    <i class="icon-business_center"></i>
                    <span class="truncate">Gestionar Tasa del Banco</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Tasas')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('rate.manager')}}" class="btn-app white blue-text">
                    <i class="fas fa-clipboard"></i>
                    <span class="truncate">Gestionar Tasas</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Dias de Cobro')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('prologue.manage')}}" class="btn-app white cyan-text ">
                    <i class="icon-date_range"></i>
                    <span class="truncate">Días de Cobro</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Alicuotas')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('alicuota.manage')}}" class="btn-app white pink-text ">
                    <i class="icon-format_list_numbered"></i>
                    <span class="truncate">Alicuota Inmueble</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Catastral Construccion')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('catrastal.construction.manage')}}" class="btn-app white red-text text-accent-3 ">
                    <i class="icon-build"></i>
                    <span class="truncate">Valores Catastrales de Construcción</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Catastral Terreno')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('catrastal.terreno.manage')}}" class="btn-app white purple-text ">
                    <i class="icon-nature_people"></i>
                    <span class="truncate">Valores Catastrales de Terreno</span>
                </a>
            </div>
            @endcan
            {{-- @can('Gestionar Catastral Terreno') --}}
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('group-publicity.manage')}}" class="btn-app white deep-purple-text">
                    <i class="icon-burst_mode"></i>
                    <span class="truncate">Grupos de Publicidad</span>
                </a>
            </div>
            {{-- @endcan --}}
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection