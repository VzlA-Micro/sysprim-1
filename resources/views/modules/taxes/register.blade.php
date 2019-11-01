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
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="{{ route('taxes.save') }}" method="post" class="card" id="taxes-register">
                    @if(is_null($date))
                        <div class="alert alert-success center-align">
                            <strong>Todavia no hay pagos que realizar.</strong>
                        </div>
                    @elseif(Session::has('message'))
                        <div class="alert alert-success center-align">
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @else

                        <div class="card-header center-align">
                            <h5>Declarar actividad Economica</h5>
                        </div>

                        <div class="card-content row">
                            @csrf
                            <input type="hidden" id="company_id" name="company_id" value="{{ $company->id }}">
                            <div class="input-field col s12">
                                <input type="hidden" name="fiscal_period" id="fiscal_period"
                                       value="{{$date['fiscal_period']}}">
                            </div>

                            <div class="input-field col s12">
                                <input type="text" name="fiscal_period" id="fiscal_period"
                                       value="{{$date['mount_pay']}}" disabled>
                                <label for="fiscal_period">Periodo Fiscal</label>
                            </div>

                            @foreach($company->ciu as $ciu)
                                <input type="hidden" name="ciu_id[]" value="{{ $ciu->id }}">
                                <input type="hidden" name="ciu_alicuota" class="ciu_alicuota"
                                       value="{{ $ciu->alicuota }}">
                                <input type="hidden" name="min_tribu_men[]" class="min_tribu_men" value="{{ $ciu->min_tribu_men}}">
                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Código del Clasificador Industrial Internacional Uniforme, el mismo facilita a los contribuyentes la ubicación de las actividades por sectores y algunos subgrupos con referencias específicas de su actividad económica (Ord.  AE I Parte Normativa, 6. Régimen Tarifario). .">
                                    <i class="icon-confirmation_number prefix"></i>
                                    <input type="text" name="code" id="code" value="{{ $ciu->code }}" class="code" required readonly>
                                    <label for="code">Código</label>
                                </div>
                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Nombre del Clasificador Industrial Internacional Uniforme del código.">
                                    <i class="icon-assignment prefix"></i>                                    
                                    <input type="text" name="ciu" id="ciu" value="{{ $ciu->name }}" required readonly>
                                    <label for="ciu">CIIU</label>
                                </div>

                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Es el monto constituido por los ingresos brutos efectivamente percibidos en el período impositivo correspondiente, por las actividades económicas u operaciones cumplidas en la jurisdicción del Municipio Iribarren o que deban reputarse como ocurridas en esta jurisdicción de acuerdo con los criterios previstos en la ley nacional, en esta ordenanza o en los acuerdos o convenios celebrados a tales efectos (Ord. AE Art. 7).">
                                    <i class="icon-attach_money prefix"></i>                                    
                                    <input type="text"  name="base[]" id="base_{{$ciu->code}}" class="validate money_keyup base" maxlength="18" required>
                                    <label for="base_{{$ciu->code}}">Base Imponible</label>
                                </div>

                                <input type="hidden" id="alicuota_{{$ciu->code}}"   class="alicuota" value="{{ $ciu->alicuota }}">

                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Cuando se trate de un contribuyente industrial que venda los bienes producidos en otros  municipios distintos al de la ubicación de la industria, el impuesto pagado por el ejercicio de actividades económicas en el Municipio sede de la industria, podrá deducirse del impuesto a pagar en el Municipio en que se realiza la actividad comercial. En caso que la venta se realice en más de un Municipio sólo podrá deducirse el impuesto pagado por el ejercicio de la actividad industrial proporcional a los bienes vendidos en  cada Municipio. En ningún caso la cantidad a deducir podrá exceder de la cantidad de impuesto que corresponda pagar en la jurisdicción del establecimiento  comercial (Ord. AE Art. 7, Parágrafo Quinto N° 3).">
                                    <i class="icon-attach_money prefix"></i>                                                                        
                                    <input type="text"  name="deductions[]" id="deductions_{{$ciu->code}}" class="validate money_keyup" required>
                                    <label for="deductions_{{$ciu->code}}">Deducciones</label>
                                </div>
                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="El agente es responsable ante el contribuyente por las retenciones efectuadas sin normas legales o reglamentarias que lo autoricen. Si el agente enteró al Fisco Municipal lo retenido, el contribuyente podrá solicitar la correspondiente compensación (Ord.AE Art. 112), para que la retención pueda ser aplicada a su declaración debe pasar previamente por la Gerencia de Recaudación, presentar el soporte para ser validada, se aceptaran solo retenciones emitidas en el Municipio Iribarren.">
                                    <i class="icon-attach_money prefix"></i>                                                                        
                                    <input type="text"  name="withholding[]" id="withholdings_{{$ciu->code}}" class="validate money_keyup"  required>
                                    <label for="withholdings_{{$ciu->code}}">Retenciones</label>
                                </div>
                                <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="En caso que en un período impositivo determinado, por la aplicación del mínimo tributable en algunos de los anticipos mensuales, surja una diferencia o crédito a favor del sujeto pasivo, la misma le será reconocida mediante acto administrativo como un crédito fiscal, el cual deberá ser descontado del monto del impuesto que le corresponda pagar en posteriores periodos impositivos o del impuesto determinado luego de un procedimiento de determinación tributaria, de ser el caso (Ord. AE Art 44, Parágrafo Único).">
                                    <i class="icon-attach_money prefix"></i>                                                                        
                                    <input type="text" name="fiscal_credits[]" id="fiscal_credits_{{$ciu->code}}" class="validate money_keyup"  required>
                                    <label for="fiscal_credits_{{$ciu->code}}">Creditos Fiscales</label>
                                </div>
                                <div class="input-field col s12">
                                    <div class="divider"></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <b>NOTA:</b> Si la Empresa tiene menos de 4 años utilizando el beneficio por trabajadores, te invitamos pases por nuestras oficina en las Torre David Planta Mezzanina Gerencia de Recaudación Dpto. Cuentas por Cobrar
                        </div>
                        <div class="card-footer">
                            <b>NOTA:</b> Para que la retención pueda ser aplicada a su declaración debe pasar previamente por la Gerencia de Recaudación y presentar el soporte para ser validada, se aceptaran solo retenciones emitidas en la Jurisdicción del Municipio Iribarren.
                            El agente es responsable ante el contribuyente por las retenciones efectuadas sin normas legales o reglamentarias que lo autoricen. Si el agente enteró al Fisco Municipal lo retenido, el contribuyente podrá solicitar la correspondiente compensación (Ord. Act. Economica Art. 112).
                        </div>
                        <div class="card-action center-align">
                            <button type="submit" class="btn btn-large btn-rounded waves-effect waves-light peach">Registrar
                                <i class="icon-send right"></i>
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
        <script src="{{asset('js/dev/taxes.js')}}"></script>
@endsection