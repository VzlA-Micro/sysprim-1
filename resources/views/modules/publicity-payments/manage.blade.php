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
                    <li class="breadcrumb-item"><a href="{{ route('publicity.details', ['id' => $publicity->id]) }}">{{ $publicity->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.payments.manage', ['id' => $publicity->id]) }}">Mis Declaraciones</a></li>
                </ul>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('publicity.payments.create',['id' => $publicity->id]) }}" class="btn-app white green-text text-darken-2">
                    <i class="icon-payment"></i>
                    <span class="truncate">Declarar Mis Publicidades</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="" class="btn-app white green-text text-darken-2">
                    <i class="icon-payment"></i>
                    <span class="truncate">Historial de Declaraciones</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection