@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <<a href="{{ route('home.ticket-office') }}" class="breadcrumb">Taquilla</a>
                <a href="{{ route('taxpayers.manage') }}" class="breadcrumb">Gestionar Contribuyentes</a>
                <a href="{{ route('taxpayers.read') }}" class="breadcrumb">Ver Contribuyentes</a>
                <a href="#!" class="breadcrumb">Detalles</a>
            </div>
            .
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection