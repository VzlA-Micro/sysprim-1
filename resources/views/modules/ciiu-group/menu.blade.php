@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="#!" class="breadcrumb">Gestionar CIIU</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-group.register') }}" class="btn-app white green-text">
                    <i class="icon-assignment_turned_in"></i>
                    <span class="truncate">Registrar Grupo CIIU</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-group.read') }}" class="btn-app white amber-text">
                    <i class="icon-chrome_reader_mode"></i>
                    <span class="truncate">Ver Grupos CIIU</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ciu-branch.manage') }}" class="btn-app white teal-text">
                    <i class="icon-view_list"></i>
                    <span class="truncate">Gestionar Ramos CIIU</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection