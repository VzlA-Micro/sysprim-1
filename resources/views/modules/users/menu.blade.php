@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.manage') }}">Gestionar Usuarios</a></li>
                </ul>
            </div>
            @can('Registrar Usuario')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('users.register') }}" class="btn-app white amber-text">
                    <i class="icon-person_add"></i>
                    <span class="truncate">Registrar Usuario</span>
                </a>
            </div>
            @endcan
            @can('Consultar Usuarios')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('users.read') }}" class="btn-app white indigo-text">
                    <i class="icon-assignment_ind"></i>
                    <span class="truncate">Ver Usuarios</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection