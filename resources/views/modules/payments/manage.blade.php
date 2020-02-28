@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla - Actividad Económica</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Gestionar Pagos</a></li>
                </ul>
            </div>
            @can('Generar Planilla')
            <div class="col s6 m4 animated bounceIn">
                <a href="{{ route('ticket-office.payments') }}" class="btn-app white blue-text">
                    <i class="icon-insert_drive_file"></i>
                    <span class="truncate">Generar Planilla</span>
                </a>
            </div>
            @endcan
            @can('Pagar Planilla')
            <div class="col s6 m4 animated bounceIn">
                <a href="{{ route('ticket-office.taxes.getTaxes')}}" class="btn-app white amber-text">
                    <i class="icon-payment"></i>
                    <span class="truncate">Pagar Planilla</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')

@endsection