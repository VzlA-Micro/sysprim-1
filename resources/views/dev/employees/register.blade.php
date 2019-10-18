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
                <form id="register" action="{{route('saveEmployees')}}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar rebaja por empleado</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <input type="number" name="min" id="min" required>
                            <label for="min">Minimo de empleado</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="max" id="max" required>
                            <label for="valueUndTributo">Maximo de empleado</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="rebaja" id="rebaja" required>
                            <label for="valueUndTributo">Porcentaje de rebaja</label>
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