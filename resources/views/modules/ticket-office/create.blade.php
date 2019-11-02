@extends('layouts.app')

@section('styles')
    <!-- <link rel="stylesheet" href="{{ asset('css/all.css') }}"> -->
@endsection

@section('content')
    @php setlocale(LC_MONETARY, 'en_US');@endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m8">
                <div class="card paper-cut">
                    <div class="card-header center-align">
                        <h5>Pagar Impuestos</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s10">
                            <i class="icon-search prefix"></i>
                            <input id="search" type="search" value="{{$taxe->companies->license}}">
                            <label for="search">Licencia o RIF</label>
                        </div>
                        <div class="input-field col s2 center-align">
                            <button class="btn btn-floating peach">
                                <i class="icon-search"></i>
                            </button>
                        </div>

                        <div class="row padding-1  left-align">
                            <div class="col m6">
                                <ul>
                                    <li><b>Fecha: </b>{{ $taxe->created_at }}</li>
                                    <li><b>Licencia: </b>{{ $taxe->companies->license }}</li>
                                </ul>
                            </div>
                            <div class="col m6">
                                <ul>
                                    <li><b>Nombre: </b>{{ $taxe->companies->name }}</li>
                                    <li><b>RIF: </b>{{ $taxe->companies->RIF }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <input type="hidden" id="company_id" name="company_id" value="">
                        <div class="input-field col s12">
                            <input type="hidden" name="fiscal_period" id="fiscal_period"
                                   value="">
                        </div>
                        <div class="input-field col s12">
                            <i class="icon-event_available prefix"></i>
                            <input type="text" name="fiscal_period" id="fiscal_period" value="{{\App\Helpers\TaxesMonth::convertFiscalPeriod($taxe->fiscal_period)}}" disabled>
                            <label for="fiscal_period">Periodo Fiscal</label>
                        </div>
                        <input type="hidden" name="ciu_id[]" value="">

                        @foreach($ciuTaxes as $ciu)
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Código del Clasificador Industrial Internacional Uniforme, el mismo facilita a los contribuyentes la ubicación de las actividades por sectores y algunos subgrupos con referencias específicas de su actividad económica (Ord.  AE I Parte Normativa, 6. Régimen Tarifario). .">
                                <i class="icon-confirmation_number prefix"></i>
                                <input type="text" name="code" id="code" value="{{$ciu->ciu->code}}" class="code" required readonly>
                                <label for="code">Código</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Nombre del Clasificador Industrial Internacional Uniforme del código.">
                                <i class="icon-assignment prefix"></i>
                                <input type="text" name="ciu" id="ciu" value="{{$ciu->ciu->name}}" required readonly>
                                <label for="ciu">CIIU</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Es el monto constituido por los ingresos brutos efectivamente percibidos en el período impositivo correspondiente, por las actividades económicas u operaciones cumplidas en la jurisdicción del Municipio Iribarren o que deban reputarse como ocurridas en esta jurisdicción de acuerdo con los criterios previstos en la ley nacional, en esta ordenanza o en los acuerdos o convenios celebrados a tales efectos (Ord. AE Art. 7).">
                                <i class="icon-attach_money prefix"></i>                            
                                <input type="text" value="{{number_format($ciu->base,2)}}" name="base[]" id="" class="validate money_keyup base" maxlength="18" required readonly>
                                <label for="">Base Imponible</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Descuento por un Beneficio Fiscal Emitido y/o Aprobado por el Municipio.">
                                <i class="icon-attach_money prefix"></i>                            
                                <input type="text" name="deductions[]" id="" value="{{number_format($ciu->deductions,2)}}"class="validate money_keyup" required readonly>
                                <label for="">Deducciones</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom"data-tooltip="El agente es responsable ante el contribuyente por las retenciones efectuadas sin normas legales o reglamentarias que lo autoricen. Si el agente enteró al Fisco Municipal lo retenido, el contribuyente podrá solicitar la correspondiente compensación (Ord.AE Art. 112), para que la retención pueda ser aplicada a su declaración debe pasar previamente por la Gerencia de Recaudación, presentar el soporte para ser validada, se aceptaran solo retenciones emitidas en el Municipio Iribarren.">
                                <i class="icon-attach_money prefix"></i>                                
                                <input type="text" name="withholding[]" id="" class="validate money_keyup" value="{{number_format($ciu->withholding,2)}}" required readonly>
                                <label for="">Retenciones</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="En caso que en un período impositivo determinado, por la aplicación del mínimo tributable en algunos de los anticipos mensuales, surja una diferencia o crédito a favor del sujeto pasivo, la misma le será reconocida mediante acto administrativo como un crédito fiscal, el cual deberá ser descontado del monto del impuesto que le corresponda pagar en posteriores periodos impositivos o del impuesto determinado luego de un procedimiento de determinación tributaria, de ser el caso (Ord. AE Art 44, Parágrafo Único).">
                                <i class="icon-attach_money prefix"></i>                                
                                <input type="text" name="fiscal_credits[]" id="" class="validate money_keyup" value="{{number_format($ciu->credits_fiscal,2)}}" required readonly>
                                <label for="">Creditos Fiscales</label>
                            </div>
                        @endforeach
                        <div class="input-field col s12">
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
            <div class="col s12 m4">
                <ul class="collection with-header">
                    <li class="collection-header"><h4>Pagar</h4></li>
                    <li class="collection-item">
                        <div>
                            Contribuyente:
                            <span class="secondary-content">
                                {{$taxe->companies->users[0]->name." ".$taxe->companies->users[0]->surname }}
                            </span>
                        </div>
                    </li>

                    @foreach($ciuTaxes as $ciu)
                        <li class="collection-item">
                            {{$ciu->ciu->code}}
                            <div>
                            <span class="secondary-content tuncate">
                                {{$ciu->ciu->name}}
                            </span>
                            </div>
                        </li>

                    <li class="collection-item">
                        <div>
                            Base Imponible
                            <span class="secondary-content">
                                {{number_format($ciu->totalCiiu,2)}}
                            </span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            Retenciones
                            <span class="secondary-content">{{number_format($ciu->withholding,2)}}</span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            Créditos Fiscales
                            <span class="secondary-content">{{number_format($ciu->credit_fiscal,2)}}</span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            Deducciones
                            <span class="secondary-content">{{number_format($ciu->deductions,2)}}</span>
                        </div>
                    </li>
                        @if($ciu->interest!=0)
                        <li class="collection-item">
                            <div>
                                Recargo
                                <span class="secondary-content">{{number_format($ciu->tax_rate,2)}}</span>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div>
                                Interés por mora
                                <span class="secondary-content">{{number_format($ciu->interest,2)}}</span>
                            </div>
                        </li>
                        @endif
                    @endforeach


                    <li class="collection-item amount-block">
                        <div class="total">
                            <div class="side-heading">Total</div>
                            <div class="amount">{{number_format($taxe->amount,2)}}</div>
                        </div>
                        <div class="total">
                            <div class="side-heading">Subtotal</div>
                            <div class="amount"></div>
                        </div>
                    </li>
                    <li class="collection-item row">
                        <div class="col s12 center-align">
                            @if($taxe->status!='verified')
                                <a href="{{-- {{ route('payments.help',['id'=>$taxes->id]) }} --}}#modal1"  class="btn btn-rounded col s6 blue waves-effect waves-light modal-trigger">PAGAR</a>
                            @else
                                <a href=""  class="btn btn-rounded col s12 blue waves-effect waves-light">GENERAR PLANILLA</a>

                            @endif
                        </div>
                            {{-- Modal structure --}}
                        <div id="modal1" class="modal modal-fixed-footer">
                            <div class="modal-content">
                                <h4 class="center-align">Pagar</h4>
                                <form method="POST" action="{{route('taxes.save')}}">
                                    <input type="hidden" name="taxes_id" value="{{$taxe->id}}">
                                    <div class="input-field col s12 m6 ">
                                        <i class="icon-confirmation_number prefix "></i>
                                        <input type="text" name="lot" id="lot" value="" class="validate" required >
                                        <label for="lot">Lote</label>
                                    </div>

                                    <div class="input-field col s12 m6 ">
                                        <i class="icon-confirmation_number prefix "></i>
                                        <input type="text" name="ref" id="ref" value="" class="validate" required >
                                        <label for="ref">Referencia</label>
                                    </div>

                                    <div class="input-field col s12 m6 ">
                                        <i class="icon-touch_app prefix "></i>
                                        <input type="text" name="amount" id="amount" value="" class="validate" required>
                                        <label for="amount">Monto</label>
                                    </div>


                                    <div class="input-field col s12 m6 ">
                                        <i class="icon-monetization_on prefix "></i>
                                        <select>
                                            <option>100%banco</option>
                                            <option>BOD</option>
                                        </select>
                                        <label for="code">Banco</label>
                                    </div>
                                    <div class="input-field col s12 m6 ">
                                        <button type="submit" class="btn blue-45deg-gradient-1">Registrar</button>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection