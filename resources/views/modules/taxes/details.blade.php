@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mi Empresa</a>
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
                                <li><b>Código: </b>{{ $taxes->code }}</li>
                                <li><b>Periodo Fiscal: </b>{{ $fiscal_period }}</li>
                                <li><b>Fecha: </b>{{ $taxes->created_at }}</li>

                            </ul>
                        </div>
                        <div class="col m6">
                            <ul>
                                <li><b>Nombre: </b>{{ $taxes->companies->name }}</li>
                                <li><b>RIF: </b>{{ $taxes->companies->RIF }}</li>
                                <li><b>Licencia: </b>{{ $taxes->companies->license }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="card-header center-align">
                        <h5>Detalles de Actividad Económica</h5>
                    </div>
                    <form method="post" action="{{ route('payments.help') }}" id='register-taxes' class="card-content row">
                        @csrf
                        @foreach($ciuTaxes as $ciu)
                        <div class="input-field col s12 m6">
                            <input type="text" name="code" id="code" class="code" value="{{ $ciu->ciu->code }}" required readonly>
                            <label for="code">Código</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="ciu" id="ciu" value="{{ $ciu->ciu->name }}" required readonly>
                            <label for="ciu">CIU</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <input type="text" name="base[]" id="base" class="validate money" value="{{ $ciu->base }}" readonly>
                            <label for="base">Base Imponible</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="deductions[]" id="deductions" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->deductions }}" readonly>
                            <label for="deductions">Deducciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="withholding[]" id="withholdings" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->withholding }}" readonly>
                            <label for="withholdings">Retenciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->fiscal_credits }}" readonly>
                            <label for="fiscal_credits">Creditos Fiscales</label>
                        </div>

                            @if($taxes->companies->typeCompany=='R')
                                <div class="input-field col s12 m4">
                                        <input type="text" name="total_ciu[]" id="total_ciu" class="validate total_ciu money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->totalCiiu+$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits}}" readonly>
                                        <label for="fiscal_credits">Monto a Pagar por CIU<b> (Bs)</b></label>
                                </div>
                            @else
                                <div class="input-field col s12 m4">
                                    <input type="text" name="total_ciu[]" id="total_ciu" class="validate total_ciu money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->totalCiiu-$ciu->deductions-$ciu->withholding-$ciu->fiscal_credits}}" readonly>
                                    <label for="fiscal_credits">Monto a Pagar por CIU<b> (Bs)</b></label>
                                </div>
                            @endif
                            <div class="input-field col s12 m4">
                                <input type="text" name="tasa[]" id="tasa" class="validate recargo money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{$ciu->tax_rate}}" readonly>
                                <label for="tasa">Recargo (12%)<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m4">
                                <input type="text" name="interest[]" id="interest" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{$ciu->interest}}" readonly>
                                <label for="interest">Interes por mora<b> (Bs)</b></label>
                            </div>

                        <div class="input-field col s12">
                            <div class="divider"></div>
                        </div>

                        @endforeach
                        <div class="col l12 s12">
                            <div class="col l6 s12">
                                    <table class="centered responsive-table" style="font-size: 10px;!important;">
                                        <tr>
                                            <td>CODIGO</td>
                                            <td>NOMBRE</td>
                                            <td>ALICUOTA</td>
                                            <td>MININIMO TRIBUTABLE</td>
                                        </tr>
                                        @php $unid=$ciu->unid_tribu;@endphp
                                        @foreach($taxes->taxesCiu as $ciu)
                                        <tr>
                                            <td>{{$ciu->code}}</td>
                                            <td>{{$ciu->name}}</td>
                                            <td>{{$ciu->alicuota."%"}}</td>
                                            <td>{{$ciu->min_tribu_men}}</td>
                                        </tr>

                                @endforeach
                                    </table>
                                    <p><b>RECARGO: </b>{{$extra['tasa']."%"}}</p>

                            </div>
                            <div class="col l6 s12">

                                <div class="col s12 m12 ">
                                    <input type="text" name="interest"  class="validate money" value="{{$amount['amountInterest']}}"  readonly>
                                    <label for="interest">Interes por Mora:(Bs)</label>
                                </div>

                                <div class="col s12 m12 ">
                                    <input type="text" name="recargo" class="validate money" value="{{$amount['amountRecargo']}}"  readonly>
                                    <label for="recargo">Recargo  Interes:(Bs)</label>
                                </div>

                                <div class="col s12 m12">
                                    <input type="text" name="desc" class="validate total money"  value="{{$amount['amountDesc']}}" readonly>
                                    <label for="desc">Descuento:(Bs)</label>
                                </div>

                                <div class="col s12 m12">
                                    <input type="text" name="total" class="validate total money"  value="{{$amount['amountTotal']}}" readonly>
                                    <label for="total_pagar">Total a Pagar:(Bs)</label>
                                </div>
                                <input type="hidden" id="bank" name="bank" value="0">
                                <input type="hidden" id="payments" name="payments" value="1">
                                <input type="hidden" name="taxes_id"  value="{{$taxes->id}}" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                {{-- Modal trigger --}}
                                @if($taxes->status!='process')
                                <a href="{{-- {{ route('payments.help',['id'=>$taxes->id]) }} --}}#modal1"  class="btn btn-rounded col s12 blue waves-effect waves-light modal-trigger">CONTINUAR</a>
                                {{-- Modal structure --}}
                               @endif

                                <div id="modal1" class="modal modal-fixed-footer">
                                    <div class="modal-content">
                                        <h4 class="center-align">Formas de pago</h4>
                                        <div class="row">
                                            <div class="col s12">
                                                <p>Por favor, elija la forma en como desea pagar su actividad .</p>
                                            </div>
                                        </div>
                                        <div class="col s12 m4 center-align">
                                            <div class="col s12 m12">
                                                <img src="{{asset('images/taquilla.png')}}" class="responsive-img circle">
                                            </div>
                                            <a href="#" data-target='ppv' class="btn btn-large yellow darken-4 waves-effect waves-light   tick" data-payments="PPV">Taquilla</a>
                                        </div>
                                        <div class="col s12 m4 center-align">
                                            <div class="col s12 m12">
                                                <img src="{{asset('images/transferencia.png')}}" class="responsive-img circle">
                                            </div>
                                            <a href="#"   data-target='ptb' class="btn btn-large blue waves-effect waves-light  dropdown-trigger payments" data-payments="PTB">Transferencia</a>
                                            <ul id='ptb' class='dropdown-content'>
                                                <li><a href="#!" data-bank="55" class="bank">Banesco</a></li>
                                                <li><a href="#!" data-bank="33" class="bank">100% Banco</a></li>
                                                <li><a href="#!" data-bank="99" class="bank">BNC</a></li>
                                            </ul>
                                        </div>


                                        <div class="col s12 m4 center-align">
                                            <div class="col s12 m12">
                                                <img src="{{asset('images/deposito.png')}}" class="responsive-img circle">
                                            </div>
                                            {{-- Dropdown trigger --}}
                                            <a href="#"  data-target='ppb' class="btn btn-large red waves-effect waves-light dropdown-trigger payments" data-payments="PPB" >Deposito</a>
                                        </div>
                                        <!-- Dropdown Structure -->
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
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/dev/taxes.js') }}"></script>
@endsection
@php /*
                    <form id="payments" enctype="multipart/form-data" method="post">
                        <div class="card-header center-align">
                            <h5>DETALLES DE PAGOS</h5>
                        </div>
                        <div class="card-content row">
                            @csrf
                            <div class="input-field col s12 m6">
                                <select name="type" id="type" required readonly="">
                                    <option value="" disabled selected readonly>Elije una opción...</option>
                                    <option value="Transferencia" @if($taxes->payments[0]->payments_type=="Transferencia"){{"selected"}}@endif>Transferencia</option>
                                    <option value="Pago Movil" @if($taxes->payments[0]->payments_type=="Pago Movil"){{"selected"}}@endif >Pago Movil</option>
                                    <option value="Deposito" @if($taxes->payments[0]->payments_type=="Deposito"){{"selected"}} @endif>Deposito</option>
                                </select>
                                <label for="type">Forma de Pago</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <select name="bank" id="bank" required readonly>
                                    <option value="" disabled selected>Elije una opción...</option>
                                    <option value="Venezuela" @if($taxes->payments[0]->bank=="Venezuela"){{"selected"}}@endif>Venezuela</option>
                                    <option value="Bicentenario" @if($taxes->payments[0]->bank=="Bicentenario"){{"selected"}}@endif>Bicentenario</option>
                                    <option value="Mercantil" @if($taxes->payments[0]->bank=="Mercantil"){{"selected"}}@endif>Mercantil</option>
                                    <option value="Banesco"  @if($taxes->payments[0]->bank=="Banesco"){{"selected"}}@endif>Banesco</option>
                                    <option value="BOD" @if($taxes->payments[0]->bank=="BOD"){{"selected"}}@endif>BOD</option>
                                </select>
                                <label for="bank">Banco</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" name="code_ref" id="code_ref" value="{{$taxes->payments[0]->code_ref}}" pattern="[0-9]+" title="Solo puede escribir números."  readonly required>
                                <label for="code_ref" >N° de Referencia</label>
                            </div>
                            <div class="input-field col s12 m6">
                                    <input type="number" name="amount" id="amount" value="{{$taxes->payments[0]->amount}}" readonly pattern="^[0-9]{0,12}([.][0-9]{2,2})?$"  required>
                                <label for="amount">Monto</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <input type="text" name="name" id="name" pattern="[a-zA-Z]+" title="Solo puede escribir letras." value="{{$taxes->payments[0]->name_deposito}}" readonly required>
                                <label for="name">Nombre</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" name="surname" id="surname" pattern="[a-zA-Z]+" title="Solo puede escribir números."  value="{{$taxes->payments[0]->surname_deposito}}" readonly required>
                                <label for="surname">Apellido</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" name="cedula" id="cedula" pattern="[0-9]+" title="Solo puede escribir números." readonly  value="{{$taxes->payments[0]->cedula}}" required>
                                <label for="cedula">Cedula</label>
                            </div>

                          <div class="input-field col s12 m6">
                                <select name="status" id="status">
                                    <option value="null" disabled selected>Selecionar opcion</option>
                                    <option value="verified" @if($taxes->payments[0]->status=="verified"){{"selected"}}@endif >Verificada</option>
                                    <option value="process"  @if($taxes->payments[0]->status=="process"){{"selected"}}@endif  >Procesando</option>
                                    <option value="cancel" @if($taxes->payments[0]->status=="cancel"){{"selected"}}@endif>Anulada</option>
                                </select>
                                <label for="status">Estado</label>
                            </div>
                        </div>


                    </form>

                    @endif

                    <div class="card-action">

                        @if(!$taxes->payments->isEmpty())
                            <div class="row">
                                <div class="input-field col s12">
                                    <a href="{{ route('home')}}" class="btn btn-rounded col s12 blue waves-effect waves-light">VOLVER</a>
                                </div>
                            </div>
                        @else
<<<<<<< HEAD

=======
                            <div class="row">
                                <div class="input-field col s12">
                                    {{-- Modal trigger --}}
                                    <a href="{{-- {{ route('payments.help',['id'=>$taxes->id]) }} --}}#modal1"  class="btn btn-rounded col s12 blue waves-effect waves-light modal-trigger">CONTINUAR</a>
                                    {{-- Modal structure --}}
                                    <div id="modal1" class="modal modal-fixed-footer">
                                        <div class="modal-content">
                                            <h4 class="center-align">Formas de pago</h4>
                                            <div class="row">
                                                <div class="col s12">
                                                    <p>Por favor, elija la forma en como desea pagar sus impuestos.</p>
                                                </div>
                                            </div>
                                            <div class="col s12 m4 center-align">
                                                <a href="" class="btn btn-large yellow waves-effect waves-light">Taquilla</a>
                                            </div>
                                            <div class="col s12 m4 center-align">
                                                <a href="" class="btn btn-large blue waves-effect waves-light">Transferencia</a>
                                            </div>
                                            <div class="col s12 m4 center-align">
                                                {{-- Dropdown trigger --}}
                                                <a href=""  data-target='deposito' class="btn btn-large red waves-effect waves-light dropdown-trigger">Deposito</a>
                                            </div>
                                            <!-- Dropdown Structure -->
                                            <ul id='deposito' class='dropdown-content'>
                                                <li><a href="#!">Banco Bicentenario</a></li>
                                                <li><a href="#!">Banesco</a></li>
                                                <li><a href="#!">BOD</a></li>
                                                <li><a href="#!">100% Banco</a></li>
                                                <li><a href="#!">BNC</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
>>>>>>> semat
                        @endif
                    </div>
                    */
@endphp


