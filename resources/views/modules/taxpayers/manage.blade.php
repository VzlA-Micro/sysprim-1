@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('home.ticket-office') }}" class="breadcrumb">Taquilla</a>
                <a href="{{ route('taxpayers.manage') }}" class="breadcrumb">Gestionar Contribuyentes</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('taxpayers.register') }}" class="btn-app white green-text text-darken-2">
                    <i class="icon-person_add"></i>
                    <span class="truncate">Registrar Contribuyente</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('taxpayers.read') }}" class="btn-app white indigo-text">
                    <i class="icon-assignment_ind"></i>
                    <span class="truncate">Ver Contribuyentes</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection