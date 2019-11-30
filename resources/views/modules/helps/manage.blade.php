@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
        	<div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('helps.manage') }}">Ayuda</a></li>
                </ul>
            </div>
            <div class="col s12">
                <ul class="collection with-header">
                    <li class="collection-header center-align"><h4>Ayuda</h4></li>
                    <li class="collection-item">
                        <div>
                            Registrar mi Empresa
                            <a href="{{ route('help.register-company') }}" class="secondary-content"><i class="icon-send red-text text-darken-2" style="font-size: 22px;"></i></a>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            Conciliar Impuestos
                            <a href="#!" class="secondary-content"><i class="icon-send red-text text-darken-2" style="font-size: 22px;"></i></a>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            Alvin
                            <a href="#!" class="secondary-content"><i class="icon-send red-text text-darken-2" style="font-size: 22px;"></i></a>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            Alvin
                            <a href="#!" class="secondary-content"><i class="icon-send red-text text-darken-2" style="font-size: 22px;"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection