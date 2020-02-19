@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.vehicle') }}">Configuración de Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.type.vehicles') }}">Gestionar Tipos De Vehículos</a></li>
                </ul>
            </div>

            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('type-vehicles.timeline.register')}}" class="btn-app white blue-grey-text">
                    <i class="icon-alarm_add"></i>
                    <span class="truncate">Registrar Linea Del Tiempo</span>
                </a>
            </div>

            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('type-vehicles.timeline.read')}}" class="btn-app white blue-grey-text">
                    <i class="icon-schedule"></i>
                    <span class="truncate">Ver Linea Del Tiempo</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection