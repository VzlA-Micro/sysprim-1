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
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('userRegister') }}" class="btn-app white amber-text">
                    <i class="icon-person_add"></i>
                    <span class="truncate">Registrar Usuario</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('userRead') }}" class="btn-app white indigo-text">
                    <i class="icon-assignment_ind"></i>
                    <span class="truncate">Ver Usuarios</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection