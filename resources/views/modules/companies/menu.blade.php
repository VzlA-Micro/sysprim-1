@extends('layouts.app2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Empresa</a>
            </div>
            @include('sweet::alert')
            @foreach($companies as $company)
            <div class="col s12 m4">
                <a href="{{ route('companies.details', ['id' => $company->id]) }}" class="btn-app white purple-text">
                    <i class="icon-work"></i>
                    <span class="truncate">{{ $company->name }}</span>
                </a>
            </div>
            @endforeach
            <div class="col s12 m4">
                <a href="{{ route('companies.register') }}" class="btn-app white orange-text">
                    <i class="icon-add_circle"></i>
                    <span class="truncate">Agregar nueva empresa...</span>
                </a>
            </div>
        </div>
    </div>
@endsection