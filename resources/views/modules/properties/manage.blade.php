@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    @if(isset($company))
                    <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.details', ['id' => $company->id]) }}">{{ $company->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="{{ route('properties.my-properties') }}">Mis Inmuebles</a></li>
                </ul>
            </div>
            @can('Consultar Mis Inmuebles')
            @foreach($properties as $property)
                <div class="col s12 m4">
{{--                    <a href="{{ route('properties.details', ['id' => $property->id]) }}" class="btn-app white purple-text">--}}
                <a href="{{ route('properties.details',['id' => $property->id]) }}" class="btn-app white purple-text">
                    <i class="icon-location_city"></i>
                        <span class="truncate">{{ $property->code_cadastral }}</span>
                    </a>
                </div>

            @endforeach
            @endcan
            @can('Registrar Mis Inmuebles')
            <div class="col s12 m4">
                @if(isset($company))
                <a href="{{ route('properties.register', ['company_id' => $company->id]) }}" class="btn-app white orange-text">
                @else
                <a href="{{ route('properties.register') }}" class="btn-app white orange-text">
                @endif
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Agregar nuevo Inmueble...</span>
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection