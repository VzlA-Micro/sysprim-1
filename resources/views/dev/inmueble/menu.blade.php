@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mis Inmuebles</a>
            </div>
            @include('sweet::alert')

            @foreach($inmuebles as $inmueble)
                <div class="col s12 m4">
                    <a href="{{ route('show.inmueble', ['id' => $inmueble->id]) }}" class="btn-app white purple-text">
                        <i class="icon-location_city"></i>
                        <span class="truncate">{{ $inmueble->code_cadastral }}</span>
                    </a>
                </div>
            @endforeach

            <div class="col s12 m4">
                <a href="{{ route('registerInmueble') }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Agregar nuevo Inmueble...</span>
                </a>
            </div>
        </div>
    </div>
@endsection