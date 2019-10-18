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
</head>
<body>
    <div class="receipt-header font-nunito">
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
    	<tr>
    		<td style="width:15%"><b>Contribuyente:</b></td>
    		<td style="width:35%">{{$taxes->companies->name}}</td>
    		<td style="width:20%"><b>Codigo Catastral:</b></td>
    		<td style="width:30%">{{$taxes->companies->code_catastral}}</td>
    	</tr>
    	<tr>
    		<td style="width:15%"><b>Cedula o RIF:</b></td>
    		<td style="width:35%">{{$taxes->companies->RIF}}</td>
    		<td style="width:20%"><b>Cód. Licencia:</b></td>
    		<td style="width:30%">{{$taxes->companies->license}}</td>
    	</tr>
    	<tr>
    		<td style="width:15%"><b>Dirección:</b></td>
    		<td style="width:35%">{{$taxes->companies->address}}</td>
    	</tr>
    	<tr>
    		<td style="width:15%"><b>Telf. Empresa:</b></td>
    		<td style="width:35%">{{$taxes->companies->phone}}</td>
    		<td style="width:20%"><b>Operador:</b></td>
    		<td style="width:30%">SYSPRIM</td>
    	</tr>
    	<tr>
    		<td style="width:15%"><b>Planilla Liq:</b></td>
    		<td style="width:35%">{{$taxes->code}}</td>
    		<td style="width:20%"><b>Oficina:</b></td>
    		<td style="width:30%">VIRTUAL</td>
    	</tr>
    </table>
    <hr>
	<table style="width: 100%;">
		<thead>
			<tr>
				<th style="width: 10%">Mat.</th>
				<th style="width: 20%">Descripción</th>
				<th style="width: 10%">Ramo</th>
				<th style="width: 10%">Deuda</th>
				<th style="width: 15%">Planilla</th>
				<th style="width: 15%">Lapso</th>
				<th style="width: 10%">Benef/CF</th>
				<th style="width: 10%">Neto</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="width: 10%">L35FG5</td>
				<td style="width: 20%">Lorem ipsum dolor sit amet.</td>
				<td style="width: 10%">36276247</td>
				<td style="width: 10%">83798736</td>
				<td style="width: 15%">090239602</td>
				<td style="width: 15%">01.12 - 01.19</td>
				<td style="width: 10%">0.00</td>
				<td style="width: 10%">0,14</td>	
			</tr>
		</tbody>
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
        		<td style="width: 40%;"> 
					<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate("http://sysprim.com.devel/paymentsTaxes-register/".$taxes->id)) !!} " style="float: right;position: absolute;top: -100px">
        		</td>
        	</tr>
        </table>
        <b>1</b> place <b>plein tarif</b><br>
        Prix unitaire TTC : <b>45,00&euro;</b><br>
        N° commande : <b><?php echo $num; ?></b><br>
        Date d'achat : <b><?php echo date('d/m/Y à H:i:s'); ?></b><br>
    </div>
</body>
</html>