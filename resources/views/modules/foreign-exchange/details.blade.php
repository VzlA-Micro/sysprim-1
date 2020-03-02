@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{route('foreign-exchange.manage')}}">Gestionar de Monedas</a></li>
                    <li class="breadcrumb-item"><a href="{{route('foreign-exchange.read')}}">Consultar Monedas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('foreign-exchange.details',['id' => $foreignExchange->id]) }}">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" enctype="multipart/form-data" id="update">
                    @csrf
                    <div class="card-header center-align">
                        <h4>Detalles de Moneda</h4>
                    </div>
                    <div class="card-content row">
                        <input type="hidden" name="id" id="id" value="{{ $foreignExchange->id }}">


                        <div class="input-field col s12 m6">
                            <i class="icon-format_size prefix"></i>
                            <select name="name" id="name" required>
                                <option value="null" disabled>Selecciona la Moneda</option>
                                <option value="Petros" @if($foreignExchange->name == 'Petros') selected @endif>Petros</option>
                            </select>
                            <label for="name">Moneda</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-exposure_plus_1 prefix"></i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only only-number-positive" min="2"  maxlength="10" value="{{ $foreignExchange->value }}"  required readonly>
                            <label for="value">Valor</label>
                        </div>
                    </div>
                     @can('Actualizar Moneda')
                    <div class="card-footer center-align">
                        <a href="#!" class="btn btn-large blue btn-rounded waves-effect waves-light" id="btn-modify">
                            <i class="icon-update right"></i>
                            Modificar
                        </a>
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="btn-update">
                            <i class="icon-send right"></i>
                            Actualizar
                        </button>
                    </div>
                     @endcan
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/foreign-exchange.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection