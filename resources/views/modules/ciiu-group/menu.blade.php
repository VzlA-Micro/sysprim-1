@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu.manage') }}">Gestionar CIIU</a></li>
                </ul>
            </div>
            @can('Registrar Grupo CIIU')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-group.register') }}" class="btn-app white green-text">
                    <i class="icon-assignment_turned_in"></i>
                    <span class="truncate">Registrar Grupo CIIU</span>
                </a>
            </div>
            @endcan
            @can('Consultar Grupos CIIU')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-group.read') }}" class="btn-app white amber-text">
                    <i class="icon-chrome_reader_mode"></i>
                    <span class="truncate">Ver Grupos CIIU</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Ramos CIIU')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-branch.manage') }}" class="btn-app white teal-text">
                    <i class="icon-view_list"></i>
                    <span class="truncate">Gestionar Ramos CIIU</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection