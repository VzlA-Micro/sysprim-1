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
                    <li class="breadcrumb-item"><a href="{{ route('bank.rate.manage') }}">Gestionar Tasa del Banco</a></li>
                </ul>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('bank.rate.register') }}" class="btn-app white cyan-text">
                    <i class="icon-add"></i>
                    <span class="truncate">Registrar Tasa</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('bank.rate.read') }}" class="btn-app white amber-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Tasas</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection