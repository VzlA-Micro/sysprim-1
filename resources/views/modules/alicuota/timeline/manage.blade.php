@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.property') }}">Configuración de Inmuebles Urbanos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.manage') }}" >Gestionar Alicuota Inmuebles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.timeline.manage') }}" >Linea de Tiempo</a></li>
                </ul>
            </div>
            {{--@can('Consultar Alicuotas')--}}
                <div class="col s12 m4 animated bounceIn">
                    <a href="{{ route('alicuota.timeline.register') }}" class="btn-app white green-text accent-1">
                        <i class="icon-format_list_bulleted"></i>
                        <span class="truncate">Registrar Linea de Tiempo</span>
                    </a>
                </div>
            {{--@endcan--}}

            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('alicuota.timeline.read') }}" class="btn-app white green-text accent-1">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Consultar Linea de Tiempo</span>
                </a>
            </div>

        </div>
    </div>
@endsection
@section('scripts')

@endsection