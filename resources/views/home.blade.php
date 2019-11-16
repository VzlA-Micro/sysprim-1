@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
            </div>
            @if(\Auth::user()->role_id ==3)
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('companies.my-business') }}" class="btn-app white blue-text">
                    <i class="icon-work"></i>
                    <span class="truncate">Mis Empresas</span>
                </a>
            </div>
           <div class="col s12 m3 animated bounceIn">
                <a href="#" class="btn-app white grey-text text-darken-2">
                    <i class="icon-location_city"></i>
                    <span class="truncate">Mis Inmuebles</span>
                </a>
            </div>
                {{-- <div class="col s12 m3 animated bounceIn">
                   <a href="{{ route('vehicles.my-vehicles') }}" class="btn-app white red-text text-darken-2">
                       <i class="icon-directions_car"></i>
                       <span class="truncate">Mis Vehículos</span>
                   </a>
               </div> --}}
            @endif


            @if(\Auth::user()->role_id ==1 || \Auth::user()->role_id ==4)
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('users.manage') }}" class="btn-app white cyan-text">
                        <i class="icon-people_outline"></i>
                        <span class="truncate">Gestionar Usuarios</span>
                    </a>
                </div>

                <!-- <div class="col s12 m3">
                    <a href="{{ route('companies.manage') }}" class="btn-app white light-green-text">
                        <i class="icon-work"></i>
                        <span class="truncate">Gestionar Empresas</span>
                    </a>
                </div>
            <!--  <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('payments.manage') }}" class="btn-app white orange-text text-darken-2">
                        <i class="icon-payment"></i>
                        <span class="truncate">Gestionar Pagos</span>
                    </a>
                </div>
                <!-- <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('fines.manage') }}" class="btn-app white deep-orange-text">
                        <i class="icon-warning"></i>
                        <span class="truncate">Gestionar Multas</span>
                    </a>
                </div> -->
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('settings.manage') }}" class="btn-app white deep-orange-text">
                        <i class="icon-settings"></i>
                        <span class="truncate">Configuración</span>
                    </a>
                </div>
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('geosysprim') }}" class="btn-app white red-text text-darken-4">
                        <i class="icon-public"></i>
                        <span class="truncate">GeoSEMAT</span>
                    </a>
                </div>
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('dashboard') }}" class="btn-app white blue-text text-darken-4">
                        <i class="icon-multiline_chart"></i>
                        <span class="truncate">Estadísticas</span>
                    </a>
                </div>
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('payments.verify.manage') }}" class="btn-app white orange-text text-darken-4">
                        <i class="icon-file_upload"></i>
                        <span class="truncate">Verificación de Pagos</span>
                    </a>
                </div>
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('home.ticket-office') }}" class="btn-app white pink-text text-darken-4">
                        <i class="icon-personal_video"></i>
                        <span class="truncate">Taquilla</span>
                    </a>
                </div>
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('security.manage') }}" class="btn-app white green-text text-darken-4">
                        <i class="icon-security"></i>
                        <span class="truncate">Seguridad</span>
                    </a>
                </div>
            @endif

            @if( \Auth::user()->role_id ==2)
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('home.ticket-office') }}" class="btn-app white pink-text text-darken-4">
                        <i class="icon-personal_video"></i>
                        <span class="truncate">Taquilla</span>
                    </a>
                </div>
                <div class="col s12 m3 animated bounceIn">
                    <a href="{{ route('payments.verify.manage') }}" class="btn-app white orange-text text-darken-4">
                        <i class="icon-file_upload"></i>
                        <span class="truncate">Verificación de Pagos</span>
                    </a>
                </div>

                <!--<div class="col s12 m3 animated bounceIn">
                    <a href="" class="btn-app white orange-text deeptext-darken-2">
                        <i class="icon-local_shipping"></i>
                        <span class="truncate">Gestionar Vehiculos</span>
                   </a>

                </div> -->
            @endif
        </div>
    </div>


@endsection

