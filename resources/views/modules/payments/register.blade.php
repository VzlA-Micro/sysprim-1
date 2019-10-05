@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Empresa</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Historial de Pagos</a>
                <a href="" class="breadcrumb">Conciliar Pago</a>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="{{route('savePaymentsTaxes')}}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Conciliar Pago</h5>
                    </div>
                    <div class="card-content row">
                        <input type="hidden" name="taxes" value="1">
                        <div class="input-field col s12 m6">
                            <select name="type" id="type">
                                <option value="" disabled selected>Eligi una opcion</option>
                                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                <option value="PAGO MOVIL">PAGO MOVIL</option>
                                <option value="3">Option 3</option>
                            </select>
                            <label for="type">Forma de Pago</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <select name="bank" id="bank">
                                <option value="" disabled selected>Choose your option</option>
                                <option value="1">VENEZUELA</option>
                                <option value="2">PRONVICIAL</option>
                                <option value="3">Option 3</option>
                            </select>
                            <label for="bank">Banco</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="code_ref" id="code_ref" required>
                            <label for="code_ref">N° de Referencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="amount" id="amount" required>
                            <label for="amount">Monto</label>
                        </div>
                        {{-- <div class="input-field col s12">
                            <select name="status" id="status">
                                <option value="" disabled selected>Choose your option</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                            </select>
                            <label for="status">Estado</label>
                        </div> --}}
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn waves-effect waves-light blue">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection