@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                </ul>
            </div>
            @can('Taquilla - Actividad Económica')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('home.ticket-office') }}" class="btn-app white indigo-text text-darken-2">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla - Actividad Económica</span>
                </a>
            </div>
            @endcan
            @can('Taquilla - Vehiculos')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('ticketOffice.vehicle.home')}}" class="btn-app white orange-text text-darken-3">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla - Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Taquilla - Tasas')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('rate.ticketoffice.menu')}}" class="btn-app white  blue-text accent-3">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla - Tasas y Certificaciones</span>
                </a>
            </div>
            @endcan
            @can('Taquilla - Publicidad')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{ route('ticketOffice.publicity.home') }}" class="btn-app white purple-text text-darken-2">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla - Publicidad</span>
                </a>
            </div>
            @endcan
            @can('Taquilla - Inmuebles')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('property.ticket-office.home')}}" class="btn-app white pink-text text-darken-2">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla - Inmuebles Urbanos</span>
                </a>
            </div>
            @endcan
            @can('Configurar Taquilla')
            <div class="col s6 m3 animated bounceIn">
                <a href="{{route('ticket-office.config')}}" class="btn-app white red-text text-darken-2">
                    <i class="icon-dvr"></i>
                    <span class="truncate">Configuración Taquilla</span>
                </a>
            </div>
            @endcan
            @can('Verificar Pagos - Archivo')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('payments.verify.manage') }}" class="btn-app white green-text text-darken-4">
                        <i class="icon-verified_user"></i>
                        <span class="truncate">Verificación de Pagos</span>
                    </a>
                </div>
            @endcan
            @can('Ver Planillas')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{route('ticket-office.pay.web')}}" class="btn-app white cyan-text text-darken-4">
                        <i class="icon-library_books"></i>
                        <span class="truncate">Lista de Planillas</span>
                    </a>
                </div>
            @endcan

            @can('Ver Pagos')
                <div class="col s6 m3 animated bounceIn">
                    <a href="{{ route('ticket-office.type.payments') }}" class="btn-app white teal-text">
                        <i class="icon-pageview"></i>
                        <span class="truncate">Ver Pagos</span>
                    </a>
                </div>
            @endcan
        </div>
        <div id="mode" class="modal modal-sm">
            <div class="">
                <div class="modal-content">
                    <h5 class="center-align">Taquillas</h5>
                </div>
                <div class="modal-footer">
                    <div class="content row">




                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.lateral-bar')
@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/data/sysq.js') }}"></script>
@endsection