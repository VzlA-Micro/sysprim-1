@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Gestionar Multas</a>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('fines.register') }}" class="btn-app white green-text">
                    <i class="icon-add_box"></i>
                    <span class="truncate">Registrar Nueva Multa</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('fines.read') }}" class="btn-app white amber-text">
                    <i class="icon-assignment_late"></i>
                    <span class="truncate">Ver Multas</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('fines-company.read') }}" class="btn-app white pink-text">
                    <i class="icon-assignment"></i>
                    <span class="truncate">Multas y Empresas</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection