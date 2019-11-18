@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('notifications.manage') }}" class="breadcrumb">Gestionar Notificaciones</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('notifications.register') }}" class="btn-app white green-text text-darken-2">
                    <i class="icon-add"></i>
                    <span class="truncate">Registrar Notificación</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('notifications.show') }}" class="btn-app white indigo-text">
                    <i class="icon-assignment_ind"></i>
                    <span class="truncate">Ver Notificaciones</span>
                </a>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    
@endsection