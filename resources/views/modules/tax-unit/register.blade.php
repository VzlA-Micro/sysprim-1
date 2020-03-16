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
                    <li class="breadcrumb-item"><a href="{{ route('settings.general') }}">Configuración General</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tax-unit.manage') }}">Gestionar Unidad Tributaria</a>
                    </li>
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
                            <label for="since_date">Fecha de Inicio</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-date_range prefix"></i>
                            <input type="text" name="to_date" id="to_date" class="datepicker" required>
                            <label for="to_date">Fecha de Fin</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS"
                                     width="100%" height="100%">
                            </i>
                            <input type="text" name="valueUndTributo" id="valueUndTributo" required
                                   class="validate number-only only-number-positive " maxlength="5">
                            <label for="valueUndTributo">Valor de unidad tributaria</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">
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
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/data/tax-unit.js') }}"></script>
@endsection