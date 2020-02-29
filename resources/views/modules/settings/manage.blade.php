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
           
            @can('Configuración - Actividad Económica')
             <div class="col s6 m6 l3 animated bounceIn">
                <a href="{{ route('settings.companies') }}" class="btn-app white red-text text-darken-4">
                    <i class="icon-work"></i>
                    <span class="truncate">Gestionar Configuración Act. Económica</span>
                </a>
            </div>
            @endcan
            @can('Configuración - Vehículos')
            <div class="col s6 m6 l3 animated bounceIn">
                <a href="{{ route('settings.vehicle') }}" class="btn-app white red-text">
                    <i class="icon-local_car_wash"></i>
                    <span class="truncate">Gestionar Configuración Vehículos</span>
                </a>
            </div>
            @endcan  
            @can('Configuración - Inmuebles')
            <div class="col s6 m6 l3 animated bounceIn">
                <a href="{{route('settings.property')}}" class="btn-app white orange-text ">
                    <i class="icon-location_city"></i>
                    <span class="truncate">Gestionar Configuración Inmuebles</span>
                </a>
            </div>
            @endcan
            @can('Configuración - Publicidad')
            <div class="col s6 m6 l3 animated bounceIn">
                <a href="{{ route('settings.publicity') }}" class="btn-app white amber-text text-darken-4">
                    <i class="icon-filter_frames"></i>
                    <span class="truncate">Gestionar Configuración Publicidad</span>
                </a>
            </div>
            @endcan
            @can('Configuración - General')
            <div class="col s6 m6 l3 animated bounceIn">
                <a href="{{ route('settings.general') }}" class="btn-app white blue-text text-darken-4 ">
                    <i class="icon-settings_applications"></i>
                    <span class="truncate">Gestionar Configuraciones Generales</span>
                </a>
            </div>
            @endcan   
            
            @can('Gestionar Tasas')
            <div class="col s6 m6 l3 animated bounceIn">
                <a href="{{route('rate.manager')}}" class="btn-app white teal-text">
                    <i class="fas fa-clipboard"></i>
                    <span class="truncate">Gestionar Tasas</span>
                </a>
            </div>
            @endcan

             @can('Gestionar Monedas')
            <div class="col s6 m6 l3 animated bounceIn">
                <a href="{{route('foreign-exchange.manage')}}" class="btn-app white green-text text-darken-3">
                    <i class="fab fa-cc-diners-club"></i>
                    <span class="truncate">Gestionar Monedas</span>
                </a>
            </div>
             @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection