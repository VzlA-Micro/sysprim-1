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

        td.border {
            border: 1px solid black;
        !important;
            border-right: none;
            border-left: none;
            margin: 0 !important;

        }
    </style>
</head>
<body style="font-family:Helvetica!important;">
@php setlocale(LC_MONETARY, 'en_US');@endphp
<div class="receipt-header" style="">
    <table style="width: 100%; border-collapse: collapse;">
        <tr style="text-align: center">
            <td style="width: 25%;" rowspan="2">
                <img src="http://sysprim.com.devel/images/alcaldia_logo.png" style="width:180px; height:80px"
                     alt=""><br>
                <span></span><br>
                <span style="font-size: 5px;"></span><br>
            </td>
            <td style="width: 50%;" style="text-align: center;font-size: 10px !important;" rowspan="2">
					<span style="font-size: 12px !important;">

					República Bolivariana de Venezuela <br>
					Alcaldía Bolivariana del Municipio Iribarren <br>
					Barquisimeto - Edo. Lara
					</span>
            </td>
            <td style="width: 25%;" rowspan="2">
                <img src="http://sysprim.com.devel/images/semat_logo.png" style="width:180px; height:80px" alt=""><br>
                <span style="font-size: 10px !important;">{{$taxes->code}}</span><br>
                <span style="font-size: 10px !important;">{{$taxes->created_at->format('d-m-Y')}}</span><br>

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

@if($firm)
    <h4 style="text-align:center">RECIBO DE PAGO</h4>
@else
    <h4 style="text-align:center">DEPOSITO TRIBUTARIO MUNICIPAL</h4>
@endif
<table style="width: 100%; border-collapse: collapse;">
    <tr style="">
        <td style="width:15%;font-size: 12px !important; "><b>Contribuyente:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$user->name." ".$user->surname}}</td>
        <td style="width:15%;font-size: 12px !important; "><b>Placa:</b></td>
        <td style="width:15%;font-size: 11px !important;">{{$vehicle[0]->license_plate}}</td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Cedula o RIF:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$user->ci}}</td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important"><b>Dirección:</b></td>
        <td style="width:35%;font-size: 11px !important">{{$user->address}}</td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Telfono:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$user->phone}}</td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Usuario Web:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$user->email}}</td>
        <td style="width:20%;font-size: 12px !important;"><b></b></td>
        <td style="width:30%;font-size: 11px !important;"></td>
    </tr>
</table>

<table style="width: 100%;">
    <thead>
    <tr style="border: 1px solid #000; !important;">
        <td style="width: 30%;font-size: 12px !important;" class="border">Descripción</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Ramo</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Lapso</td>
        <td style="width: 15%;font-size: 12px !important;" class="border">Base Imponible</td>
        <td style="width: 15%;font-size: 12px !important;" class="border">Monto o Benef/CF</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Impuesto</td>
    </thead>

    <tbody>
    <tr>
        <td style="width: 25%;font-size: 10px !important;">
            AutoMovil
            @if($moreThereYear)
                {{' (Mayor de 3A)'}}
            @else
                {{' (Menor a 3A)'}}
            @endif
        </td>
        <td style="width: 10%;font-size: 10px;!important;">{{$taxes->branch}}</td>
        <td style="width: 15%;font-size: 10px;!important">{{$fiscal_period}}</td>
        <td style="width: 15%;font-size: 10px; !important;">0</td>
        <td style="width: 15%;font-size: 10px;!important"></td>
        <td style="width: 10%;font-size: 10px;!important">{{number_format($grossTaxes, 2, ',', '.')}}</td>
        {{$recharge}}
    </tr>
    @if($valueDiscount>0)
        <tr>
            <td style="width: 30%;font-size: 10px !important;">Descuento (20%)</td>
            <td style="width: 10%;font-size: 10px;!important;"></td>
            <td style="width: 10%;font-size: 10px;!important"></td>
            <td style="width: 15%;font-size: 10px; !important;">{{number_format($valueDiscount, 2, ',', '.')}}</td>
            <td style="width: 15%;font-size: 10px;!important">{{'-'.number_format($valueDiscount, 2, ',', '.')}}</td>
            <td style="width: 10%;font-size: 10px;!important">{{number_format($taxes->amount,2)}}</td>
        </tr>
    @endif
    @if($previousDebt > 0)
        <tr>
            <td style="width: 30%;font-size: 10px !important;">Deuda Anterior</td>
            <td style="width: 10%;font-size: 10px;!important;"></td>
            <td style="width: 10%;font-size: 10px;!important"></td>
            <td style="width: 15%;font-size: 10px; !important;">{{number_format($grossTaxes, 2, ',', '.')}}</td>
            <td style="width: 15%;font-size: 10px;!important">{{number_format($previousDebt, 2, ',', '.')}}</td>
            <td style="width: 10%;font-size: 10px;!important">{{number_format($grossTaxes+$previousDebt, 2, ',', '.')}}</td>
        </tr>
    @endif

    @if($recharge > 0)
        <tr>
            <td style="width: 30%;font-size: 10px !important;">recargo (20%)</td>
            <td style="width: 10%;font-size: 10px;!important;"></td>
            <td style="width: 10%;font-size: 10px;!important"></td>
            <td style="width: 15%;font-size: 10px; !important;">{{number_format($grossTaxes+$previousDebt, 2, ',', '.')}}</td>
            <td style="width: 15%;font-size: 10px;!important">{{number_format($recharge, 2, ',', '.')}}</td>
            <td style="width: 10%;font-size: 10px;!important">{{number_format($total, 2, ',', '.')}}</td>
        </tr>
    @endif


    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="width: 15%;font-size: 10px;!important"><b>TOTAL</b></td>
        <td style="width: 10%;font-size: 14px !important; text-align: left">{{number_format($taxes->amount,2)}}</td>
    </tr>
    </tbody>


    <hr>
    <tr>
        <td colspan="7">{{strtoupper(NumerosEnLetras::convertir($taxes->amount))."."}}</td>
    </tr>
</table>
<table>
    <tr>
        <td style="font-size: 12px !important; text-align: center;">Planilla</td>
        <td style="font-size: 12px !important; text-align: center;">Dígito</td>
        <td style="font-size: 12px !important; text-align: center;">Correlat</td>
        <td style="font-size: 12px !important; text-align: center;">Contrib</td>
        <td style="font-size: 12px !important; text-align: center;">Monto</td>
        <td style="font-size: 12px !important; text-align: center;" rowspan="2"> ESTE DOCUMENTO VA SIN TACHADURA NI
            ENMENDADURA NO VALIDO COMO SOLVENCIA
        </td>
    </tr>

    <tr>
        <td style="font-size: 12px !important;text-align: center;">{{$taxes->code}}</td>
        <td style="font-size: 12px !important;text-align: center;">
            @if($taxes->digit)

                {{$taxes->digit}}

            @else
                {{"000"}}
            @endif
        </td>
        <td style="font-size: 12px !important;text-align: center;">{{substr($taxes->code,3,13)}}</td>
        <td style="font-size: 12px !important;text-align: center;">{{$vehicle[0]->license_plate}}</td>
        <td style="font-size: 12px !important;text-align: center;">{{number_format($taxes->amount,2)}}</td>
    </tr>
</table>

<table>
    <tr>
        <td colspan="3" style="font-size: 12px;">Nota: Una vez que se publiquen
            las tasas de interés moratorio correspondiente se procederá a cobrar
            el complemento de la misma, de conformidad con el articulo 66 Decreto
            con Rango Valor y Fuerza de Ley del Código Tributario.
        </td>
    </tr>
    <tr>
        <td></td>
    </tr>
    @if(!$firm)
        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">

                @if($taxes->bank==44)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BOD*****
                @elseif($taxes->bank==77)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BICENTENARIO*****
                @elseif($taxes->bank==99)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BNC*****
                @elseif($taxes->bank==33)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE 100%BANCO*****
                @elseif($taxes->bank==55)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BANESCO *****
                @else
                    ***** PLANILLA VALIDA PARA EL PAGO POR PUNTO DE VENTA *****<br> EN TAQUILLA DEL SEMAT <br>Torre
                    David Planta Baja Calle 26 entre Carreras 15 y 16
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">
                **ESTA PLANILLA ES VÁLIDA SOLO POR EL DIA: {{date("Y-m-d", strtotime($taxes->created_at))}}**
            </td>
        </tr>
    @endif
</table>


<?php
$num = 'CMD01-' . date('ymd');
$nom = 'DUPONT Alphonse';
$date = '31/12/' . date('Y');
?>


<div style="position: absolute; right: 3mm; bottom: 3mm; text-align: right; font-size: 4mm; ">
    <table style="width: 100%">
        <tr>
            <td style="width: 100%;"></td>
            <td style="width: 100%"></td>
            <td style="width: 100%;">


            </td>

        </tr>

    </table>
    <b></b> <b></b><br>
    <b></b><br>
    <b></b><br>


    <table style="width: 100%;margin-bottom:-30px;">
        <tr>

            @if($firm)

                <td style="width: 40%;text-align: center;">
                    <img src="{{asset('images/pdf/firma.png')}}" style="width:180px; height:80px;">

                </td>
            @else

                <td style="width: 40%;text-align: center;">
                    __________________________________________
                </td>

            @endif

        </tr>
        <tr>
            @if($firm)
                <td style="width:40%;text-align: center; font-size: 10px;">
                    FIRMA DEL GERENTE DE RECAUDACIÓN DEL SEMAT.<br> JURO QUE LOS DATOS EN ESTA
                    DECLARACIÓN HAN SIDO<br> DETERMINADOS CON BASE A LA
                    DISPOSICIONES<br> LEGALES CONTENIDAS EN LA O.I.A.E.
                </td>
            @else

                <td style="width:40%;text-align: center; font-size: 10px;">
                    FIRMA DEL CONTRIBUYENTE O REPRESENTANTE LEGAL<br> JURO QUE LOS DATOS EN ESTA
                    DECLARACIÓN HAN SIDO<br> DETERMINADOS CON BASE A LA
                    DISPOSICIONES<br> LEGALES CONTENIDAS EN LA O.I.A.E.
                </td>

            @endif
        </tr>
    </table>
    <table style="width: 100%;margin-bottom:-30px;">
        <tr>
            <td style="width: 80%;">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(170)->generate(\Illuminate\Support\Facades\Crypt::encrypt($taxes->id))) !!} "
                     style="float:left ;position: absolute;top: -10px;right: 800px !important;left: 900px;">
            </td>
        </tr>
        <tr>
            <td style="width: 20%;">
                @if($taxes->bank!=66)
                    <img src="https://sysprim.com/images/pdf/{{$taxes->bank.".png"}}"
                         style="width:180px; height:80px ;float: right;top: -120px; position: absolute;" alt="">
                @endif
            </td>
        </tr>
    </table>
</div>
</body>
</html>