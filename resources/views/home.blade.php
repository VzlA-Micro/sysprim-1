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
            @can('Mis Inmuebles')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('properties.my-properties') }}" class="btn-app white grey-text text-darken-2">
                        <i class="icon-location_city"></i>
                        <span class="truncate">Mis Inmuebles</span>
                    </a>
                </div>
            @endcan
            @can('Mis Vehiculos')
                <div>
                    <div class="col s6 m3 animated bounceIn">
                        <a href="{{ route('vehicles.my-vehicles') }}" class="btn-app white red-text text-darken-2">
                            <i class="icon-directions_car"></i>
                            <span class="truncate">Mis Vehículos</span>
                        </a>
                    </div>
                </div>
            @endcan
            @can('Mis Publicidades')
                <div>
                    <div class="col s6 m3 animated bounceIn">
                        <a href="{{ route('publicity.my-publicity') }}" class="btn-app white purple-text text-darken-2">
                            <i class="icon-folder_special"></i>
                            <span class="truncate">Mis Publicidades</span>
                        </a>
                    </div>
                </div>
            @endcan
            @can('Generar Tasas')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{route('rate.taxpayers.menu')}}" class="btn-app white amber-text accent-4">
                        <i class="icon-picture_as_pdf"></i>
                        <span class="truncate">Gestión de  Tasas</span>
                    </a>
                </div>
            @endcan
            @can('Gestionar Usuarios')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('users.manage') }}" class="btn-app white indigo-text text-darken-4">
                        <i class="icon-account_box"></i>
                        <span class="truncate">Gestionar Usuarios</span>
                    </a>
                </div>
            @endcan
            @can('Gestionar Contribuyentes')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('taxpayers.manage') }}" class="btn-app white blue-text text-darken-2">
                        <i class="icon-record_voice_over"></i>
                        <span class="truncate">Gestionar Usuarios Web</span>
                    </a>
                </div>
            @endcan
            @can('Configuración')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('settings.manage') }}" class="btn-app white green-text text-darken-2">
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
                    <a href="{{ route('dashboard') }}" class="btn-app white yellow-text text-darken-4">
                        <i class="icon-multiline_chart"></i>
                        <span class="truncate">Estadísticas</span>
                    </a>
                </div>
            @endcan
            {{--@can('Taquilla - Actividad Económica')
                --}}{{--<div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('home.ticket-office') }}" class="btn-app white pink-text text-darken-4">
                        <i class="icon-personal_video"></i>
                        <span class="truncate">Taquilla - Actividad Económica</span>
                    </a>
                </div>--}}{{--
            @endcan--}}
            @can('Taquillas')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('ticketOffice.home') }}" class="btn-app white amber-text text-darken-1">
                        <i class="icon-personal_video"></i>
                        <span class="truncate">Taquillas</span>
                    </a>
                </div>
            @endcan
            @can('Seguridad')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('security.manage') }}" class="btn-app white grey-text text-darken-2">
                        <i class="icon-security"></i>
                        <span class="truncate">Seguridad</span>
                    </a>
                </div>
            @endcan

        {{-- @can('Notificaciones')
        <div class="col s6 m3 animated bounceIn">
            <a href="{{ route('notifications.manage') }}" class="btn-app white red-text">
                <i class="icon-notifications"></i>
                <span class="truncate">Gestionar Notificaciones</span>
            </a>
        </div>
        @endcan --}}
        </div>
    </div>
@endsection

