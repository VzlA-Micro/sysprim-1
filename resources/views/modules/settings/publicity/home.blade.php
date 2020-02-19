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
                    <li class="breadcrumb-item"><a href="#!">Configuración de Publicidad</a></li>
                </ul>
            </div>
            
            @can('Gestionar Tipos de Publicidad')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('advertising-type.manage') }}" class="btn-app white teal-text">
                    <i class="icon-movie_filter"></i>
                    <span class="truncate">Gestionar Tipos de Publicidades</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Grupos de Publicidad')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('group-publicity.manage')}}" class="btn-app white deep-purple-text">
                    <i class="icon-burst_mode"></i>
                    <span class="truncate">Grupos de Publicidad</span>
                </a>
            </div>
            @endcan

        </div>
    </div>
@endsection

@section('scripts')
    
@endsection