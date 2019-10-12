@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Gestionar Multas</a>
                <a href="" class="breadcrumb">Registrar Nueva Multa</a>
            </div>
            <div class="col s12 m8 offset-m2">
                <form id="register" action="{{ route('fines.save') }}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Multa</h5>
                    </div>
                    <div class="card-content row">
                       <div class="input-field col s12 m6">
                            <input type="text" name="name" id="name" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="undTributo" id="undTributo" required>
                            <label for="undTributo">Cantidad de unidades tributarias</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded waves-effect waves-light blue">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection