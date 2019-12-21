@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('vehicles.my-vehicles') }}" class="breadcrumb">Mis Vehículos</a>   
                <a href="{{ route('vehicles.register') }}" class="breadcrumb">Registrar Vehículo</a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('vehicles.models.register') }}" class="btn-app white green-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Registrar Modelos De Vehículo</span>
                </a>
            </div>
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('vehicles.models.read') }}" class="btn-app white amber-text">
                    <i class="icon-directions_car"></i>
                    <span class="truncate">Ver Modelos De Vehículos</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection