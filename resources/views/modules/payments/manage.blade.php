@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('home.ticket-office') }}" class="breadcrumb">Taquilla</a>
                <a href="{{ route('payments.manage') }}" class="breadcrumb">Gestionar Pagos</a>
            </div>


            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ticket-office.payments') }}" class="btn-app white blue-text">
                    <i class="icon-insert_drive_file"></i>
                    <span class="truncate">Generar Planilla</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ticket-office.taxes.getTaxes')}}" class="btn-app white amber-text">
                    <i class="icon-payment"></i>
                    <span class="truncate">Pagar Planilla</span>
                </a>
            </div>

            <div class="col s12 m4 animated bounceIn">


                @if(\Auth::user()->role_id===1)
                    <a href="{{ route('ticket-office.type.payments') }}" class="btn-app white indigo-text">
                        <i class="icon-format_list_bulleted"></i>
                        <span class="truncate">Ver Pagos</span>
                    </a>
                @else
                    <a href="{{ route('ticket-office.payment') }}" class="btn-app white indigo-text">
                        <i class="icon-format_list_bulleted"></i>
                        <span class="truncate">Ver Pagos</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection