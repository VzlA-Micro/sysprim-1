@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                    <li class="breadcrumb-item"><a href="#" class="preview-view">{{ session('company') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.my-payments', ['company' => session('company')]) }}">Mis Declaraciones</a></li>
                </ul>
            </div>
            @can('Declaración Anticipada - Actividad Económica')
            <div class="col s6 m4 animated bounceIn">
                <a href="{{ route('payments.create',['company'=>session('company'),'type'=>'actuated']) }}" class="btn-app white">
                    <i class="icon-account_balance grey-text"></i>
                    <span class="truncate black-text">Declaración  ANTICIPADA - Actividad Económica</span>
                </a>
            </div>
            @endcan
            @can('Declaración Definitiva - Actividad Económica')
            <div class="col s6 m4 animated bounceIn">
                <a href="{{ route('payments.create',['company'=>session('company'),'type'=>'definitive']) }}" class="btn-app white green-text">
                    <i class="icon-account_balance"></i>
                    <span class="truncate">Declaración  DEFINITIVA - Actividad Económica</span>
                </a>
            </div>
            @endcan


            {{-- <div class="col s12 m4 animated bounceIn">
                <a href="" class="btn-app white amber-text">
                    <i class="icon-assistant"></i>
                    <span class="truncate">Declarar mi Publicidad Comercial</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="" class="btn-app white indigo-text">
                    <i class="icon-local_shipping"></i>
                    <span class="truncate">Declarar mis Vehículos</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="" class="btn-app white red-text">
                    <i class="icon-store_mall_directory"></i>
                    <span class="truncate">Declarar mis Inmuebles</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="" class="btn-app white cyan-text">
                    <i class="icon-speaker"></i>
                    <span class="truncate">Declarar mis Eventos</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                    <a href="{{route('fines.manage',['company'=>session('company')])}}" class="btn-app white orange-text">
                    <i class="icon-warning"></i>
                    <span class="truncate">Declarar mis Multas</span>
                </a>
            </div> --}}
            @can('Historial de Pagos - Actividad Económica')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('payments.history',['company'=>session('company')]) }}" class="btn-app white orange-text">
                    <i class="icon-assignment"></i>
                    <span class="truncate">Historial de Pagos</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection


