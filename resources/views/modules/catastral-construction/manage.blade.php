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
                    <li class="breadcrumb-item"><a href="{{ route('settings.property') }}">Configuración de Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.construction.manage') }}">Gestionar Valor  Catastral de Construcción</a></li>
                </ul>
            </div>
            @can('Registrar Valor Construccion')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('catrastal.construction.register') }}" class="btn-app white cyan-text">
                    <i class="icon-create_new_folder"></i>
                    <span class="truncate">Registrar Valor  Catastral de Construcción</span>
                </a>
            </div>
            @endcan
            @can('Consultar Valores Construccion')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('catrastal.construction.read') }}" class="btn-app white amber-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Valor  Catastral de Construcción</span>
                </a>
            </div>
            @endcan

            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('catrastal-construction.timeline.manage') }}" class="btn-app white blue-grey-text">
                    <i class="icon-schedule"></i>
                    <span class="truncate">Línea de Tiempo</span>
                </a>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    
@endsection