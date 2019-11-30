@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                </ul>
            </div>
            @include('sweet::alert')
            @foreach($companies as $company)
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('companies.details', ['id' => $company->id]) }}" class="btn-app white purple-text">
                    <i class="icon-work"></i>
                    <span class="truncate">{{ $company->name }}</span>
                </a>
            </div>
            @endforeach
            <div class="col s12 m4 animated bounceIn">
                <a href="{{ route('companies.register') }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Agregar nueva empresa...</span>
                </a>
            </div>
        </div>
    </div>
@endsection