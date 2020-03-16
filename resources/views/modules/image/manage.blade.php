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
                    <li class="breadcrumb-item"><a href="{{ route('settings.general')  }}">Configuración General</a></li>
                    <li class="breadcrumb-item"><a href="#!">Gestionar Imagenes</a></li>
                </ul>
            </div>
            @can('Registrar Imagen')
                <div class="col s6 m6 l4 animated bounceIn">
                    <a href="{{ route('register.images.manage') }}" class="btn-app white amber-text">
                        <i class="icon-loupe"></i>
                        <span class="truncate">Insertar Imagen</span>
                    </a>
                </div>
            @endcan
            @can('Consultar Imagenes')
                <div class="col s6 m6 l4 animated bounceIn">
                    <a href="{{ route('image.read') }}" class="btn-app white indigo-text">
                        <i class="icon-perm_media"></i>
                        <span class="truncate">Ver Imagenes</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection
@section('scripts')

@endsection