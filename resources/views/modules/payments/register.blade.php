@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mis Empresas</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Historial de Pagos</a>
                <a href="" class="breadcrumb">Conciliar Pago</a>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="{{route('savePaymentsTaxes')}}" enctype="multipart/form-data" method="post" class="card">
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
                            @foreach($taxes->taxesCiu as $ciu)
                            
                            <input type="number" name="amount" id="amount" value="{{$monto+$monto}}" readonly pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" required>
                            @endforeach
                            <label for="amount">Monto</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <input type="text" name="name" id="name" pattern="[a-zA-Z]+" title="Solo puede escribir letras." required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="surname" id="surname" pattern="[a-zA-Z]+" title="Solo puede escribir números." required>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="cedula" id="cedula" pattern="[0-9]+" title="Solo puede escribir números." required>
                            <label for="cedula">Cedula</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="date_transference" id="date_transference" class="datepicker" required>
                            <label for="date_transference">Fecha de Transacción</label>
                        </div>
                        <div class="file-field input-field col s12 12">
                            <div class="btn purple btn-rounded waves-light">
                                <span><i class="icon-photo_size_select_actual right"></i>Archivo</span>
                                <input type="file" id="files" name="files">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" title="Solo puede subir archivos de tipo (.jpg,.png y .pdf)">
                            </div>
                        </div>
                        <input id="taxes" type="hidden" name="taxes" required value="{{$id}}">
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