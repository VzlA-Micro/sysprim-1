@extends('layouts.app2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Empresa</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
            </div>
            <div class="col s12 m4">
                <a href="{{route('payments.create',['company'=>session('company')])}}" class="btn-app white green-text">
                    <i class="icon-account_balance"></i>
                    <span class="truncate">Pagar mis Impuestos</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="" class="btn-app white amber-text">
                    <i class="icon-assistant"></i>
                    <span class="truncate">Pagar mi Publicidad</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="" class="btn-app white indigo-text">
                    <i class="icon-local_shipping"></i>
                    <span class="truncate">Pagar mis Vehículos</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="{{route('payments.history',['company'=>session('company')])}}" class="btn-app white orange-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Historial de Pagos</span>
                </a>
            </div>
        </div>
    </div>
@endsection