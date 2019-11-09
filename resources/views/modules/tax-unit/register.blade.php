@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('settings.manage') }}" class="breadcrumb">Configuración</a>
                <a href="{{ route('tax-unit.manage') }}" class="breadcrumb">Gestionar Unidad Tributaria</a>
                <a href="{{ route('tax-unit.register') }}" class="breadcrumb">Registrar</a>
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