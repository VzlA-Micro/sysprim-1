@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('property.ticket-office.home') }}">Taquilla - Inmuebles Urbanos</a></li>
                </ul>
            </div>

            <div class="col s12 m3 animated bounceIn">
                <a href="#" class="btn-app white grey-text text-darken-2">
                    <i class="icon-location_city"></i>
                    <span class="truncate">Gestionar Inmuebles Urbanos</span>
                </a>
            </div>


            <div class="col s12 m3 animated bounceIn">
                <a href="#" class="btn-app white grey-text text-darken-2">
                    <i class="icon-payment"></i>
                    <span class="truncate">Gestionar Pagos</span>
                </a>
            </div>


        </div>
    </div>
@endsection