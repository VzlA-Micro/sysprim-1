@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
            </div>
            @if(\Auth::user()->role_id ==3)
            <div class="col s12 m3">
                <a href="{{ route('companies.my-business') }}" class="btn-app white blue-text">
                    <i class="icon-work"></i>
                    <span class="truncate">Mis Empresas</span>
                </a>
            </div>
            @endif

            @if(\Auth::user()->role_id ==1)
                <div class="col s12 m3">
                    <a href="{{ route('users.manage') }}" class="btn-app white cyan-text">
                        <i class="icon-people_outline"></i>
                        <span class="truncate">Gestionar Usuarios</span>
                    </a>
                </div>
                <div class="col s12 m3">
                    <a href="{{ route('companies.manage') }}" class="btn-app white light-green-text">
                        <i class="icon-work"></i>
                        <span class="truncate">Gestionar Empresas</span>
                    </a>
                </div>
                <div class="col s12 m3">
                    <a href="{{ route('payments.manage') }}" class="btn-app white orange-text text-darken-2">
                        <i class="icon-payment"></i>
                        <span class="truncate">Gestionar Pagos</span>
                    </a>
                </div>
                <div class="col s12 m3">
                    <a href="{{ route('fines.manage') }}" class="btn-app white deep-orange-text">
                        <i class="icon-warning"></i>
                        <span class="truncate">Gestionar Multas</span>
                    </a>
                </div>
                <div class="col s12 m3">
                    <a href="{{ route('ciu.manage') }}" class="btn-app white deep-purple-text">
                        <i class="icon-assignment"></i>
                        <span class="truncate">Gestionar CIIU</span>
                    </a>
                </div>
            @endif
            @if( \Auth::user()->role_id ==2)
                <div class="col s12 m3">
                    <a href="{{ route('users.manage') }}" class="btn-app white cyan-text">
                        <i class="icon-people_outline"></i>
                        <span class="truncate">Gestionar Usuarios</span>
                    </a>
                </div>
                <div class="col s12 m3">
                    <a href="{{ route('companies.manage') }}" class="btn-app white light-green-text">
                        <i class="icon-work"></i>
                        <span class="truncate">Gestionar Empresas</span>
                    </a>
                </div>
                <div class="col s12 m3">
                    <a href="" class="btn-app white orange-text deeptext-darken-2">
                        <i class="icon-local_shipping"></i>
                        <span class="truncate">Gestionar Vehiculos</span>
                    </a>
                </div>
                <div class="col s12 m3">
                    <a href="{{ route('payments.manage') }}" class="btn-app white orange-text text-darken-2">
                        <i class="icon-payment"></i>
                        <span class="truncate">Gestionar Pagos</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection