@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                </ul>
            </div>
            @can('Mis Empresas')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('companies.my-business') }}" class="btn-app white blue-text">
                    <i class="icon-work"></i>
                    <span class="truncate">Mis Empresas</span>
                </a>
            </div>
            @endcan
           {{--    
            @can('')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('properties.my-properties') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-location_city"></i>
                    <span class="truncate">Mis Inmuebles</span>
                </a>
            </div> 
            @endcan
            --}}
            {{-- 
            @can('')
            <div class="col s6 m3 animated bounceIn">
               <a href="{{ route('vehicles.my-vehicles') }}" class="btn-app white red-text text-darken-2">
                   <i class="icon-directions_car"></i>
                   <span class="truncate">Mis Vehículos</span>
               </a>
            </div> 
            @endcan
            --}}
                @can('Gestionar Usuarios')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('users.manage') }}" class="btn-app white cyan-text">
                        <i class="icon-people_outline"></i>
                        <span class="truncate">Gestionar Usuarios</span>
                    </a>
                </div>
                @endcan
                <!-- <div class="col s6 m3">
                    <a href="{{ route('companies.manage') }}" class="btn-app white light-green-text">
                        <i class="icon-work"></i>
                        <span class="truncate">Gestionar Empresas</span>
                    </a>
                </div>
            <!--  <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('payments.manage') }}" class="btn-app white orange-text text-darken-2">
                        <i class="icon-payment"></i>
                        <span class="truncate">Gestionar Pagos</span>
                    </a>
                </div>
                <!-- <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('fines.manage') }}" class="btn-app white deep-orange-text">
                        <i class="icon-warning"></i>
                        <span class="truncate">Gestionar Multas</span>
                    </a>
                </div> -->
            @can('Configuración')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('settings.manage') }}" class="btn-app white deep-orange-text">
                    <i class="icon-settings"></i>
                    <span class="truncate">Configuración</span>
                </a>
            </div>
            @endcan
            @can('GeoSEMAT')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('geosysprim') }}" class="btn-app white red-text text-darken-4">
                   <i class="icon-public"></i>
                    <span class="truncate">GeoSEMAT</span>
                </a>
            </div>
            @endcan
            @can('Estadisticas')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('dashboard') }}" class="btn-app white blue-text text-darken-4">
                    <i class="icon-multiline_chart"></i>
                    <span class="truncate">Estadísticas</span>
                </a>
            </div>
            @endcan
            @can('Verificar Pagos - Archivo')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('payments.verify.manage') }}" class="btn-app white orange-text text-darken-4">
                    <i class="icon-file_upload"></i>
                    <span class="truncate">Verificación de Pagos</span>
                </a>
            </div>
            @endcan
            @can('Taquilla')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('home.ticket-office') }}" class="btn-app white pink-text text-darken-4">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla</span>
                </a>
            </div>
            @endcan
            @can('Seguridad')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('security.manage') }}" class="btn-app white green-text text-darken-4">
                    <i class="icon-security"></i>
                    <span class="truncate">Seguridad</span>
                </a>    
            </div>
            @endcan
            @can('Notificaciones')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('notifications.manage') }}" class="btn-app white red-text">
                    <i class="icon-notifications"></i>
                    <span class="truncate">Gestionar Notificaciones</span>
                </a>
            </div>
            @endcan
            <!--<div class="col s12 m3 animated bounceIn">
                <a href="" class="btn-app white orange-text deeptext-darken-2">
                    <i class="icon-local_shipping"></i>
                    <span class="truncate">Gestionar Vehiculos</span>
               </a>
            </div> -->
        </div>
    </div>
@endsection

