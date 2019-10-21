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
                                                <table class="centered highlight responsive-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Banco</th>
                                                            <th>N°. Cuenta</th>
                                                            <th>Documento</th>
                                                            <th>Beneficiario</th>
                                                            <th>Teléfono</th>
                                                            <th>E-mail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Venezuela</td>
                                                            <td>010200000000000000</td>
                                                            <td>J123456789</td>
                                                            <td>Jhon Doe</td>
                                                            <td>04121111111</td>
                                                            <td>jhondoe@example.com</td>
                                                        </tr>
                                                        <tr>
                                                            <td>BOD</td>
                                                            <td>000000000000000000</td>
                                                            <td>J123456789</td>
                                                            <td>Jhon Doe</td>
                                                            <td>04121122233</td>
                                                            <td>jhondoe@example.com</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
                                                  Puedes seleccionar cualquiera de nuestros bancos, recuerda que para el pago sea validado la transferencia debe realizarse del mismo banco.
                                                </span><br>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col s12 m3 center-align">
                                                <a href="" class="btn btn-large white dropdown-trigger col s12" data-target="bdv">
                                                    <i class="icon-logo">
                                                        <img src="{{ asset('images/bdv_logo.png') }}" style="width: 130px;" alt="" srcset="">
                                                    </i>
                                                </a>
                                                {{-- Dropdown content --}}
                                                <ul class="dropdown-content" id="bdv">
                                                    <li><a href="https://bdvenlinea.banvenez.com/login" target="_blank">BDVenLinea Personas</a></li>
                                                    <li><a href="https://bdvenlineaempresas.banvenez.com" target="_blank">BDVenLinea Empresas</a></li>
                                                </ul>
                                            </div>
                                            <div class="col s12 m3 center-align">
                                                <a href="" class="btn btn-large dropdown-trigger col s12 white" data-target="banesco">
                                                    <i>
                                                        <img src="{{ asset('images/banesco_logo.png') }}" style="width: 60px;" alt="" srcset="">                                                
                                                    </i>
                                                </a>
                                                {{-- Dropdown content --}}
                                                <ul class="dropdown-content" id="banesco">
                                                    <li><a href="https://www.banesconline.com/mantis/Website/Login.aspx" target="_blank">BanescOnline</a></li>
                                                    {{-- <li><a href="https://bdvenlineaempresas.banvenez.com" target="_blank">Empresas</a></li> --}}
                                                </ul>
                                            </div>
                                            <div class="col s12 m3 center-align">
                                                <a href="" class="btn btn-large dropdown-trigger col s12 white" data-target="bod">
                                                    <i>
                                                        <img src="{{ asset('images/bod_logo.png') }}" style="width: 60px;margin-top:5px" alt="" srcset="">                                                
                                                    </i>
                                                </a>
                                                {{-- Dropdown content --}}
                                                <ul class="dropdown-content" id="bod">
                                                    <li><a href="https://web.bancadigitalbod.com/nblee6/f/ext/Login/index.xhtml" target="_blank">BanescOnline</a></li>
                                                    {{-- <li><a href="https://bdvenlineaempresas.banvenez.com" target="_blank">Empresas</a></li> --}}
                                                </ul>
                                            </div>
                                            <div class="col s12 m3 center-align">
                                                <a href="" class="btn btn-large white dropdown-trigger col s12" data-target="bicentenario">
                                                    <i>
                                                        <img src="{{ asset('images/bicentenario_logo.png') }}" style="width: 110px;" alt="" srcset="">                                                
                                                    </i>
                                                </a>
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
                                                    Recuerda que la verificacion puede tardar máximo 48 horas. Una vez verificado el pago, se le enviara un correo electrónico con los datos de la solvencia.
                                                </span>
                                                <form id="payments" enctype="multipart/form-data" method="post">
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
                                                            <input type="text" name="amount" class="money" id="amount" value="{{$monto}}" readonly pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" required>
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
                                                        <div class="input-field col s2 m2 tooltipped" data-position="bottom" data-tooltip="V: Venezolano; E: Extrangero">
                                                            <select name="nationality" id="nationality" required>
                                                                <option value="null">...</option>
                                                                <option value="V-">V</option>
                                                                <option value="E-">E</option>
                                                            </select>
                                                            <label for="nationality">Nacionalidad</label>
                                                        </div>
                                                        <div class="input-field col s12 m4">
                                                            <input type="text" name="cedula" id="cedula" pattern="[0-9]+" title="Solo puede escribir números." required>
                                                            <label for="cedula">Cedula</label>
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
                                                        <input id="taxes" type="hidden" name="taxes" required value="{{$taxes->id}}">

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
    <script src="{{ asset('js/dev/payments.js') }}"></script>
    <script src="{{ asset('js/dev/taxes.js') }}"></script>
@endsection