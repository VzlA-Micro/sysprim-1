@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu.manage') }}">Gestionar CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.manage') }}">Gestionar Ramos CIIU</a></li>
                </ul>
            </div>
            @can('Registar Ramo CIIU')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-branch.register') }}" class="btn-app white green-text">
                    <i class="icon-note_add"></i>
                    <span class="truncate">Registrar Ramo CIIU</span>
                </a>
            </div>
            @endcan
            @can('Consultar Ramos CIIU')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-branch.read') }}" class="btn-app white amber-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Ramos CIIU's</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection