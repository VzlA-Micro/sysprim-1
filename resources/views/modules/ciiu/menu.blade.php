@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a>
                <a href="#!" class="breadcrumb">Gestionar Grupo CIIU</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-branch.register') }}" class="btn-app white green-text">
                    <i class="icon-note_add"></i>
                    <span class="truncate">Registrar Ramo CIIU</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-branch.read') }}" class="btn-app white amber-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Ramos CIIU's</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection