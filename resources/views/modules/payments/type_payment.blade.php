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
                    <li class="breadcrumb-item"><a href="{{route('ticket-office.type.payments') }}">Ver Pagos</a></li>
                </ul>
            </div>
            @can('Ver Pagos - Transferencias')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment.type',['type'=>'TRANSFERENCIA BANCARIA'])}}" class="btn-app white indigo-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Transferencias</span>
                </a>
            </div>
            @endcan
            @can('Ver Pagos - Punto de Venta')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment.type',['type'=>'PUNTO DE VENTA'])}}" class="btn-app white red-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Punto de Venta</span>
                </a>
            </div>
            @endcan
            @can('Ver Pagos - Depositos')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment.type',['type'=>'DEPOSITO BANCARIO'])}}" class="btn-app white green-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Depositos</span>
                </a>
            </div>
            @endcan
            @can('Ver Pagos - Depositos')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{-- route('ticket-office.payment.type',['type'=>'CHEQUES']) --}} {{ route('ticket-office.payment.type.checks') }}" class="btn-app white cyan-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Cheques</span>
                </a>
            </div>
            @endcan
            @can('Mi Taquilla - Punto de Venta')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment',['type'=>'PUNTO DE VENTA'])}}" class="btn-app white orange-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Mi Taquilla (PUNTO DE VENTA)</span>
                </a>
            </div>
            @endcan
            @can('Mi Taquilla - Deposito')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment',['type'=>'DEPOSITO BANCARIO'])}}" class="btn-app white amber-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Mi Taquilla (DEPOSITO)</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')

@endsection