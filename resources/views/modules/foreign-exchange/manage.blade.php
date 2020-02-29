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
                    <li class="breadcrumb-item"><a href="{{-- route('accessories.manage') --}}">Gestionar Monedas</a></li>
                </ul>
            </div>
            {{-- @can('Registrar Accesorio') --}}
            <div class="col s6 m4 animated bounceIn">
                <a href="{{ route('foreign-exchange.register') }}" class="btn-app white green-text text-darken-3">
                    <i class="fab fa-cc-diners-club"></i>
                    <span class="truncate">Registrar Moneda</span>
                </a>
            </div>
            {{-- @endcan --}}
            {{-- @can('Consultar Accesorios') --}}
            <div class="col s6 m4 animated bounceIn">
                <a href="{{ route('foreign-exchange.read') }}" class="btn-app white amber-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Monedas</span>
                </a>
            </div>
            {{-- @endcan --}}
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection