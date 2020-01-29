@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.home') }}">Taquillas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticketOffice.vehicle.home') }}">Taquilla Vehículos</a></li>
                    <li class="breadcrumb-item"><a href="#">Gestionar Pagos</a></li>
                </ul>
            </div>
            @can('Generar Planilla')
                <div class="col s12 m4 animated bounceIn">
                    <a href="{{ route('ticketOffice.vehicle.payments.create') }}" class="btn-app white blue-text">
                        <i class="icon-insert_drive_file"></i>
                        <span class="truncate">Generar Planilla</span>
                    </a>
                </div>
            @endcan
            @can('Pagar Planilla')
                <div class="col s12 m4 animated bounceIn">
                    <a href="{{ route('ticket-office.taxes.getTaxes')}}" class="btn-app white amber-text">
                        <i class="icon-payment"></i>
                        <span class="truncate">Pagar Planilla</span>
                    </a>
                </div>
            @endcan
            {{--@can('Ver Planillas')
                <div class="col s12 m4 animated bounceIn">
                    <a href="{{route('ticket-office.pay.web')}}" class="btn-app white indigo-text">
                        <i class="icon-library_books"></i>
                        <span class="truncate">Lista de Planillas</span>
                    </a>
                </div>
            @endcan
            @can('Ver Pagos')
                <div class="col s12 m4 animated bounceIn">
                    <a href="{{ route('ticket-office.type.payments') }}" class="btn-app white indigo-text">
                        <i class="icon-format_list_bulleted"></i>
                        <span class="truncate">Ver Pagos</span>
                    </a>
                </div>
            @endcan--}}
        </div>
    </div>
@endsection
@section('scripts')

@endsection