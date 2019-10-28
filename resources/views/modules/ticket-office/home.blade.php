@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('atencion.home') }}" class="btn-app white blue-text">
                    <i class="icon-person"></i>
                    <span class="truncate">Atencion Al Cliente</span>
                </a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('inmueble.my-property') }}" class="btn-app white grey-text text-darken-2">
                    <i class="icon-desktop_mac"></i>
                    <span class="truncate">Taquilla</span>
                </a>
            </div>
        </div>
    </div>
@endsection