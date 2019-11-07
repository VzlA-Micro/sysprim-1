@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('security.manage') }}" class="breadcrumb">Seguridad</a>
                <a href="{{ route('roles.manage') }}" class="breadcrumb">Gestionar Roles</a>
                <a href="{{ route('roles.manage') }}" class="breadcrumb">Consultar Roles</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection