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
                    <li class="breadcrumb-item"><a href="{{ route('tax-unit.manage') }}">Gestionar Unidad Tributaria</a></li>
                </ul>
            </div>
            @can('Registar Unidad Tribuaria')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('tax-unit.register') }}" class="btn-app white red-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Unidad Tributaria</span>
                </a>
            </div>
            @endcan
            @can('Consultar Unidades Tribuarias')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('tax-unit.read') }}" class="btn-app white blue-text">
                    <i class="icon-playlist_add_check"></i>
                    <span class="truncate">Ver Unidades Tributarias</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection