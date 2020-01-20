@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.vehicle.home') }}">Taquilla Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="#">Gestionar Vehículos</a></li>
                </ul>
            </div>

            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('vehicles.register',['register'=>true]) }}" class="btn-app white light-green-text">
                    <i class="icon-add_box"></i>
                    <span class="truncate">Registrar Vehículos</span>
                </a>
            </div>

            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('ticketOffice.vehicle.read') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-list"></i>
                    <span class="truncate">Ver Vehículos</span>
                </a>
            </div>

        </div>
    </div>
@endsection