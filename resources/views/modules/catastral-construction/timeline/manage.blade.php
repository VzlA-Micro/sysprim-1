@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.property') }}">Configuración de Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.construction.manage') }}">Gestionar Valor  Catastral de Construcción</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal-construction.timeline.manage') }}" >Línea de Tiempo</a></li>
                </ul>
            </div>
            @can('Registrar Linea de Tiempo')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('catastral-construction.timeline.register') }}" class="btn-app white blue-grey-text">
                    <i class="icon-alarm_add"></i>
                    <span class="truncate">Registrar Línea de Tiempo</span>
                </a>
            </div>
            @endcan
            @can('Consultar Lineas de Tiempo')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('catastral-construction.timeline.read') }}" class="btn-app white blue-grey-text">
                    <i class="icon-schedule"></i>
                    <span class="truncate">Consultar Línea de Tiempo</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')

@endsection