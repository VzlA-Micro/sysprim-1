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
                    <li class="breadcrumb-item"><a href="{{ route('settings.publicity') }}">Configuración de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('advertising-type.manage') }}">Gestionar Tipos de Publicidad</a></li>
                </ul>
            </div>
            @can('Registrar Tipo de Publicidad')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('advertising-type.register') }}" class="btn-app white orange-text">
                    <i class="icon-add"></i>
                    <span class="truncate">Registrar Tipo de Publicidad</span>
                </a>
            </div>
            @endcan
            @can('Consultar Tipos de Publicidad')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('advertising-type.read') }}" class="btn-app white teal-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Tipos de Publicidad</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection