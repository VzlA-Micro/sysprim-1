@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('companies.my-business') }}" class="btn-app white blue-text">
                    <i class="icon-work"></i>
                    <span class="truncate">Mis Empresas</span>
                </a>
            </div>
            <div class="col s12 m3">
                <a href="{{ route('fines.manage') }}" class="btn-app white deep-orange-text">
                    <i class="icon-warning"></i>
                    <span class="truncate">Gestionar Multas</span>
                </a>
            </div>
        </div>
    </div>
@endsection