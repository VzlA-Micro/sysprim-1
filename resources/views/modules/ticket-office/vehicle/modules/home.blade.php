@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquilla Vehículos</a></li>
                </ul>
            </div>
            @can('Gestionar Vehiculos')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('ticketOffice.vehicle.manage') }}" class="btn-app white light-green-text">
                    <i class="icon-directions_car"></i>
                    <span class="truncate">Gestionar Vehículos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Pagos')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('ticketOffice.vehicle.payments') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-payment"></i>
                    <span class="truncate">Gestionar Pagos</span>
                </a>
            </div>
            @endcan
            @can('Verificar Pagos - Archivo')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('payments.verify.manage') }}" class="btn-app white orange-text text-darken-4">
                    <i class="icon-file_upload"></i>
                    <span class="truncate">Verificación de Pagos</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection