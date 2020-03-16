@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="#!">Configuración General</a></li>
                </ul>
            </div>
            
            @can('Gestionar Unidad Tribuaria')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('tax-unit.manage') }}" class="btn-app white green-text ">
                    <i class="icon-exposure_plus_1"></i>
                    <span class="truncate">Gestionar Unidades Tributarias</span>
                </a>
            </div>
            @endcan                  
            @can('Gestionar Recargos')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('recharges.manage') }}" class="btn-app white green-text text-darken-4">
                    <i class="icon-trending_up"></i>
                    <span class="truncate">Gestionar Recargos</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Accesorios')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('accessories.manage') }}" class="btn-app white blue-text text-darken-4">
                    <i class="icon-filter_tilt_shift"></i>
                    <span class="truncate">Gestionar Accesorios</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Tasas del Banco')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{ route('bank.rate.manage') }}" class="btn-app white cyan-text">
                    <i class="icon-business_center"></i>
                    <span class="truncate">Gestionar Tasa del Banco</span>
                </a>
            </div>
            @endcan


            @can('Gestionar Dias de Cobro')
            <div class="col s6 m6 l4 animated bounceIn">
                <a href="{{route('prologue.manage')}}" class="btn-app white purple-text text-darken-2">
                    <i class="icon-date_range"></i>
                    <span class="truncate">Días de Cobros</span>
                </a>
            </div>
            @endcan
            @can('Gestionar Imagenes')
                <div class="col s6 m6 l4 animated bounceIn">
                    <a href="{{route('settings.images.manage')}}" class="btn-app white pink-text text-darken-2">
                        <i class="icon-panorama"></i>
                        <span class="truncate">Gestionar Fotos</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection