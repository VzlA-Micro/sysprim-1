@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/stepper.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mis Empresas</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Title</h5>
                    </div>
                    <div class="card-content">
                        <ol class="stepper">
                            <li class="task task--current">
                                <strong style="margin-left: .5rem">Datos Bancarios.</strong>
                                <div class="task-content-wrapper">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col s12">
                                                <h5>Banco de Venezuela:</h5>
                                                <ul>
                                                    <li><b>Número de Cuenta:</b></li>
                                                    <li><b>Documento: </b></li>
                                                    <li><b>Beneficiario: </b></li>
                                                    <li><b>Teléfono: </b></li>
                                                    <li><b>E-mail: </b></li>
                                                </ul>
                                            </div>
                                            <div class="col s12">
                                                <h5>Banco de Venezuela:</h5>
                                                <ul>
                                                    <li><b>Número de Cuenta:</b></li>
                                                    <li><b>Documento: </b></li>
                                                    <li><b>Beneficiario: </b></li>
                                                    <li><b>Teléfono: </b></li>
                                                    <li><b>E-mail: </b></li>
                                                </ul>
                                            </div>
                                            <div class="col s12">
                                                <h5>BOD (Banco Occidental de Descuento):</h5>
                                                <ul>
                                                    <li><b>Número de Cuenta:</b></li>
                                                    <li><b>Documento: </b></li>
                                                    <li><b>Beneficiario: </b></li>
                                                    <li><b>Teléfono: </b></li>
                                                    <li><b>E-mail: </b></li>
                                                </ul>
                                            </div>
                                            <div class="col s12">
                                                <h5>Banco Bicentenario:</h5>
                                                <ul>
                                                    <li><b>Número de Cuenta:</b></li>
                                                    <li><b>Documento: </b></li>
                                                    <li><b>Beneficiario: </b></li>
                                                    <li><b>Teléfono: </b></li>
                                                    <li><b>E-mail: </b></li>
                                                </ul>
                                            </div>
                                            <div class="col s12">
                                                <h5>Banesco:</h5>
                                                <ul>
                                                    <li><b>Número de Cuenta:</b></li>
                                                    <li><b>Documento: </b></li>
                                                    <li><b>Beneficiario: </b></li>
                                                    <li><b>Teléfono: </b></li>
                                                    <li><b>E-mail: </b></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="task task--current">
                                <strong style="margin-left: .5rem">Selecciona el banco de tu preferencia.</strong>
                                <div class="task-content-wrapper">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col s12">
                                                <span>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam id veritatis, 
                                                    aspernatur ullam hic iusto laborum expedita quod laboriosam sint.
                                                </span><br>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col s12 m3 center-align">
                                                <a href="" class="btn btn-large red darken-2 dropdown-trigger col s12" data-target="bdv">BDVenezuela</a>
                                                {{-- Dropdown content --}}
                                                <ul class="dropdown-content" id="bdv">
                                                    <li><a href="https://bdvenlinea.banvenez.com/login" target="_blank">BDVenLinea Personas</a></li>
                                                    <li><a href="https://bdvenlineaempresas.banvenez.com" target="_blank">BDVenLinea Empresas</a></li>
                                                </ul>
                                            </div>
                                            <div class="col s12 m3 center-align">
                                                <a href="" class="btn btn-large dropdown-trigger col s12" style="background-color: #007953" data-target="banesco">Banesco</a>
                                                {{-- Dropdown content --}}
                                                <ul class="dropdown-content" id="banesco">
                                                    <li><a href="https://www.banesconline.com/mantis/Website/Login.aspx" target="_blank">BanescOnline</a></li>
                                                    {{-- <li><a href="https://bdvenlineaempresas.banvenez.com" target="_blank">Empresas</a></li> --}}
                                                </ul>
                                            </div>
                                            <div class="col s12 m3 center-align">
                                                <a href="" class="btn btn-large dropdown-trigger col s12" data-target="bod" style="background-color:#6AAF42">BOD</a>
                                                {{-- Dropdown content --}}
                                                <ul class="dropdown-content" id="bod">
                                                    <li><a href="https://web.bancadigitalbod.com/nblee6/f/ext/Login/index.xhtml" target="_blank">BanescOnline</a></li>
                                                    {{-- <li><a href="https://bdvenlineaempresas.banvenez.com" target="_blank">Empresas</a></li> --}}
                                                </ul>
                                            </div>
                                            <div class="col s12 m3 center-align">
                                                <a href="" class="btn btn-large red dropdown-trigger col s12" data-target="bicentenario">Bicentenario</a>
                                                {{-- Dropdown content --}}
                                                <ul class="dropdown-content" id="bicentenario">
                                                    <li><a href="https://bancaenlinea.bicentenariobu.com/#/LOGINMODI" target="_blank">Personas</a></li>
                                                    <li><a href="https://bancaenlineabbu.bicentenariobu.com/IB1/IpnetBicentenario/" target="_blank">Empresas</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="task task--current">
                                <strong>Realiza el pago.</strong>
                                <div class="task-content-wrapper">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col s12">
                                                <span>
                                                    Una vez realizado el pago con el monto exacto de {{$monto."Bs"}} , guarda el número de referencia y registralo en nuestra plataforma para ser verificado. <br>
                                                    Recuerda que la verificacion puede tardar máximo 48 horas. Una vez verificado el pago, se le enviara un correo electrónico con los datos de la solvecia.
                                                </span>
                                                <form action="{{route('savePaymentsTaxes')}}" method="post">
                                                    <div class="center-align">
                                                        <h5>Conciliar Pago</h5>
                                                    </div>
                                                    <div class="row">
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
                                                            <input type="number" name="amount" id="amount" value="{{$monto}}" readonly pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" required>
                                                            <label for="amount">Monto</label>
                                                        </div>
                                                        <input id="taxes" type="hidden" name="taxes" required value="{{$taxes->id}}">
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
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/mstepper.min.js') }}"></script>
    <script>

    </script>
@endsection