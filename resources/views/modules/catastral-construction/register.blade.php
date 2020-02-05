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
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.construction.manage') }}">Gestionar Valor de Contrucción Catastral</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catrastal.construction.register') }}">Registrar  Valor de Contrucción Catastral</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" id="register">
                    <div class="card-header center-align">
                        <h4>Registrar Valor de Contrucción Catastral </h4>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <i class="icon-data_usage prefix"></i>
                            <input type="text" name="name" id="name" required>
                            <label for="name">Nombre</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-verified_user prefix "></i>
                            <input type="number" name="value" id="value" class="validate number-date" required >
                            <label for="value">Valor UTC</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-question_answer prefix"></i>
                            <select name="regimen_horizontal" id="regimen_horizontal">
                                <option value="null" selected disabled>...</option>
                                <option value=true>Si</option>
                                <option value=false>No</option>
                            </select>
                            <label for="regime_horizontal">Regimen Horizontal</label>
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
    <script src="{{ asset('js/data/accessories.js') }}"></script>
@endsection