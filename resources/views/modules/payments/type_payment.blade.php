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
                    <li class="breadcrumb-item"><a href="{{ route('ticket-office.payment') }}">Ver Pagos</a></li>
                </ul>
            </div>

            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment.type',['type'=>'TRANSFERENCIA'])}}" class="btn-app white indigo-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Transferencias</span>
                </a>
            </div>

            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment.type',['type'=>'PUNTO DE VENTA'])}}" class="btn-app white indigo-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Punto de Venta</span>
                </a>
            </div>




            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.pay.web')}}" class="btn-app white indigo-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Planillas Web</span>
                </a>
            </div>



        </div>
    </div>
@endsection
@section('scripts')

@endsection