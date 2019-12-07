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
                    <li class="breadcrumb-item"><a href="#!">{{ $inmuebles[0]->code_cadastral }}</a></li>
                    <li class="breadcrumb-item"><a href="#!">Mis Pagos</a></li>
                </ul>
            </div>
			<div class="col s12 m4">
                <a href="{{ route('propertyStatement',['id'=>$inmuebles[0]->id]) }}" class="btn-app white red-text">
                    <i class="icon-store_mall_directory"></i>
                    <span class="truncate">Pagar mi Inmueble</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="#!" class="btn-app white orange-text">
                    <i class="icon-format_list_bulleted"></i>
                    <span class="truncate">Historial de Pagos</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection