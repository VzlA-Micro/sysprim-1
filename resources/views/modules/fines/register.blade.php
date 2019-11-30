@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fines.manage') }}">Gestionar Multas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fines.register') }}">Registrar Multa</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form id="register" action="{{ route('fines.save') }}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Multa</h5>
                    </div>
                    <div class="card-content row">
                       <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>                                                                                   
                            <input type="text" name="name" id="name" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-swap_vertical_circle prefix"></i>                                                        
                            <input type="number" name="undTributo" id="undTributo" required>
                            <label for="undTributo">Cantidad de unidades tributarias</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded btn-large waves-effect waves-light peach">
                            Register
                            <i class="icon-send right"></i>
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