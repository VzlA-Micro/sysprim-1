@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Inmueble</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Pagar Impuestos</a>
                <a href="" class="breadcrumb">Detalles de Pago</a>
            </div>
            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Resumen de Autoliquidación</h5>
                    </div>
                    <div class="row padding-2 left-align">
                        <div class="col m6">
                            <ul>
                                <li><b>Periodo Fiscal: {{$period}} </b></li>
                                <li><b>Fecha: {{$taxes[0]->created_at}} </b></li>
                            </ul>
                        </div>
                        <div class="col m6">
                            <ul>
                                <li><b>Codigo Catastral: </b>{{ $property[0]->code_cadastral }}</li>
                                <li><b>Direccion: </b>{{ $property[0]->address }}</li>
                                <li><b></b></li>
                            </ul>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="card-header center-align">
                        <h5>Detalles de pago de inmueble</h5>
                    </div>
                    <form method="post" action="" id='register-taxes' class="card-content row">
                        @csrf

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="base[]" id="base" class="validate money" value="{{$declaration['totalGround']}}" readonly>
                            <label for="base">Total Terreno</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="base[]" id="base" class="validate money" value="{{$declaration['totalBuild']}}" readonly>
                            <label for="base">Total Construcción</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="deductions[]" id="deductions" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                            <label for="deductions">Deducciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="withholding[]" id="withholdings" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                            <label for="withholdings">Retenciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                            <label for="fiscal_credits">Creditos Fiscales</label>
                        </div>

                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="tasa[]" id="tasa" class="validate recargo money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                            <label for="tasa">Recargo (12%)<b> (Bs)</b></label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="interest[]" id="interest" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="" readonly>
                            <label for="interest">Interes por mora<b> (Bs)</b></label>
                        </div>
                        <div class="input-field col s12">
                            <div class="divider"></div>
                        </div>

                        <div class="col l12 s12">
                            <div class="col l6 s12">
                                <table class="centered responsive-table" style="font-size: 10px;!important;">
                                    <tr>
                                        <th>CODIGO</th>
                                        <th>NOMBRE</th>
                                        <th>ALICUOTA</th>
                                        <th>MININIMO TRIBUTABLE</th>
                                    </tr>

                                </table>
                                <p><b>RECARGO: </b></p>
                            </div>
                            <div class="col l6 s12">
                                <div class="col s12 m12 ">
                                    <input type="text" name="interest"  class="validate money" value="0"  readonly>
                                    <label for="interest">Interes por Mora:(Bs)</label>
                                </div>
                                <div class="col s12 m12 ">
                                    <input type="text" name="recargo" class="validate money" value="0"  readonly>
                                    <label for="recargo">Recargo  Interes:(Bs)</label>
                                </div>
                                <div class="col s12 m12">
                                    <input type="text" name="total" class="validate total money"  value="{{$declaration ['declaration']}}" readonly>
                                    <label for="total_pagar">Total a Pagar:(Bs)</label>
                                </div>
                                <input type="hidden" id="bank" name="bank" value="0">
                                <input type="hidden" id="payments" name="payments" value="1">
                                <input type="hidden" name="taxes_id"  value="" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                {{-- Modal trigger --}}

                                <a href=""  class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger">
                                    Calcular de nuevo
                                    <i class="icon-refresh right"></i>
                                </a>
                                    <a href="{{-- {{ route('payments.help',['id'=>$taxes->id]) }} --}}#modal1"  class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger ">
                                    Continuar
                                    <i class="icon-more_horiz right"></i>
                                </a>






                                {{-- Modal structure --}}

                                <div id="modal1" class="modal modal-fixed-footer">
                                    <div class="modal-content">
                                        <h4 class="center-align">Formas de pago</h4>
                                        <div class="row">
                                            <div class="col s12 center-align">
                                                <p>Por favor, elija la forma en como desea pagar su actividad .</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s12 m4 center-align">
                                                <img src="{{ asset('images/png/001-point-of-service.png') }}" class="responsive-img circle">
                                                <a href="#" data-target='ppv' class="btn btn-large yellow darken-4 waves-effect waves-light tick payments" data-payments="PPV">
                                                    Taquilla
                                                    <i class="icon-payment right"></i>
                                                </a>
                                            </div>
                                            <div class="col s12 m4 center-align">
                                                <div class="img"></div>
                                                <img src="{{ asset('images/png/009-smartphone-1.png') }}" class="responsive-img circle">
                                                <a href="#"   data-target='ptb' class="btn btn-large blue waves-effect waves-light  dropdown-trigger payments" data-payments="PTB">
                                                    Transferencia
                                                    <i class="icon-compare_arrows right"></i>
                                                </a>
                                                <ul id='ptb' class='dropdown-content'>
                                                    <li><a href="#!" data-bank="55" class="bank">Banesco</a></li>
                                                    <li><a href="#!" data-bank="33" class="bank">100% Banco</a></li>
                                                    <li><a href="#!" data-bank="99" class="bank">BNC</a></li>
                                                </ul>
                                            </div>
                                            <div class="col s12 m4 center-align">
                                                <img src="{{ asset('images/png/030-bank.png') }}" class="responsive-img circle">
                                                <a href="#"  data-target='ppb' class="btn btn-large red waves-effect waves-light dropdown-trigger payments" data-payments="PPB" >
                                                    Deposito
                                                    <i class="icon-account_balance right"></i>
                                                </a>
                                                {{-- Dropdown trigger --}}
                                                <ul id='ppb' class='dropdown-content'>
                                                    <li><a href="#!" data-bank="77" class="bank">Banco Bicentenario</a></li>
                                                    <li><a href="#!" data-bank="55" class="bank">Banesco</a></li>
                                                    <li><a href="#!" data-bank="44"  class="bank">BOD</a></li>
                                                    <li><a href="#!" data-bank="33" class="bank">100% Banco</a></li>
                                                    <li><a href="#!" data-bank="99" class="bank">BNC</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="{{ asset('js/validations.js') }}"></script>
@endsection