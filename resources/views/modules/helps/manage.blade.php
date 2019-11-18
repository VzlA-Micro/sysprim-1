@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('helps.manage') }}" class="breadcrumb">Ayuda</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection