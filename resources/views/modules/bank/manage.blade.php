@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('payments.verify.manage') }}" class="breadcrumb">Verificación de Pagos</a>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('bank.upload') }}" class="btn-app white amber-text">
                    <i class="icon-file_upload"></i>
                    <span class="truncate">Cargar Pagos</span>
                </a>
            </div>
            <div class="col s12 m4">
                <a href="{{ route('users.read') }}" class="btn-app white indigo-text">
                    <i class="icon-assignment_ind"></i>
                    <span class="truncate">Ver ???</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection