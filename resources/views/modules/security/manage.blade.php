@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('security.manage') }}" class="breadcrumb">Seguridad</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('roles.manage') }}" class="btn-app white teal-text">
                    <i class="icon-contacts"></i>
                    <span class="truncate">Gestionar Roles</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('permissions.manage') }}" class="btn-app white indigo-text">
                    <i class="icon-star"></i>
                    <span class="truncate">Gestionar Permisos</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('modules.manage') }}" class="btn-app white amber-text">
                    <i class="icon-widgets"></i>
                    <span class="truncate">Gestionar Módulos</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('bitacora') }}" class="btn-app white lime-text">
                    <i class="icon-web"></i>
                    <span class="truncate">Bitácora</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection