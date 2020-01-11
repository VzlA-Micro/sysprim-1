@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.my-properties') }}">Mis Inmuebles</a></li>
                </ul>
            </div>
            {{--@can('Consultar Mis Inmuebles')--}}
            @foreach($inmuebles as $inmueble)
                <div class="col s12 m4">
                    <a href="{{ route('show.inmueble', ['id' => $inmueble->id]) }}" class="btn-app white purple-text">
                        <i class="icon-location_city"></i>
                        <span class="truncate">{{ $inmueble->code_cadastral }}</span>
                    </a>
                </div>
            @endforeach
            {{--@endcan--}}
            {{--@can('Registar Mis Inmuebles')--}}
            <div class="col s12 m4">
                <a href="{{ route('properties.register') }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Agregar nuevo Inmueble...</span>
                </a>
            </div>
            {{--@endcan--}}
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection