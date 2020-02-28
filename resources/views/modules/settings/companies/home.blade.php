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
                    <li class="breadcrumb-item"><a href="#!">Configuración de Act. Económica</a></li>
                </ul>
            </div>
            
            @can('Gestionar CIIU')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('ciu.manage') }}" class="btn-app white red-text text-darken-1">
                    <i class="icon-assignment"></i>
                    <span class="truncate">Gestionar Grupos CIIU's</span>
                </a>
            </div>
            @endcan

            @can('Gestionar Ramos CIIU')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('ciu-branch.manage') }}" class="btn-app white teal-text">
                    <i class="icon-view_list"></i>
                    <span class="truncate">Gestionar Ramos CIIU's</span>
                </a>
            </div>
            @endcan

        </div>
    </div>
@endsection

@section('scripts')
    
@endsection