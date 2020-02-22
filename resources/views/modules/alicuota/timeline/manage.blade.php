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
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.manage') }}" >Gestionar Alícuota Inmuebles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.timeline.manage') }}" >Línea de Tiempo</a></li>
                </ul>
            </div>
            {{--@can('Consultar Alicuotas')--}}
                <div class="col s12 m4 animated bounceIn">
                    <a href="{{ route('alicuota.timeline.register') }}" class="btn-app white blue-grey-text">
                        <i class="icon-alarm_add"></i>
                        <span class="truncate">Registrar Línea de Tiempo</span>
                    </a>
                </div>
            {{--@endcan--}}

            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('alicuota.timeline.read') }}" class="btn-app white blue-grey-text">
                    <i class="icon-schedule"></i>
                    <span class="truncate">Consultar Línea de Tiempo</span>
                </a>
            </div>

        </div>
    </div>
@endsection
@section('scripts')

@endsection