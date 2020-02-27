@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    @if(session()->has('company'))
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => session('company')->id]) }}">{{ session('company')->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{ route('publicity.my-publicity') }}">Mis Publicidades</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.details', ['id' => $publicity->id]) }}">{{ $publicity->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('publicity.payments.manage', ['id' => $publicity->id]) }}">Mis Declaraciones</a></li>
                </ul>
            </div>
            @if($publicity->status != 'disabled')
            @can('Declarar Publicidades')
            <div class="col s6 m4">
                <a href="{{ route('publicity.payments.create',['id' => $publicity->id]) }}" class="btn-app white red-text text-darken-2">
                    <i class="icon-payment"></i>
                    <span class="truncate">Declarar Mis Publicidades</span>
                </a>
            </div>
            @endcan
            @endif
            @can('Historial de Pagos - Publicidades')
            <div class="col s6 m4">
                <a href="{{ route('publicity.payments.history',['id' => $publicity->id]) }}" class="btn-app white purple-text text-darken-2">
                    <i class="icon-list"></i>
                    <span class="truncate">Historial de Declaraciones</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection