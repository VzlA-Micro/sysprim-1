@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.manage') }}" class="breadcrumb">Gestionar Empresas</a>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('companies.register') }}" class="btn-app white teal-text text-darken-2">
                    <i class="icon-add_box"></i>
                    <span class="truncate">Registrar Empresa</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('companies.read') }}" class="btn-app white indigo-text">
                    <i class="icon-playlist_add_check"></i>
                    <span class="truncate">Ver Empresas</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection