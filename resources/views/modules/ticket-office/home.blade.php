@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla - Actividad Económica</a></li>
                </ul>
            </div>
            @can('Gestionar Empresas')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('companies.manage') }}" class="btn-app white light-green-text">
                    <i class="icon-work"></i>
                    <span class="truncate">Gestionar Empresas</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Pagos')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('payments.manage') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-payment"></i>
                    <span class="truncate">Gestionar Pagos</span>
                </a>
            </div>
            @endcan

        </div>
    </div>
@endsection