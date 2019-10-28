@extends('layouts.app')

@section('styles')
    <!-- <link rel="stylesheet" href="{{ asset('css/all.css') }}"> -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m8">
            	<div class="card paper-cut">
            		<div class="card-header center-align">
            			<h5>Pagar Impuestos</h5>
            		</div>
            		<div class="card-content row">
            			<div class="input-field col s10">
            				<input id="search" type="search">
            				<label for="search">Licencia o RIF</label>
            			</div>
            			<div class="input-field col s2 center-align">
            				<button class="btn btn-floating peach">
            					<i class="icon-search"></i>
            				</button>
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
                            <input type="text" name="fiscal_period" id="fiscal_period"
                                       value="" disabled>
                            <label for="fiscal_period">Periodo Fiscal</label>
                        </div>
                        <input type="hidden" name="ciu_id[]" value="">
                            <input type="hidden" name="ciu_alicuota" class="ciu_alicuota"
                                       value="">
                            <input type="hidden" name="min_tribu_men[]" class="min_tribu_men"
                                       value="">

                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Código del Clasificador Industrial Internacional Uniforme, el mismo facilita a los contribuyentes la ubicación de las actividades por sectores y algunos subgrupos con referencias específicas de su actividad económica (Ord.  AE I Parte Normativa, 6. Régimen Tarifario). .">
                                <input type="text" name="code" id="code" value="" class="code" required readonly>
                                <label for="code">Código</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Nombre del Clasificador Industrial Internacional Uniforme del código.">
                                <input type="text" name="ciu" id="ciu" value="" required readonly>
                                <label for="ciu">CIIU</label>
                            </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Es el monto constituido por los ingresos brutos efectivamente percibidos en el período impositivo correspondiente, por las actividades económicas u operaciones cumplidas en la jurisdicción del Municipio Iribarren o que deban reputarse como ocurridas en esta jurisdicción de acuerdo con los criterios previstos en la ley nacional, en esta ordenanza o en los acuerdos o convenios celebrados a tales efectos (Ord. AE Art. 7).">
                                <input type="text"  name="base[]" id="" class="validate money_keyup base" maxlength="18" required>
                                <label for="">Base Imponible</label>
                            </div>
                            <input type="hidden" id="" class="alicuota" value="">

                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Descuento por un Beneficio Fiscal Emitido y/o Aprobado por el Municipio.">
                                 <input type="text"  name="deductions[]" id="" class="validate money_keyup"
                                            required>
                                 <label for="">Deducciones</label>
                             </div>
                             <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="El agente es responsable ante el contribuyente por las retenciones efectuadas sin normas legales o reglamentarias que lo autoricen. Si el agente enteró al Fisco Municipal lo retenido, el contribuyente podrá solicitar la correspondiente compensación (Ord.AE Art. 112), para que la retención pueda ser aplicada a su declaración debe pasar previamente por la Gerencia de Recaudación, presentar el soporte para ser validada, se aceptaran solo retenciones emitidas en el Municipio Iribarren.">
                                 <input type="text"  name="withholding[]" id=""
                                           class="validate money_keyup"  required>
                                 <label for="">Retenciones</label>
                             </div>
                            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="En caso que en un período impositivo determinado, por la aplicación del mínimo tributable en algunos de los anticipos mensuales, surja una diferencia o crédito a favor del sujeto pasivo, la misma le será reconocida mediante acto administrativo como un crédito fiscal, el cual deberá ser descontado del monto del impuesto que le corresponda pagar en posteriores periodos impositivos o del impuesto determinado luego de un procedimiento de determinación tributaria, de ser el caso (Ord. AE Art 44, Parágrafo Único).">
                            	<input type="text" name="fiscal_credits[]" id=""
                                           class="validate money_keyup"  required>
                                <label for="">Creditos Fiscales</label>
                            </div>
                            <div class="input-field col s12">
                                <div class="divider"></div>
                            </div>
                        </div>
                       	<div class="card-footer"></div>
            		</div>
            	</div>
	            <div class="col s12 m4">
	            	<ul class="collection with-header">
				        <li class="collection-header"><h4>First Names</h4></li>
				        <li class="collection-item">
				        	<div>
				        		Base Imponible
				        		<span class="secondary-content">10%</span>
				        	</div>
				        </li>
				        <li class="collection-item">
				        	<div>
				        		Retenciones
				        		<span class="secondary-content">10%</span>
				        	</div>
				        </li>
				        <li class="collection-item">
				        	<div>
				        		Créditos Fiscales
				        		<span class="secondary-content">10%</span>
				        	</div>
				        </li>
				        <li class="collection-item">
				        	<div>
				        		Deducciones
				        		<span class="secondary-content">10%</span>
				        	</div>
				        </li>
				        <li class="collection-item amount-block">
				        	<div class="total">
				        		<div class="side-heading">Total</div>
				        		<div class="amount">300$</div>
				        	</div>
				        	<div class="total">
				        		<div class="side-heading">Subtotal</div>
				        		<div class="amount">300$</div>
				        	</div>
				        </li>
				        <li class="collection-item row">
				        	<div class="col s12 center-align">
				        		<a href=" " class="btn col s12 blue">Pagar</a>
				        	</div>
				        </li>
				    </ul>
	            </div>
	        </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection