@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla - Actividad Económica</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.manage') }}">Gestionar Empresas</a></li>
                </ul>
            </div>
            @can('Registrar Empresa')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('tickOffice.companies.register') }}" class="btn-app white teal-text text-darken-2">
                    <i class="icon-add_box"></i>
                    <span class="truncate">Registrar Empresa</span>
                </a>
            </div>
            @endcan
            @can('Consultar Empresas')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('companies.read') }}" class="btn-app white indigo-text">
                    <i class="icon-playlist_add_check"></i>
                    <span class="truncate">Ver Empresas</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection