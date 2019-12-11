@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                    <li class="breadcrumb-item"><a href="">{{ session('company') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.my-payments', ['company' => session('company')]) }}">Mis Declaraciones</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.create',['company'=>session('company')]) }}">Pagar Impuestos</a></li>
                    <li class="breadcrumb-item"><a href="#!">Detalles de Autoliquidación</a></li>
                </ul>
            </div>

            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Resumen de Autoliquidación</h5>
                        <h5> Periodo Fiscal:<span> {{ $fiscal_period }}</span></h5>
                    </div>
                    <div class="row padding-2 left-align">
                        <div class="col m6">
                            <ul>
                                <li><b>Nombre: </b>{{ $taxes->companies[0]->name }}</li>
                                <li><b>RIF: </b>{{ $taxes->companies[0]->RIF }}</li>
                                <li><b>Licencia: </b>{{ $taxes->companies[0]->license }}</li>
                                <li><b>Fecha: </b>{{ $taxes->created_at->format('d-m-Y') }}</li>
                            </ul>
                            <ul>


                            </ul>
                        </div>
                        <div class="col m6">

                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="card-header center-align">
                        <h5>Detalles de Actividad Económica</h5>
                    </div>
                    <form method="post" action="{{ route('company.taxes.save')}}" id='register-taxes' class="card-content row">
                        @csrf
                        @foreach($ciuTaxes as $ciu)
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input type="text" name="code" id="code" class="code" value="{{ $ciu->ciu->code }}" required readonly>
                            <label for="code">Código</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-assignment prefix"></i>
                            <input type="text" name="ciu" id="ciu" value="{{ $ciu->ciu->name }}" required readonly>
                            <label for="ciu">CIU</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="base[]" id="base" class="validate money" value="{{ $ciu->base }}" readonly>
                            <label for="base">Base Imponible</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   

                            <input type="text" name="deductions[]" id="deductions" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->deductions }}" readonly>
                            <label for="deductions">Deducciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="withholding[]" id="withholdings" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->withholding }}" readonly>
                            <label for="withholdings">Retenciones</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->fiscal_credits }}" readonly>
                            <label for="fiscal_credits">Creditos Fiscales</label>
                        </div>

                        @if($taxes->companies[0]->typeCompany=='R')
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="total_ciu[]" id="total_ciu" class="validate total_ciu money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->totalCiiu+$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits}}" readonly>
                            <label for="fiscal_credits">Monto a Pagar por CIU<b> (Bs)</b></label>
                        </div>
                        @else
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="total_ciu[]" id="total_ciu" class="validate total_ciu money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->totalCiiu-$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits}}" readonly>
                            <label for="fiscal_credits">Monto a Pagar por CIU<b> (Bs)</b></label>
                        </div>
                        @endif
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="tasa[]" id="tasa" class="validate recargo money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{$ciu->tax_rate}}" readonly>
                            <label for="tasa">Recargo (12%)<b> (Bs)</b></label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
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
                                    <thead>
                                        <tr>
                                            <th>CODIGO</th>
                                            <th>NOMBRE</th>
                                            <th>ALICUOTA</th>
                                            <th>MININIMO TRIBUTABLE</th>
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        @php $unid=$ciu->unid_tribu;@endphp
                                        @foreach($taxes->taxesCiu as $ciu)
                                        <tr class="centered">
                                            <td>{{$ciu->code}}</td>
                                            <td>{{$ciu->name}}</td>
                                            <td>{{($ciu->alicuota*100)."%"}}</td>
                                            <td>{{$ciu->min_tribu_men}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col s12">
                                <p><b>RECARGO: </b>{{$extra['tasa']."%"}}</p>
                                    
                                </div>
                            </div>
                            <div class="col l6 s12">
                                <div class="col s12 m12 ">
                                    <input type="text" name="interest"  class="validate money" id='interest' value="{{$amount['amountInterest']}}"  readonly>
                                    <label for="interest">Interes por Mora:(Bs)</label>
                                </div>
                                <div class="col s12 m12 ">
                                    <input type="text" name="recargo" class="validate money" value="{{$amount['amountRecargo']}}"  readonly>
                                    <label for="recargo">Recargo  Interes:(Bs)</label>
                                </div>
                                <div class="col s12 m12">
                                    <input type="text" name="total" class="validate total money"  value="{{$amount['amountTotal']}}" readonly>
                                    <label for="total_pagar">Total a Pagar:(Bs)</label>
                                </div>
                                <input type="hidden" id="bank" name="bank" value="0">
                                <input type="hidden" id="payments" name="payments" value="1">
                                <input type="hidden" name="taxes_id"  value="{{$taxes->id}}" id="taxes_id">
                            </div>
                        </div>
                        <div class="row" style="padding: 1rem">
                            <div class="input-field col s12">
                                {{-- Modal trigger --}}

                                @if($taxes->status!='verified'&&\Auth::user()->id===$taxes->companies[0]->users[0]->id)
                                <a href="{{ route('taxes.calculate',['id'=>$taxes->id]) }}"  class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger">
                                    Calcular de nuevo
                                    <i class="icon-refresh right"></i></a>

                                   <!-- <a href="#" id="download-calculate"  class="btn btn-rounded col s4 peach waves-effect waves-light modal-trigger">
                                        Descargar Calculo.
                                        <i class="icon-cloud_download right"></i>
                                    </a>-->

                                    <button  type="submit" class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger" id="continue">
                                    Continuar
                                    <i class="icon-more_horiz right"></i>
                                </button>
                                {{-- Modal structure --}}



                                @endif
                                @if(\Auth::user()->role_id===1)



                                    @if(!$taxes->payments->isEmpty())
                                    <div class="row">

                                            @if($taxes->status==='process')

                                                <button class="btn green col s12">
                                                    <i class="icon-more_horiz left "></i>
                                                    ESTADO:  SIN CONCILIAR AÚN
                                                </button>
                                            @elseif($taxes->status==='verified')

                                                <button class="btn blue col s12">
                                                    <i class="icon-more_horiz left"></i>
                                                    ESTADO:  VERIFICADA.
                                                </button>


                                            @elseif($taxes->status=='cancel')

                                                <button class="btn red col s12">
                                                    <i class="icon-more_horiz left"></i>
                                                    ESTADO: CANCELADA.
                                                </button>
                                            @endif

                                        <div class="input-field col s12">
                                            @if($taxes->status=='process')
                                                <a href="#"  class="btn btn-rounded col s6 red waves-effect waves-ligt reconcile" data-status="cancel">
                                                    ANULAR PLANILLA.
                                                    <i class="icon-close right"></i></a>

                                                <a href="#"  class="btn btn-rounded col s6 blue waves-effect waves-light reconcile" data-status="verified">
                                                    VERIFICAR PLANILLA.
                                                    <i class="icon-verified_user right"></i></a>
                                            @endif
                                        </div>
                                        @endif
                                    </div>

                                @endif



                                <div id="modal1" class="modal modal-fixed-footer">
                                    <div class="modal-content">
                                        <h4 class="center-align">Formas de pago</h4>
                                        <div class="row">
                                            <div class="col s12 m4 center-align">
                                                <h5>Pago por Taquilla SEMAT</h5>
                                                <img src="{{ asset('images/png/001-point-of-service.png') }}" class="responsive-img">
                                                <a href="#" data-target='ppv' class="btn btn-large yellow darken-4 waves-effect waves-light tick payments" data-payments="PPV">
                                                    Taquilla
                                                    <i class="icon-payment right"></i>
                                                </a>
                                            </div>
                                            <div class="col s12 m4 center-align">
                                                <h5>Pago por Transferencia Bancaria</h5>
                                                <img src="{{ asset('images/png/009-smartphone-1.png') }}" class="responsive-img">
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
                                                <h5>Pago por Deposito Bancario</h5>
                                                <img src="{{ asset('images/png/030-bank.png') }}" class="responsive-img">
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
    <script src="{{ asset('js/dev/taxes.js') }}"></script>
    <script src="{{ asset('js/dev/payments.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection