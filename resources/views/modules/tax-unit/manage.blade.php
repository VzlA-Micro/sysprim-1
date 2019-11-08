@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('tax-unit.manage') }}" class="breadcrumb">Gestionar Unidad Tributaria</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('tax-unit.register') }}" class="btn-app white red-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Unidad Tributaria</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('tax-unit.read') }}" class="btn-app white blue-text">
                    <i class="icon-playlist_add_check"></i>
                    <span class="truncate">Ver Unidades Tributarias</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection