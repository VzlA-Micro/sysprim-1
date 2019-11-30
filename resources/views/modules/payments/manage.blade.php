@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Gestionar Pagos</a></li>
                </ul>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('ticket-office.payments') }}" class="btn-app white amber-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Pagar Impuestos</span>
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