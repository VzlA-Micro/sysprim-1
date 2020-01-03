@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges.manage') }}" class="breadcrumb">Gestionar Recargos</a></li>
                </ul>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('recharges.register') }}" class="btn-app white purple-text darken-2">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Recargo</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('recharges.read') }}" class="btn-app white green-text accent-1">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Recargos</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection