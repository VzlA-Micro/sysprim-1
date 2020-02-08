@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.verify.manage') }}">Verificación de Pagos</a></li>
                </ul>
            </div>
            @can('Cargar Archivo Pagos')
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('bank.upload') }}" class="btn-app white amber-text">
                    <i class="icon-file_upload"></i>
                    <span class="truncate">Cargar Pagos</span>
                </a>
            </div>
            @endcan
            @can('Ver Pagos verificados')
                <div class="col s12 m4 animated bounceIn">
                    <a href="{{ route('bank.read') }}" class="btn-app white indigo-text">
                        <i class="icon-assignment_ind"></i>
                        <span class="truncate">Ver Pagos Verificados del Día</span>
                    </a>
                </div>
                <div class="col s12 m4 animated bounceIn">
                    <a href="{{ route('bank.read.full') }}" class="btn-app white indigo-text">
                        <i class="icon-list"></i>
                        <span class="truncate">Ver Pagos Verificados Totales</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection