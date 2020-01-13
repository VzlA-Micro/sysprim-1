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
            @foreach($publicities as $publicity)
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('publicity.details', ['id' => $publicity->id]) }}" class="btn-app white purple-text">
                    <i class="icon-work"></i>
                    <span class="truncate">{{ $publicity->name }}</span>
                </a>
            </div>
            @endforeach
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('publicity.register.types') }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Agregar nueva publicidad...</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection