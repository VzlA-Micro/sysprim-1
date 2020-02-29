@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{route('foreign-exchange.manage')}}">Configuración de Monedas</a></li>
                    <li class="breadcrumb-item"><a href="#!">Registrar Moneda</a></li>
                </ul>
            </div>

            <form method="#" action="#" class="col s12 m8 offset-m2"
                  enctype="multipart/form-data" id="register">
                {{csrf_field()}}
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Moneda</h5>
                    </div>
                    <div class="card-content row">
                        {{-- <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Ej: Petro">
                            <i class="icon-format_size prefix"></i>
                            <input type="text" name="money" id="money" pattern="[a-zA-Z0-9 ]+"
                                   title="Solo puede escribir números y letra en mayúsculas." class="validate" maxlength="20" minlength="3" required>
                            <label for="money">Nombre de la Moneda</label>
                        </div> --}}

                        <div class="input-field col s12 m6">
                            <i class="icon-format_size prefix"></i>
                            <select name="name" id="name" required>
                                <option value="null" disabled selected>Selecciona la Moneda</option>
                                <option value="Petros">Petros</option>
                            </select>
                            <label for="name">Moneda</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-exposure_plus_1 prefix"></i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only only-number-positive"  maxlength="10"  required>
                            <label for="value">Valor</label>
                        </div>

                        <div class="input-field col s12 center-align">
                            <button type="submit" id="foreignExchangeRegister" class="btn btn-rounded btn-large peach waves-effect">
                                <i class="icon-send right"></i>Registrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/foreign-exchange.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection