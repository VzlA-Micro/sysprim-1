@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Empresa</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Historial de Pagos</a>
                <a href="" class="breadcrumb">Conciliar Pago</a>
            </div>
            <div class="col s12 m8 offset-m2">
                <form id="register" action="{{route('saveTributo')}}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Unidad Tributaria</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <input type="text" name="since_date" id="since_date" class="datepicker" required>
                            <label for="opening_date">Fecha de Inicio</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="to_date" id="to_date" class="datepicker" required>
                            <label for="opening_date">Fecha de Fin</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="valueUndTributo" id="valueUndTributo" required>
                            <label for="valueUndTributo">Valor de unidad tributaria</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn waves-effect waves-light blue">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection