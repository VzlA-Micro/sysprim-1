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
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <form action="{{ route('taxes.save') }}" method="post" class="card" id="taxes-register">
                   @if(session("message") )
                        <div class="alert alert-danger center-align">
                            <strong>{{session("message")}}</strong>
                        </div>
                    @endif
                        {{--
                    @elseif($date['status']==='process')
                        <div class="alert alert-success center-align">
                            <strong>ACTIVIDAD ECONOMICA DECLARADA, POR FAVOR CONCILIE SUS PAGOS.</strong>
                        </div>
                    @else
                    --}}


                        <div class="card-header center-align">
                            <h5>Declarar actividad Económica</h5>
                        </div>

                        <div class="card-content row">
                            @csrf
                            <div class="input-field col s12">
                                <i class="icon-date_range prefix"></i>
                                <select name="fiscal_period" id="fiscal_period">
                                    <option value="null" disabled selected>Seleciona un Periodo Fiscal</option>
                                    @if(!isset($mount_pay['2019-12-01']))
                                        <option value="{{"2019-12-01"}}">{{"DICIEMBRE 2019 "}}</option>
                                    @else
                                        <option value="{{"2019-12-01"}}" disabled >{{"DICIEMBRE 2019|".$mount_pay['2019-12-01']}}</option>
                                    @endif

                                    @foreach($mounths as $key=>$value)
                                        @php
                                            $band=false; $status; @endphp
                                                @if($mount_pay!==null)
                                                    @foreach($mount_pay as $key_mont=>$value_month)
                                                            @if($key_mont==date('Y').'-'.$value.'-'.'01'&&!$band)
                                                                    @php

                                                                           $band=true;

                                                                           $status=$value_month;

                                                                    @endphp

                                                            @endif
                                                    @endforeach
                                                @endif
                                                @if(!$band)
                                                    @if($value<$mountNow)
                                                      <option value="{{date('Y').'-'.$value.'-'.'01'}}">{{$key." ".date('Y')}}</option>
                                                    @endif
                                                @else
                                                     <option value="{{date('Y').'-'.$value.'-'.'01'}}" disabled>{{$key." ".date('Y')."|".$status}}</option>
                                                @endif
                                    @endforeach

                                </select>
                                <label>Perido Fiscal</label>
                            </div>

                          <input type="hidden" id="company_id" name="company_id" value="{{ $company->id }}">
                          <input type="hidden" id="tributo" name="tributo" value="{{ $unid_tribu }}">
                          <input type="hidden" id="type_company" name="type_company" value="{{ $company->typeCompany }}">

                            {{--   <div class="input-field col s12">
                                  <input type="hidden" name="fiscal_period" id="fiscal_period"
                                         value="{{$date['fiscal_period']}}">
                              </div>


                          <!--   <div class="input-field col s12">
                                  <i class="icon-date_range prefix"></i>
                                  <input type="text" name="fiscal_period_view" id="fiscal_period_view"
                                         value="{{$date['mount_pay']}}" readonly>
                                  <label for="fiscal_period">Periodo Fiscal</label>
                              </div>
  -->--}}
                            <div class="divider"></div>
                            @foreach($company->ciu as $ciu)
                                @if($ciu->pivot->status!=='disabled')
                                <div class="ciu-company">
                                    <input type="hidden" name="ciu_id[]" value="{{ $ciu->id }}">
                                    <input type="hidden" name="ciu_alicuota" class="ciu_alicuota"
                                           value="{{ $ciu->alicuota }}">
                                    <input type="hidden" name="min_tribu_men[]" class="min_tribu_men"  id="min_tribu_{{$ciu->code}}" value="{{ $ciu->min_tribu_men}}">
                                    <div class="input-field col s12 m4 tooltipped" data-position="bottom" data-tooltip="Código del Clasificador Industrial Internacional Uniforme, el mismo facilita a los contribuyentes la ubicación de las actividades por sectores y algunos subgrupos con referencias específicas de su actividad económica (Ord.  AE I Parte Normativa, 6. Régimen Tarifario). .">
                                        <i class="icon-confirmation_number prefix"></i>
                                        <input type="text" name="code" id="code" value="{{ $ciu->code }}" class="code" required readonly>
                                        <label for="code">Código</label>
                                    </div>
                                    <div class="input-field col s12 m4 tooltipped" data-position="bottom" data-tooltip="Nombre del Clasificador Industrial Internacional Uniforme del código.">
                                        <i class="icon-assignment prefix"></i>
                                        <input type="text" name="ciu" id="ciu" value="{{ $ciu->name }}" required readonly>
                                        <label for="ciu">CIIU</label>
                                    </div>

                                    <div class="input-field col s12 m4">
                                        <i class="icon-info prefix amber-text tooltipped" data-position="bottom" data-tooltip="Es el monto constituido por los ingresos brutos efectivamente percibidos en el período impositivo correspondiente, por las actividades económicas u operaciones cumplidas en la jurisdicción del Municipio Iribarren o que deban reputarse como ocurridas en esta jurisdicción de acuerdo con los criterios previstos en la ley nacional, en esta ordenanza o en los acuerdos o convenios celebrados a tales efectos (Ord. AE Art. 7)."></i>
                                        <input type="text"  name="base[]" id="base_{{$ciu->code}}" class="validate money_keyup base" maxlength="18" required>
                                        <label for="base_{{$ciu->code}}">Base Imponible</label>
                                    </div>

                                    <input type="hidden" id="alicuota_{{$ciu->code}}"   class="alicuota" value="{{ $ciu->alicuota }}">
                                </div>

                                @endif
                                    <div class="input-field col s12">
                                        <div class="divider"></div>
                                    </div>
                            @endforeach

                            <div class="input-field col s12 m4">
                                <i class="icon-info prefix amber-text  tooltipped" data-position="bottom" data-tooltip="Cuando se trate de un contribuyente industrial que venda los bienes producidos en otros  municipios distintos al de la ubicación de la industria, el impuesto pagado por el ejercicio de actividades económicas en el Municipio sede de la industria, podrá deducirse del impuesto a pagar en el Municipio en que se realiza la actividad comercial. En caso que la venta se realice en más de un Municipio sólo podrá deducirse el impuesto pagado por el ejercicio de la actividad industrial proporcional a los bienes vendidos en  cada Municipio. En ningún caso la cantidad a deducir podrá exceder de la cantidad de impuesto que corresponda pagar en la jurisdicción del establecimiento  comercial (Ord. AE Art. 7, Parágrafo Quinto N° 3)."></i>
                                <input type="text"  name="deductions" id="deductions" class="validate money_keyup deductions"  required>
                                <label for="deductions">Deducciones(SEDE INDUSTRIA)</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="icon-info prefix amber-text tooltipped" data-position="bottom" data-tooltip="El agente es responsable ante el contribuyente por las retenciones efectuadas sin normas legales o reglamentarias que lo autoricen. Si el agente enteró al Fisco Municipal lo retenido, el contribuyente podrá solicitar la correspondiente compensación (Ord.AE Art. 112), para que la retención pueda ser aplicada a su declaración debe pasar previamente por la Gerencia de Recaudación, presentar el soporte para ser validada, se aceptaran solo retenciones emitidas en el Municipio Iribarren."></i>
                                <input type="text"  name="withholding" id="withholdings" class="validate money_keyup withholding"   required>
                                <label for="withholdings">Retenciones</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="icon-info prefix amber-text tooltipped" data-position="bottom" data-tooltip="En caso que en un período impositivo determinado, por la aplicación del mínimo tributable en algunos de los anticipos mensuales, surja una diferencia o crédito a favor del sujeto pasivo, la misma le será reconocida mediante acto administrativo como un crédito fiscal, el cual deberá ser descontado del monto del impuesto que le corresponda pagar en posteriores periodos impositivos o del impuesto determinado luego de un procedimiento de determinación tributaria, de ser el caso (Ord. AE Art 44, Parágrafo Único)."></i>
                                <input type="text" name="fiscal_credits" id="fiscal_credits" class="validate money_keyup credits_fiscal"   required>
                                <label for="fiscal_credits">Creditos Fiscales</label>
                            </div>

                        </div>
                        <!--<div class="card-footer">
                            <b>NOTA:</b> Si la Empresa tiene menos de 4 años utilizando el beneficio por trabajadores, te invitamos pases por nuestras oficina en las Torre David Planta Mezzanina Gerencia de Recaudación Dpto. Cuentas por Cobrar
                        </div>-->
                        <div class="card-footer">
                            <b>NOTA:</b> Para que la retención pueda ser aplicada a su declaración debe pasar previamente por la Gerencia de Recaudación y presentar el soporte para ser validada, se aceptaran solo retenciones emitidas en la Jurisdicción del Municipio Iribarren.
                            El agente es responsable ante el contribuyente por las retenciones efectuadas sin normas legales o reglamentarias que lo autoricen. Si el agente enteró al Fisco Municipal lo retenido, el contribuyente podrá solicitar la correspondiente compensación (Ord. Act. Económica Art. 112).
                        </div>
                        <div class="card-action center-align">
                            <button onclick="window.history.back();" type="button" class="btn btn-rounded btn-large waves-effect waves-light grey">
                                <i class="icon-navigate_before right"></i>
                                Atras
                            </button>


                            <a href="#declaracion" class="btn btn-large btn-rounded waves-effect waves-light peach modal-trigger">Declarar
                                <i class="icon-send right"></i>
                            </a>

                              <!-- Modal Structure -->
                                <div id="declaracion" class="modal">
                                <div class="modal-content left-align">
                                    <h5 class="center-align">Declaracción Jurada</h5>
                                    <p>Yo, <b>{{ Auth::user()->name . " " . Auth::user()->surname }}</b> titular de la
                                        C.I.
                                        N° <b>{{ Auth::user()->ci }}</b> y de domicilio en
                                        <b>{{ Auth::user()->address }}</b>, declaro bajo Fé de Juramento que todos los
                                        datos
                                        y cifras que aparecen en esta declaración son una copia fiel y exacta de los
                                        datos
                                        contenidos en los libros de contabilidad y que han sido llevados de acuerdos con
                                        los
                                        principios de contabilidad generalmente aceptados, igualmente autorizo
                                        suficientemente al <b>Servicio Municipal de Administración Tributaria
                                            (SEMAT)</b> a
                                        efecto de verificar la veracidad de lo aquí declarado.<br>A los
                                        <b>{{\Carbon\Carbon::now()->format('d')}}</b> días del mes
                                        <b>{{\Carbon\Carbon::now()->format('m')}}</b> del año
                                        <b>{{\Carbon\Carbon::now()->format('Y')}}</b>.</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#!" class="modal-close btn btn-flat waves-effect waves-green">Cancelar</a>
                                    <a href="#!" class="modal-close btn peach waves-effect waves-light " id="accept">Yo Declaro</a>
                                </div>
                              </div>
                        </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/dev/taxes.js')}}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection