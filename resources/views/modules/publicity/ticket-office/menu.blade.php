@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.publicity.home') }}">Taquilla - Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ticketOffice.publicity.managePublicity')}}">Gestionar Publicidad</a></li>
                </ul>
            </div>
            @can('Registrar Vehiculo')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('ticketOffice.publicity.register')}}" class="btn-app white purple-text">
                    <i class="icon-add_box"></i>
                    <span class="truncate">Registrar Publicidad</span>
                </a>
            </div>
            @endcan
            @can('Consultar Vehiculos')
            <div class="col s12 m3 animated bounceIn">
                <a href="{{ route('ticketOffice.publicity.read') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-list"></i>
                    <span class="truncate">Ver Publicidad</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection