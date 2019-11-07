@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('security.manage') }}" class="breadcrumb">Seguridad</a>
                <a href="{{ route('roles.manage') }}" class="breadcrumb">Gestionar Roles</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('roles.manage') }}" class="btn-app white blue-text text-darken-4">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Rol</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('roles.manage') }}" class="btn-app white orange-text">
                    <i class="icon-playlist_add_check"></i>
                    <span class="truncate">Consultar Roles</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection