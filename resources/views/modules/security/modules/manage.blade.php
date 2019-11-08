@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('security.manage') }}" class="breadcrumb">Seguridad</a>
                <a href="{{ route('modules.manage') }}" class="breadcrumb">Gestionar Módulos</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('modules.register') }}" class="btn-app white red-text darken-text-3">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Módulo</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('modules.read') }}" class="btn-app white purple-text">
                    <i class="icon-playlist_add_check"></i>
                    <span class="truncate">Consultar Módulos</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection