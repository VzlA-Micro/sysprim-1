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
                </ul>
            </div>
            @can('Gestionar Roles y Permisos')
            <div class="col s6 m4 animated bounceIn">
                <a href="{{ route('roles.manage') }}" class="btn-app white teal-text">
                    <i class="icon-contacts"></i>
                    <span class="truncate">Gestionar Roles</span>
                </a>
            </div>
            @endcan
            @can('Bitacora')
            <div class="col s6 m4 animated bounceIn">
                <a href="{{ route('audits') }}" class="btn-app white lime-text">
                    <i class="icon-web"></i>
                    <span class="truncate">Bitácora</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection