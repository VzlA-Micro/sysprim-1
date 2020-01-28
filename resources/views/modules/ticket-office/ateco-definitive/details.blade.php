@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.ticket-office') }}">Taquilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.manage') }}">Gestionar Pagos</a></li>
                    <li class="breadcrumb-item"><a href="#" class="prev-view" >Ver Pagos</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Detalles de Planilla</a></li>
                </ul>
            </div>

            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Resumen de Autoliquidación(Definitiva)</h5>

                       <div class="row">

                           <div class="col l6">
                               <h5> Periodo Fiscal de Inicio:<span>{{ \Carbon\Carbon::parse($taxes->fiscal_period)->format('d-m-Y') }}</span></h5>
                           </div>

                           <div class="col l6">
                               <h5> Periodo Fiscal de Fin:<span> {{ \Carbon\Carbon::parse($taxes->fiscal_period_end)->format('d-m-Y') }}</span></h5>
                           </div>

                           <h5> Código:<b> {{$taxes->code}}</b></h5>
                       </div>


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
                            <input type="text" name="code" id="code_{{$ciu->ciu->code}}" class="code" value="{{ $ciu->ciu->code }}" required readonly>
                            <label for="code_{{$ciu->ciu->code}}">Código</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-assignment prefix"></i>
                            <input type="text" name="ciu" id="ciu_{{$ciu->ciu->code}}" value="{{ $ciu->ciu->name }}" required readonly>
                            <label for="ciu_{{$ciu->ciu->code}}">CIU</label>
                        </div>

                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="base[]" id="base_{{$ciu->ciu->code}}" class="validate money" value="{{ $ciu->base }}" readonly>
                            <label for="base_{{$ciu->ciu->code}}">Base Imponible</label>
                        </div>

                            <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="  base_anticipated[]" id="base_anticipated_{{$ciu->ciu->code}}" class="validate money" value="{{ $ciu->base_anticipated }}" readonly>
                                <label for="base_anticipated_{{$ciu->ciu->code}}">Impuesto Anticipado</label>
                            </div>





                            {{--
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
                        @endif
                          --}}
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>


                            <input type="text" name="total_ciu[]" id="total_ciu_{{$ciu->ciu->code}}" class="validate total_ciu money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->totalCiiuDefinitive- $ciu->base_anticipated }}" readonly>

                            <label for="total_ciu _{{$ciu->ciu->code}}">Monto a Pagar por CIU<b> (Bs)</b></label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="tasa[]" id="tasa_{{$ciu->ciu->code}}" class="validate recargo money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{$ciu->recharge}}" readonly>
                            <label for="tasa_{{$ciu->ciu->code}}">Recargo (12%)<b> (Bs)</b></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="interest[]" id="interest_{{$ciu->ciu->code}}" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{$ciu->interest}}" readonly>
                            <label for="interest_{{$ciu->ciu->code}}">Interes por mora<b> (Bs)</b></label>
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
                                    
                                </div>
                            </div>


                            <div class="col l6 s12">
                                <div class="col s12 m12 ">
                                    <input type="text" name="interest"  class="validate money" id='interest' value="{{'0'}}"  readonly>
                                    <label for="interest">Interes por Mora:(Bs)</label>
                                </div>
                                <div class="col s12 m12 ">
                                    <input type="text" name="recargo" class="validate money" value="{{'0'}}"  readonly>
                                    <label for="recargo">Recargo  Interes:(Bs)</label>
                                </div>
                                <div class="col s12 m12">
                                    <input type="text" name="total" class="validate total money"  value="{{$taxes->amount}}" readonly>
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

                                @if($taxes->status!='verified'&&$taxes->status!='verified-sysprim'&&\Auth::user()->id===$taxes->companies[0]->users[0]->id)
                                <a href="{{ route('taxes.again.definitive',['id'=>$taxes->id]) }}"  class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger">
                                    Calcular de nuevo
                                    <i class="icon-refresh right"></i></a>

                                   <!-- <a href="#" id="download-calculate"  class="btn btn-rounded col s4 peach waves-effect waves-light modal-trigger">
                                        Descargar Calculo.
                                        <i class="icon-cloud_download right"></i>
                                    </a>-->

                                    <a href="{{ route('taxes.payment.definitive',['id'=>$taxes->id]) }}"  class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger" id="continue">
                                        Continuar
                                    <i class="icon-more_horiz right"></i>
                                </a>
                                {{-- Modal structure --}}



                                @endif
                                @if(!$taxes->payments->isEmpty())
                                    <h4 class="center-align">Registro de Pago:</h4>
                                    <table class="centered highlight" id="payments" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Código</th>
                                            <th>Forma de Pago</th>
                                            <th>Status</th>
                                            <th>Ref o Código</th>
                                            <th>Monto</th>
                                            <th>Acción</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($taxes->payments as $taxe)
                                            <tr>
                                                <td>{{$taxe->created_at->format('d-m-Y')}}</td>
                                                <td>{{$taxe->code}}</td>
                                                <td>{{$taxe->type_payment}}</td>
                                                <td>{{$taxe->statusName}}</td>
                                                <td>{{$taxe->ref}}</td>
                                                <td>{{number_format($taxe->amount,2)." Bs"}}</td>
                                                <td>
                                                    @if($taxe->status==='cancel')
                                                        <div class="input-field col s12 m12">
                                                            <button type="button"
                                                                    class="btn waves-effect waves-light  col s12 red"
                                                                    value="">
                                                                <i class="icon-do_not_disturb_alt"></i></button>
                                                        </div>
                                                    @elseif($taxe->status=='verified'&&$taxe->status=='verified-sysprim')
                                                        <div class="input-field col s12 m12">
                                                            <button type="button"
                                                                    class="btn waves-effect waves-light green col s12"
                                                                    value="#" data-status="#">
                                                                <i class="icon-check"></i></button>
                                                        </div>
                                                    @else
                                                        <div class="input-field col s12 m6">
                                                            <button type="button"
                                                                    class="change-status btn waves-effect waves-light green col s12"
                                                                    value="{{$taxe->id}}" data-status="verified">
                                                                <i class="icon-check"></i></button>
                                                        </div>
                                                        <div class="input-field col s12 m6">
                                                            <button type="button"
                                                                    class="change-status btn waves-effect waves-light red col s12"
                                                                    value="{{$taxe->id}}" data-status="cancel">
                                                                <i class="icon-cancel"></i></button>
                                                        </div>
                                                    @endif

                                                </td>

                                            </tr>


                                        @endforeach
                                        </tbody>
                                    </table>

                                @endif



                                    <div class="row ">
                                        @if($taxes->status==='ticket-office')
                                            <a class="btn green col s12 ">
                                                <i class="icon-more_horiz left "></i>
                                                ESTADO: SIN PROCESAR AÚN
                                            </a>

                                        @elseif($taxes->status==='process')
                                            <a href="#" class="btn green col s12">
                                                <i class="icon-more_horiz left "></i>
                                                ESTADO: SIN CONCILIAR AÚN

                                            </a>
                                        @elseif($taxes->status==='verified'||$taxe->status=='verified-sysprim')

                                            <a href="#" class="btn blue col s12">
                                                <i class="icon-more_horiz left"></i>
                                                ESTADO: {{$taxes->statusName}}
                                            </a>


                                        @elseif($taxes->status=='cancel')

                                            <a href="#" class="btn red col s12">
                                                <i class="icon-more_horiz left"></i>
                                                ESTADO: CANCELADA.
                                            </a>
                                        @endif

                                        @if($taxes->status=='process'||$taxes->status=='ticket-office'||$taxes->status=='temporal'||$taxes->status=='verified-sysprim'||$taxes->status=='verified')

                                            <div class="col l12">
                                                <h4 class="center-align mt-2">Acciones</h4>
                                            </div>


                                            <div class="input-field col s12">

                                                @can('Anular Pagos')
                                                    <a href="#"
                                                       class="btn btn-rounded col s4 red waves-effect waves-ligt reconcile"
                                                       data-status="cancel">
                                                        ANULAR PLANILLA.
                                                        <i class="icon-close right"></i>
                                                    </a>
                                                @endcan
                                                @can('Verificar Pagos - Manual')
                                                    @if($verified&&$taxes->status!=='verified' && $taxes->status!=='verified-sysprim')
                                                        <a href="#"
                                                           class="btn btn-rounded col s4 blue waves-effect waves-light reconcile"
                                                           data-status="verified">
                                                            VERIFICAR PLANILLA.
                                                            <i class="icon-verified_user right"></i>
                                                        </a>
                                                    @endif
                                                @endcan
                                                @if($taxes->status=='verified'||$taxes->status=='verified-sysprim')
                                                    <button type="button" id="send-email-verified"
                                                            class="btn btn-rounded col s4 green waves-effect waves-light"
                                                            value="{{$taxes->id}}">Enviar Correo Verificado.
                                                        <i class="icon-mail_outline right"></i>
                                                    </button>
                                                @endif


                                                    @if($taxes->status='cancel')
                                                        <a href="{{route('ticket-office.download.pdf',['id'=>$taxes->id])}}" id="#"
                                                           class="btn btn-rounded col s3 red darken-4 waves-effect waves-light" target="_blank" >Ver Planilla(PDF).
                                                            <i class="icon-picture_as_pdf right"></i>
                                                        </a>
                                                    @endif
                                            </div>
                                        @endif
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