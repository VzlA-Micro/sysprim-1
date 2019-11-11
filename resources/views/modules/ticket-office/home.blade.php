@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('home.ticket-office') }}" class="breadcrumb">Taquilla</a>
            </div>
        <!--<div class="col s12 m3 animated bounceIn">
                <a href="{{ route('companies.my-business') }}" class="btn-app white blue-text">
                    <i class="icon-work"></i>
                    <span class="truncate">Atencion Al Cliente</span>
                </a>
            </div>
             <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('inmueble.my-property') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-location_city"></i>
                    <span class="truncate">Taquilla</span>
                </a>
            </div> -->
            <div class="col s12 m3 animated bounceIn">
                <a href="" class="btn-app white pink-text text-darken-2">
                    <i class="icon-person"></i>
                    <span class="truncate">Gestionar Contribuyentes</span>
                </a>
            </div>
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('payments.manage') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-payment"></i>
                    <span class="truncate">Gestionar Pagos</span>
                </a>
            </div>
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('companies.manage') }}" class="btn-app white light-green-text">
                    <i class="icon-work"></i>
                    <span class="truncate">Gestionar Empresas</span>
                </a>
            </div>
        </div>
    </div>
@endsection