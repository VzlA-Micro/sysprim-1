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
                    <li class="breadcrumb-item"><a href="{{ route('roles.manage') }}">Gestionar Roles</a></li>
                </ul>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('roles.register') }}" class="btn-app white blue-text text-darken-4">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Rol</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('roles.read') }}" class="btn-app white orange-text">
                    <i class="icon-playlist_add_check"></i>
                    <span class="truncate">Consultar Roles</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection