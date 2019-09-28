@extends('layouts.app2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('companies.my-business') }}" class="btn-app white blue-text">
                    <i class="icon-work"></i>
                    <span class="truncate">Mis Empresas</span>
                </a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('payments.my-payments') }}" class="btn-app white green-text">
                    <i class="icon-payment"></i>
                    <span class="truncate">Mis Pagos</span>
                </a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('vehicles.my-vehicles') }}" class="btn-app white red-text">
                    <i class="icon-local_shipping"></i>
                    <span class="truncate">Mis Vehículos</span>
                </a>
            </div>
        </div>
    </div>
@endsection