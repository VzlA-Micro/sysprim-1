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




            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment.type',['type'=>'TRANSFERENCIA BANCARIA'])}}" class="btn-app white indigo-text">
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
                <a href="{{route('ticket-office.payment.type',['type'=>'DEPOSITO BANCARIO'])}}" class="btn-app white indigo-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Depositos</span>
                </a>
            </div>


            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment',['type'=>'PUNTO DE VENTA'])}}" class="btn-app white indigo-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Mi Taquilla(PUNTO DE VENTA)</span>
                </a>
            </div>


            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('ticket-office.payment',['type'=>'DEPOSITO BANCARIO'])}}" class="btn-app white indigo-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Mi Taquilla(DEPOSITO)</span>
                </a>
            </div>


        </div>
    </div>
@endsection
@section('scripts')

@endsection