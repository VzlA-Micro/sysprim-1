@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if($taxes->status!=='temporal'&&substr($taxes->code,0,1)=='P')
                <div class="col s12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="">{{ session('company') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-payments', ['company' => session('company')]) }}">Mis Declaraciones</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payments.history',['company'=>session('company')]) }}">Historial
                                de Pagos</a></li>
                        <li class="breadcrumb-item"><a href="#!">Detalles de Autoliquidación</a></li>
                    </ul>
                </div>
            @else
                <div class="col s12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.my-business') }}">Mis Empresas</a></li>
                        <li class="breadcrumb-item"><a href="">{{ session('company') }}</a></li>
                        <li class="breadcrumb-item"><a
                                    href="{{ route('companies.my-payments', ['company' => session('company')]) }}">Mis
                                Declaraciones</a></li>
                        <li class="breadcrumb-item"><a
                                    href="{{ route('payments.create',['company'=>session('company'),'type'=>'actuated']) }}">Pagar
                                Impuestos</a></li>
                        <li class="breadcrumb-item"><a href="#!">Detalles de Autoliquidación</a></li>
                    </ul>
                </div>
            @endif
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
                    <form method="post" action="{{ route('company.taxes.save')}}" id='register-taxes'
                          class="card-content row">
                        @csrf
                        @foreach($ciuTaxes as $ciu)
                            <div class="input-field col s12 m6">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="code" id="code_{{$ciu->ciu->code}}" class="code" value="{{ $ciu->ciu->code }}"
                                       required readonly>
                                <label for="code_{{$ciu->ciu->code}}">Código</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-assignment prefix"></i>
                                <input type="text" name="ciu" id="ciu_{{$ciu->ciu->code}}" value="{{ $ciu->ciu->name }}" required readonly>
                                <label for="ciu_{{$ciu->ciu->code}}">CIU</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="base[]" id="base_{{$ciu->ciu->code}}" class="validate money"
                                       value="{{ $ciu->base }}" readonly>
                                <label for="base_{{$ciu->ciu->code}}">Base Imponible</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="tasa[]" id="tasa_{{$ciu->ciu->code}}" class="validate recargo money"
                                       pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{$ciu->recharge}}" readonly>
                                <label for="tasa_{{$ciu->ciu->code}}">Recargo (12%)<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="interest[]" id="interest_{{$ciu->ciu->code}}" class="validate money"
                                       pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{$ciu->interest}}" readonly>
                                <label for="interest_{{$ciu->ciu->code}}">Interes por mora<b> (Bs)</b></label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="total_ciu[]" id="total_ciu_{{$ciu->ciu->code}}" class="validate total_ciu money"
                                       pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $ciu->totalCiiu}}" readonly>
                                <label for="total_ciu_{{$ciu->ciu->code}}">Impuesto Causado por CIU<b> (Bs)</b></label>
                            </div>

                            <div class="input-field col s12">
                                    <div class="divider"></div>
                            </div>

                        @endforeach


                        @foreach($taxes->companies as $tax)

                            <div class="input-field col s12 m6">
                                <i class="icon-warning prefix"></i>
                                <input type="text" name="day_mora[]" id="day_mora" class="validate"
                                       pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $tax->pivot->day_mora }}"
                                       readonly>
                                <label for="day_mora">Días de Atraso:</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>

                                <input type="text" name="deductions[]" id="deductions" class="validate money"
                                       pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $tax->pivot->deductions }}"
                                       readonly>
                                <label for="deductions">Deducciones</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="withholding[]" id="withholdings" class="validate money"
                                       pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $tax->pivot->withholding }}"
                                       readonly>
                                <label for="withholdings">Retenciones</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                </i>
                                <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money"
                                       pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="{{ $tax->pivot->fiscal_credits }}"
                                       readonly>
                                <label for="fiscal_credits">Creditos Fiscales</label>
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
                                <div class=" input-field col s12 m12 ">
                                    <i class="icon-warning prefix"></i>
                                    <input type="text" name="interest" class="validate money" id='interest'
                                           value="{{$amount['amountInterest']}}" readonly>
                                    <label for="interest">Total de Interes por Mora:(Bs)</label>
                                </div>
                                <div class=" input-field col s12 m12 ">
                                    <i class="icon-warning prefix"></i>
                                    <input type="text" name="recargo" class="validate money"
                                           value="{{$amount['amountRecargo']}}" readonly>
                                    <label for="recargo">Total de Recargo Interes :(Bs)</label>
                                </div>
                                <div class=" input-field col s12 m12 ">
                                    <i class=" prefix">
                                        <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                                    </i>
                                    <input type="text" name="total" class="validate total money"
                                           value="{{$amount['amountTotal']}}" readonly>
                                    <label for="total_pagar">Total a Pagar:(Bs)</label>
                                </div>
                                <input type="hidden" id="bank" name="bank" value="0">
                                <input type="hidden" id="payments" name="payments" value="1">
                                <input type="hidden" name="taxes_id" value="{{$taxes->id}}" id="taxes_id">
                            </div>


                            <div class="row" style="padding: 1rem">
                                <div class="input-field col s12">
                                    {{-- Modal trigger --}}
                                    @if($taxes->status!='verified'&&$taxes->status!='verified-sysprim'&&\Auth::user()->id===$taxes->companies[0]->users[0]->id)
                                        <a href="{{ route('taxes.calculate',['id'=>$taxes->id]) }}"
                                           class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger">
                                            Calcular de nuevo
                                            <i class="icon-refresh right"></i></a>

                                        <!-- <a href="#" id="download-calculate"  class="btn btn-rounded col s4 peach waves-effect waves-light modal-trigger">
                                             Descargar Calculo.
                                             <i class="icon-cloud_download right"></i>
                                         </a>-->
                                        <button type="submit"
                                                class="btn btn-rounded col s6 peach waves-effect waves-light modal-trigger"
                                                id="continue">
                                            Continuar
                                            <i class="icon-more_horiz right"></i>
                                        </button>
                                        {{-- Modal structure --}}
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