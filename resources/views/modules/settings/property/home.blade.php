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
                    <li class="breadcrumb-item"><a href="#!">Configuración de Inmuebles Urbanos</a></li>
                </ul>
            </div>
            
            @can('Gestionar Alicuotas')
            <div class="col s6 m4 animated bounceIn">
                <a href="{{route('alicuota.manage')}}" class="btn-app white pink-text ">
                    <i class="icon-format_list_numbered"></i>
                    <span class="truncate">Alicuotas Inmuebles</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Catastral Construccion')
            <div class="col s6 m4 animated bounceIn">
                <a href="{{route('catrastal.construction.manage')}}" class="btn-app white red-text text-accent-3 ">
                    <i class="icon-build"></i>
                    <span class="truncate">Valores Catastrales de Construcciones</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Catastral Terreno')
            <div class="col s6 m4 animated bounceIn">
                <a href="{{route('catrastal.terreno.manage')}}" class="btn-app white purple-text ">
                    <i class="icon-nature_people"></i>
                    <span class="truncate">Valores Catastrales de Terrenos</span>
                </a>
            </div>
            @endcan

        </div>
    </div>
@endsection

@section('scripts')
    
@endsection