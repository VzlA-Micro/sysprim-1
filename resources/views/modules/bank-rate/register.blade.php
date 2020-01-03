@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bank.rate.manage') }}">Gestionar Tasa del Banco</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bank.rate.register') }}">Registrar</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" id="register">
                    <div class="card-header center-align">
                        <h4>Registrar Tasa</h4>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m12">
                            <input type="text" name="value" id="value" class="validate number-only-float">
                            <label for="value">Valor Tasa</label>
                        </div>
                    </div>


                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/bank-rate.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection