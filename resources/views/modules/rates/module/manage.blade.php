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
                    <li class="breadcrumb-item"><a href="{{ route('rate.manager') }}">Gestionar Tasa</a></li>
                </ul>
            </div>
            @can('Registrar Tasa')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('rate.register') }}" class="btn-app white cyan-text">
                    <i class="icon-add"></i>
                    <span class="truncate">Registrar Tasa</span>
                </a>
            </div>
            @endcan
            @can('Consultar Tasas')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('rate.index') }}" class="btn-app white amber-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Tasas</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection