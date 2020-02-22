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
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.terreno.manage') }}">Gestionar Valor  Catastral de  Terreno</a></li>
                </ul>
            </div>
            @can('Registrar Valor Terreno')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('catrastal.terreno.register') }}" class="btn-app white cyan-text">
                    <i class="icon-create_new_folder"></i>
                    <span class="truncate">Registrar Valor Catastral de Terreno</span>
                </a>
            </div>
            @endcan
            @can('Consultar Valores Terreno')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('catrastal.terreno.read') }}" class="btn-app white amber-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Valor de Contrucción Catastral de Terreno</span>
                </a>
            </div>
            @endcan

            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('catrastal-terreno.timeline.manage') }}" class="btn-app white blue-grey-text">
                    <i class="icon-schedule"></i>
                    <span class="truncate">Línea de Tiempo</span>
                </a>
            </div>


        </div>
    </div>
@endsection

@section('scripts')
    
@endsection