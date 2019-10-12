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
                <form action="{{route('savePaymentsTaxes')}}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Conciliar Pago</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <select name="type" id="type" required>
                                <option value="" disabled selected>Elije una opción...</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Pago Movil">Pago Movil</option>
                                <option value="Deposito">Deposito</option>
                            </select>
                            <label for="type">Forma de Pago</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <select name="bank" id="bank" required>
                                <option value="" disabled selected>Elije una opción...</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Bicentenario">Bicentenario</option>
                                <option value="Mercantil">Mercantil</option>
                                <option value="Banesco">Banesco</option>
                                <option value="BOD">BOD</option>
                            </select>
                            <label for="bank">Banco</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="code_ref" id="code_ref" pattern="[0-9]+" title="Solo puede escribir números." required>
                            <label for="code_ref">N° de Referencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="number" name="amount" id="amount" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" required>
                            <label for="amount">Monto</label>
                        </div>
                        <input id="taxes" type="hidden" name="taxes" required value="{{ $id }}">
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
                        <button type="submit" class="btn btn-rounded waves-effect waves-light blue">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection