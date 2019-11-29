@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('security.manage') }}">Seguridad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permissions.manage') }}">Gestionar Permisos</a></li>
                </ul>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('permissions.register') }}" class="btn-app white pink-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Permiso</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('permissions.read') }}" class="btn-app white green-text">
                    <i class="icon-playlist_add_check"></i>
                    <span class="truncate">Consultar Permisos</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection