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
                    <li class="breadcrumb-item"><a href="{{ route('tax-unit.manage') }}">Gestionar Unidad Tributaria</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tax-unit.register') }}">Registrar</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form id="register" action="{{ route('tax-unit.save') }}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Unidad Tributaria</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>
                            <input type="text" name="since_date" id="since_date" class="datepicker" required>
                            <label for="opening_date">Fecha de Inicio</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>
                            <input type="text" name="to_date" id="to_date" class="datepicker" required>
                            <label for="opening_date">Fecha de Fin</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="number" name="valueUndTributo" id="valueUndTributo" required>
                            <label for="valueUndTributo">Valor de unidad tributaria</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">
                            <i class="icon-send right"></i>
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection