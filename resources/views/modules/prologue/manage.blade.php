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
                    <li class="breadcrumb-item"><a href="{{ route('prologue.manage') }}">Gestionar Dias de Cobros</a></li>
                </ul>
            </div>

            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('prologue.index') }}" class="btn-app white amber-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Días de Cobro</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection