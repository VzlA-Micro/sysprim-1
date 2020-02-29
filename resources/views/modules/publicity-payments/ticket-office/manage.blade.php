@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.publicity.home') }}">Taquilla - Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.ticket-office.manage') }}">Gestionar Pagos</a></li>
                </ul>
            </div>
            @can('Generar Planilla')
                <div class="col s6 m6 l4 animated bounceIn">
                    <a href="{{route('publicity.ticket-office.generate')}}" class="btn-app white red-text">
                        <i class="icon-picture_as_pdf"></i>
                        <span class="truncate">Generar Planilla</span>
                    </a>
                </div>
            @endcan
            @can('Pagar Planilla')
                <div class="col s6 m6 l4 animated bounceIn">
                    <a href="{{route('publicity.ticket-office.payments.taxes')}}" class="btn-app white blue-text text-darken-3">
                        <i class="icon-payment"></i>
                        <span class="truncate">Pagar Planilla</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection