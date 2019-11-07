@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('payments.manage') }}" class="breadcrumb">Gestionar Pagos</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('payments.register') }}" class="btn-app white amber-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Pago</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('payments.read') }}" class="btn-app white indigo-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Ver Pagos</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection