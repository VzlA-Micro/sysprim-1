@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('rate.taxpayers.menu')}}">Mis Tasas</a></li>
                </ul>
            </div>
            @can('Declarar Tasas')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('rate.taxpayers.register')}}" class="btn-app white indigo-text">
                    <i class="icon-add_box"></i>
                    <span class="truncate">Declarar Tasa</span>
                </a>
            </div>
            @endcan
            @can('Historial de Pagos - Tasas')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{route('rate.taxpayers.payment.history')}}" class="btn-app white orange-text">
                    <i class="icon-assignment"></i>
                    <span class="truncate">Historial de Pagos</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection