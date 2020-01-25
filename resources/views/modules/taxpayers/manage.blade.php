@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    {{-- <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li> --}}
                    <li class="breadcrumb-item"><a href="{{ route('taxpayers.manage') }}">Gestionar Usuarios Web</a></li>
                </ul>
            </div>
            @can('Registrar Contribuyente')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('taxpayers.register') }}" class="btn-app white green-text text-darken-2">
                    <i class="icon-person_add"></i>
                    <span class="truncate">Registrar Usuario Web</span>
                </a>
            </div>
            @endcan
            @can('Consultar Contribuyentes')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('taxpayers.read') }}" class="btn-app white indigo-text">
                    <i class="icon-assignment_ind"></i>
                    <span class="truncate">Ver Usuarios Web</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection