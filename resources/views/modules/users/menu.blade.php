@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('users.manage') }}" class="breadcrumb">Gestionar Usuarios</a>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('users.register') }}" class="btn-app white amber-text">
                    <i class="icon-person_add"></i>
                    <span class="truncate">Registrar Usuario</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('users.read') }}" class="btn-app white indigo-text">
                    <i class="icon-assignment_ind"></i>
                    <span class="truncate">Ver Usuarios</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection