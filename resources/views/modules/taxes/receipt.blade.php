<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planilla</title>
    {{-- <link rel="stylesheet" href="http://sysprim.com.devel/css/materialize.min.css">
    <link rel="stylesheet" href="http://sysprim.com.devel/css/material-componente.css"> --}}
    <link rel="stylesheet" href="http://sysprim.com.devel/css/pdf.css">
	<style>
		body {

		}
	</style>
</head>
<body style="font-family:Helvetica!important;">
@php setlocale(LC_MONETARY, 'en_US');@endphp
    <div class="receipt-header" style="">
    	<table style="width: 100%; border-collapse: collapse;">
	        <tr style="text-align: center">
	            <td style="width: 25%;">
					<img src="http://sysprim.com.devel/images/alcaldia_logo.png" style="width:180px; height:80px" alt="">
	            </td>
	            <td style="width: 50%;" style="text-align: center;">
					República Bolivariana de Venezuela <br>
					Alcaldía Bolivariana del Municipio Iribarren <br>
					Barquisimeto - Edo. Lara
	            </td>
	            <td style="width: 25%;">
					<img src="http://sysprim.com.devel/images/semat_logo.png" style="width:180px; height:80px" alt="">
	            </td>
	        </tr><!-- 
	        <tr>
	            <td style="width: 30%; border: solid 1px #FF0000;">AAA</td>
	            <td style="width: 40%; border: solid 1px #00FF00;">BBB</td>
	            <td style="width: 30%; border: solid 1px #0000FF;">CCC</td>
	        </tr>
	        <tr>
	            <td style="width: 30%; border: solid 1px #FF0000;">AAA</td>
	            <td style="width: 40%; border: solid 1px #00FF00;">BBB</td>
	            <td style="width: 30%; border: solid 1px #0000FF;">CCC</td>
	        </tr> -->
	    </table>
    </div>
    <h4 style="text-align:center">DEPOSITO TRIBUTARIO MUNICIPAL</h4>
    <hr>
    <table style="width: 100%; border-collapse: collapse;">
    	<tr style="">
    		<td style="width:15%;font-size: 14px !important; "><b>Contribuyente:</b></td>
    		<td style="width:35%;font-size: 13px !important;">{{$taxes->companies->name}}</td>
    		<td style="width:20%;font-size: 14px !important;"><b>Codigo Catastral:</b></td>
    		<td style="width:30%;font-size: 13px !important;">{{$taxes->companies->code_catastral}}</td>
    	</tr>
    	<tr>
    		<td style="width:15%;font-size: 14px !important;"><b>Cedula o RIF:</b></td>
    		<td style="width:35%;font-size: 13px !important;">{{$taxes->companies->RIF}}</td>
    		<td style="width:20%;font-size: 14px !important;"><b>Cód. Licencia:</b></td>
    		<td style="width:30%;font-size: 13px !important">{{$taxes->companies->license}}</td>
    	</tr>
    	<tr>
    		<td style="width:15%;font-size: 14px !important"><b>Dirección:</b></td>
    		<td style="width:35%;font-size: 12px !important">{{$taxes->companies->address}}</td>

			<td style="width:15%;font-size: 14px !important;"><b>Planilla liquidada:</b></td>
			<td style="width:35%;font-size: 13px !important;">{{$taxes->code}}</td>
    	</tr>
    	<tr>
    		<td style="width:15%;font-size: 14px !important;"><b>Telf. Empresa:</b></td>
    		<td style="width:35%;font-size: 13px !important;">{{$taxes->companies->phone}}</td>

    	</tr>
    	<tr>
    		<td style="width:15%;font-size: 14px !important;"><b>Pers.Rsponsable:</b></td>
    		<td style="width:35%;font-size: 13px !important;">{{\Auth()->user()->name .' '.\Auth()->user()->surname}}</td>
    		<td style="width:20%;font-size: 14px !important;"><b>Oficina:</b></td>
    		<td style="width:30%;font-size: 13px !important;">VIRTUAL</td>
    	</tr>
    </table>
    <hr>
	<table style="width: 100%;">
		<thead>
			<tr style="border-bottom: 1px solid #000; !important;">
				<th style="width: 10%;font-size: 13px !important; ">CIIU</th>
				<th style="width: 20%;font-size: 13px !important;">Descripción</th>
				<th style="width: 10%;font-size: 13px !important;">Ramo</th>
				<th style="width: 10%;font-size: 13px !important;">Lapso</th>
				<th style="width: 15%;font-size: 13px !important;">Base Imponible</th>
				<th style="width: 15%;font-size: 13px !important;">Monto o Benef/CF</th>
				<th style="width: 10%;font-size: 13px !important;">Impuesto</th>
		</thead>

		<tbody>
		@php $total_taxes=0;@endphp
		@foreach($taxes->taxesCiu as $ciu)
			@php
			 	if($ciu->pivot->base!=0&&$ciu->pivot->interest!=0){
			 	$taxe=$ciu->pivot->base*$ciu->alicuota/100;
				$surchange_total=$ciu->pivot->tax_rate+$taxe;
				$interest_total=$surchange_total+$ciu->pivot->interest;
				$total_taxes+=$surchange_total+$ciu->pivot->mora;
			 	}else{
			   	 $taxe=$ciu->pivot->unid_tribu*$ciu->min_tribu_men;
			 	 $total_taxes+=$taxe;
			 	}
			@endphp







			<tr>
				<td style="width: 10%;font-size: 12px !important;">{{$ciu->code}}</td>
				<td style="width: 30%;font-size: 11px;!important;">{{$ciu->name}}</td>
				<td style="width: 10%;font-size: 12px;!important">Act Eco</td>
				<td style="width: 10%;font-size: 12px; !important;">{{$taxes->fiscal_period}}</td>
				<td style="width: 15%;font-size: 12px;!important">@php echo number_format($ciu->pivot->base, 2);@endphp</td>
				<td style="width: 15%;font-size: 12px;!important">{{$ciu->alicuota."%"}}</td>
				<td style="width: 10%;font-size: 12px;!important">{{number_format($taxe,2)}}</td>
			</tr>



		@if($ciu->pivot->interest!==0)
			<tr>
				<td></td>
				<td style="font-size: 13px !important;">Recargo</td>
				<td></td>
				<td></td>
				<td style="font-size: 12px !important;">{{number_format($taxe,2)}}</td>
				<td style="font-size: 12px !important;">{{number_format($ciu->pivot->tax_rate,2)}}</td>
				<td style="font-size: 12px !important;">{{number_format($surchange_total,2)}}</td>
			</tr>
			<tr>
				<td></td>
				<td style="font-size: 13px !important;">Interés por mora</td>
				<td></td>
				<td></td>
				<td style="font-size: 12px !important;">{{number_format($surchange_total)}}</td>
				<td style="font-size: 12px !important;">{{number_format($ciu->pivot->interest,2)}}</td>
				<td style="font-size: 12px !important;">{{number_format($surchange_total,2)}}</td>
			</tr>


			<tr>
				<td></td>
				<td style="font-size: 13px !important;">Mora</td>
				<td></td>
				<td></td>
				<td style="font-size: 12px !important;">{{number_format($surchange_total,2)}}</td>
				<td style="font-size: 12px !important;">{{number_format($ciu->pivot->mora,2)}}</td>
				<td style="font-size: 12px !important;">{{number_format($surchange_total+$ciu->pivot->mora,2)}}</td>
			</tr>
		@endif
		@endforeach

		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>TOTAL</td>
			<td style="font-size: 14px !important; text-align: left">{{number_format($total_taxes,2)}}</td>
		</tr>
		</tbody>


		<hr>
		<tr>
			<td colspan="7">{{strtoupper(NumerosEnLetras::convertir($total_taxes))."."}}</td>
		</tr>
	</table>
	<?php
    $num = 'CMD01-'.date('ymd');
    $nom = 'DUPONT Alphonse';
    $date = '31/12/'.date('Y');
?>
    

    <div style="position: absolute; right: 3mm; bottom: 3mm; text-align: right; font-size: 4mm; ">
        <table style="width: 100%">
        	<tr>
        		<td style="width: 30%"></td>
        		<td style="width: 30%"></td>
        		<td style="width: 100%;">
					<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate("http://sysprim.com.devel/payments/taxes/".$taxes->id)) !!} " style="float: left;position: absolute;top: -120px;right: -700px !important;">
        		</td>

        	</tr>
			<tr>

			</tr>
        </table>
        <b></b>  <b></b><br>
         <b></b><br>
         <b></b><br>


		<table style="width: 100%;margin-bottom:-30px;">
			<tr>
				<td style="width: 100%;text-align: center;">
					{{$taxes->created_at}}
				</td>
			</tr>
			<tr>
				<td style="width: 100%;text-align: center;">
					**ESTE DOCUMENTO VA SIN TACHADURA NI ENMENDADURA.**
				</td>
			</tr>
		</table>
    </div>
</body>
</html>