@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mis Empresas</a>
                <a href="{{ route('companies.details', ['id' => $company->id]) }}" class="breadcrumb">{{ session('company') }}</a>
                <a href="{{ route('companies.my-payments', ['company' => $company->name]) }}" class="breadcrumb">Mis Declaraciones</a>
                <a href="{{ route('payments.history',['company'=>session('company')]) }}" class="breadcrumb">Historial de Pagos</a>
                <a href="#!" class="breadcrumb">Conciliar Pago</a>
            </div>
            <div class="col s12 m8 offset-m2">
                <form id="payments" enctype="multipart/form-data" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Conciliar Pago</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <i class="icon-payment prefix"></i>                                                        
                            <select name="type" id="type" required>
                                <option value="" disabled selected>Elije una opción...</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Pago Movil">Pago Movil</option>
                                <option value="Deposito">Deposito</option>
                            </select>
                            <label for="type">Forma de Pago</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-account_balance prefix"></i>                                                        
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
                            <i class="icon-confirmation_number prefix"></i>                                                        
                            <input type="text" name="code_ref" id="code_ref" pattern="[0-9]+" title="Solo puede escribir números." required>
                            <label for="code_ref">N° de Referencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>                                                      
                            <input type="number" name="amount" id="amount" value="{{$monto}}" readonly pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" required>
                            <label for="amount">Monto</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-person prefix"></i>                                                                                    
                            <input type="text" name="name" id="name" pattern="[a-zA-Z]+" title="Solo puede escribir letras." required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-preson prefix"></i>                                                        
                            <input type="text" name="surname" id="surname" pattern="[a-zA-Z]+" title="Solo puede escribir números." required>
                            <label for="surname">Apellido</label>
                        </div>
                        <div class="input-field col s2 m3 tooltipped" data-position="bottom" data-tooltip="V: Venezolano; E: Extrangero">
                            <i class="icon-public prefix"></i>                                                        
                            <select name="nationality" id="nationality" required>
                                <option value="null">...</option>
                                <option value="V-">V</option>
                                <option value="E-">E</option>
                            </select>
                            <label for="nationality">Nacionalidad</label>
                        </div>
                        <div class="input-field col s10 m3">
                            <input type="text" name="cedula" id="cedula" pattern="[0-9]+" title="Solo puede escribir números." required>
                            <label for="cedula">Cedula</label>
                        </div>
                        <div class="file-field input-field col s12 m6">
                            <div class="btn purple btn-rounded waves-light">
                                <span><i class="icon-file_upload right"></i>Archivo</span>
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
    <script src="{{ asset('js/dev/payments.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection