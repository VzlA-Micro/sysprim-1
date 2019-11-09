@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a>
            </div>
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('tax-unit.manage') }}" class="btn-app white blue-text text-darken-2">
                    <i class="icon-attach_money"></i>
                    <span class="truncate">Gestionar Unidad Tributaria</span>
                </a>
            </div>
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('ciu.manage') }}" class="btn-app white deep-purple-text">
                    <i class="icon-assignment"></i>
                    <span class="truncate">Gestionar CIIU</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection