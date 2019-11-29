@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fines.manage') }}">Gestionar Multas</a></li>
                </ul>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('fines.register') }}" class="btn-app white green-text">
                    <i class="icon-add_box"></i>
                    <span class="truncate">Registrar Nueva Multa</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('fines.read') }}" class="btn-app white amber-text">
                    <i class="icon-assignment_late"></i>
                    <span class="truncate">Ver Multas</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
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