@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                </ul>
            </div>
            {{-- <div class="col s12 m4"></div> --}}
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('publicity.register') }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Agregar nueva publicidad...</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection