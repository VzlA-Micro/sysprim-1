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

            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('companies.manage') }}" class="btn-app white light-green-text">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla Empresas</span>
                </a>
            </div>

            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('ticketOffice.vehicle.home') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-personal_video"></i>
                    <span class="truncate">Taquilla Vehículos</span>
                </a>
            </div>

        </div>
    </div>
@endsection