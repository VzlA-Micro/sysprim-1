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
                    <li class="breadcrumb-item"><a href="{{ route('settings.general') }}">Configuración General</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.manage') }}" >Gestionar Recargos</a></li>
                </ul>
            </div>
            @can('Registrar Recargo')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('recharges.register') }}" class="btn-app white purple-text darken-2">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Recargo</span>
                </a>
            </div>
            @endcan
            @can('Consultar Recargos')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('recharges.read') }}" class="btn-app white green-text accent-1">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Recargos</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection