@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('taxpayers.manage') }}">Gestionar Contribuyentes</a></li>
                </ul>
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