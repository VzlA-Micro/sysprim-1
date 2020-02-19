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
                    <li class="breadcrumb-item"><a href="{{ route('settings.general') }}">Configuración General</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bank.rate.manage') }}">Gestionar Tasa del Banco</a></li>
                </ul>
            </div>
            @can('Registrar Tasa de Banco')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('bank.rate.register') }}" class="btn-app white blue-text">
                    <i class="icon-add"></i>
                    <span class="truncate">Registrar Tasa de Bancos</span>
                </a>
            </div>
            @endcan
            @can('Consultar Tasas del Banco')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('bank.rate.read') }}" class="btn-app white red-text ">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Tasas de Bancos</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection