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

        td.border{
            border: 1px solid black;!important;
            border-right:none;
            border-left:none;
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
                <img src="https://sysprim.com/images/alcaldia_logo.png" style="width:180px; height:80px" alt=""><br>
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
                <img src="https://sysprim.com/images/semat_logo.png" style="width:180px; height:80px" alt=""><br>

                <span style="font-size: 10px !important;">{{$taxes[0]->taxes->payments[0]->code}}</span><br>

                <span style="font-size: 10px !important;">{{$taxes[0]->taxes->created_at->format('d-m-Y')}}</span><br>
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

<h4 style="text-align:center">DEPOSITO TRIBUTARIA MUNICIPAL</h4>
<table style="width: 100%; border-collapse: collapse;">
    <tr style="">
        <td style="width:15%;font-size: 12px !important; "><b>Contribuyente:</b></td>

        <td style="width:35%;font-size: 11px !important;">{{$taxes[0]->taxes->companies[0]->name}}</td>
        <td style="width:20%;font-size: 12px !important;"><b>Codigo Catastral:</b></td>
        <td style="width:30%;font-size: 11px !important;">{{$taxes[0]->taxes->companies[0]->code_catastral}}</td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Cedula o RIF:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$taxes[0]->taxes->companies[0]->RIF}}</td>
        <td style="width:20%;font-size: 12px !important;"><b>Cód. Licencia:</b></td>
        <td style="width:30%;font-size: 11px !important">{{$taxes[0]->taxes->companies[0]->license}}</td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important"><b>Dirección:</b></td>
        <td style="width:35%;font-size: 11px !important">{{$taxes[0]->taxes->companies[0]->address}}</td>

        <td style="width:15%;font-size: 12px !important;"><b>Operador</b></td>
        <td style="width:35%;font-size: 11px !important;">{{\Auth::user()->email}}</td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Telf. Empresa:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$taxes[0]->taxes->companies[0]->phone}}</td>

    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Usuario Web:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$taxes[0]->taxes->companies[0]->users[0]->email}}</td>
        <td style="width:20%;font-size: 12px !important;"><b></b></td>
        <td style="width:30%;font-size: 11px !important;"></td>
    </tr>
</table>


<table style="width: 100%;">
    <thead>
    <tr style="border: 1px solid #000; !important;">
        <td style="width: 10%;font-size: 12px !important;" class="border">CIIU</td>
        <td style="width: 20%;font-size: 12px !important;" class="border">Descripción</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Ramo</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Lapso</td>
        <td style="width: 15%;font-size: 12px !important;" class="border">Planilla</td>
        <td style="width: 15%;font-size: 12px !important;" class="border">Monto o Benef/CF</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Neto</td>
    </thead>

    <tbody>

    @php
        $recargo=0;
        $interest=0;
        $amount_total=0;

    @endphp

    @foreach($taxes as $taxe)
        <tr>
            <td style="width: 10%;font-size: 10px !important;">{{$taxe->ciu->code}}</td>
            <td style="width: 30%;font-size: 8px;!important;">{{$taxe->ciu->name}}</td>
            <td style="width: 10%;font-size: 10px;!important">{{$taxe->taxes->branch}}</td>
            <td style="width: 10%;font-size: 10px; !important;">{{$taxe->taxes->fiscal_period}}</td>
            <td style="width: 15%;font-size: 10px;!important">{{substr($taxe->taxes->code,3,13)}}</td>
            <td style="width: 15%;font-size: 10px;!important">{{'0,0'}}</td>
            <td style="width: 10%;font-size: 10px;!important">{{number_format($taxe->totalCiiu,2)}}</td>
        </tr>
        @if($taxe->withholding!=0)
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">RETENCIÓN AL IMPUESTO DEL  PERÍODO FISCAL</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">{{number_format($taxe->withholding,2)}}</td>

            </tr>
        @endif

        @if($taxe->deductions!=0)
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">DEDUCCIONES</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">
                    {{number_format($taxe->deductions,2)}}
                </td>

            </tr>
        @endif
        @if($taxe->fiscal_credits!=0)
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">CRÉDITO FISCAL</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">{{number_format($taxe->fiscal_credits,2)}}</td>
                <td style="font-size: 10px !important;">
                    {{number_format($taxe->fiscal_credits,2)}}
                </td>
            </tr>
        @endif

        @php
            $recargo+=$taxe->tax_rate;
            $interest+=$taxe->interest;
            $amount_total+=$taxe->totalCiiu;
        @endphp

        @if($taxe->tax_rate!=0)

            <tr>
                <td style="width: 10%;font-size: 10px !important;">{{$taxe->ciu->code}}</td>
                <td style="font-size: 10px !important;">RECARGO</td>
                <td></td>

                <td style="width: 10%;font-size: 10px; !important;">{{$taxe->taxes->fiscal_period}}</td>
                <td style="width: 15%;font-size: 10px;!important">{{substr($taxe->taxes->code,3,13)}}</td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">{{number_format($taxe->tax_rate,2)}}</td>
            </tr>

            <tr>
                <td style="width: 10%;font-size: 10px !important;">{{$taxe->ciu->code}}</td>
                <td style="font-size: 10px !important;">INTERES</td>
                <td></td>
                <td style="width: 10%;font-size: 10px; !important;">{{$taxe->taxes->fiscal_period}}</td>
                <td style="width: 15%;font-size: 10px;!important">{{substr($taxe->taxes->code,3,13)}}</td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">{{number_format($taxe->interest,2)}}</td>
            </tr>
        @endif

        <tr>
            <td style="width: 10%;font-size: 10px !important;" colspan="7">_________________________________________________________________________________________________________________________________</td>

        </tr>

    @endforeach

    <tr>
        <td  style="font-size: 14px !important; text-align: right;" width="100" colspan="7">TOTAL:{{number_format($amount_total+$recargo+$interest,2)}}</td>
    </tr>
    </tbody>
    <hr>
    <tr>
        <td colspan="7" style="font-size: 13px;!important;">{{strtoupper(NumerosEnLetras::convertir($amount_total+$recargo+$interest))."."}}</td>
    </tr>
</table>
<table>



        <tr>
            <td style="font-size: 12px !important; text-align: center;">Planilla</td>
            <td style="font-size: 12px !important; text-align: center;">Dígito</td>
            <td style="font-size: 12px !important; text-align: center;">Correlat</td>
            <td style="font-size: 12px !important; text-align: center;">Contrib</td>
            <td style="font-size: 12px !important; text-align: center;">Monto</td>
            <td style="font-size: 12px !important; text-align: center;" rowspan="2"> ESTE DOCUMENTO VA SIN TACHADURA NI ENMENDADURA NO VALIDO COMO SOLVENCIA</td>
        </tr>


        <tr>
            <td style="font-size: 12px !important; text-align: center;">{{$taxes[0]->taxes->payments[0]->code}}</td>
            <td style="font-size: 12px !important; text-align: center;">{{$taxes[0]->taxes->payments[0]->digit}}</td>
            <td style="font-size: 12px !important; text-align: center;">{{substr($taxes[0]->taxes->payments[0]->code,3,13)}}</td>
            <td style="font-size: 12px !important; text-align: center;">{{$taxes[0]->taxes->companies[0]->license}}</td>
            <td style="font-size: 12px !important; text-align: center;">{{number_format($amount_total+$recargo+$interest,2)}}</td>
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




        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">
            </td>
        </tr>
        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">
            </td>
        </tr>


        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">

            </td>
        </tr>
        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">

            </td>
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
            <td style="width: 100%;"></td>
            <td style="width: 100%"></td>
            <td style="width: 100%;">



            </td>

        </tr>

    </table>
    <b></b>  <b></b><br>
    <b></b><br>
    <b></b><br>


    <table style="width: 100%;margin-bottom:-30px;">

            <tr>
                <td style="width: 40%;text-align: center;position: relative;">
                    <img src="http://sysprim.com.devel/images/pdf/firma-director.png" style="right: 2cm !important;left:7cm;top: -4cm; !important;position:absolute;width: 200px;height: 200px;" alt="">
                </td>
            </tr>
            <tr>
                <td style="text-align: center;font-size: 13px;position: relative;top: -5cm;" ><b>
                        __________________________________________<br>
                        ABG. YOLIBETH GRACIELA NELO HERNÁNDEZ<br>
                        Directora (E) de la Dirección de Hacienda y<br>
                        Gerenta General (E) del Servicio Municipal<br> de Administración Tributaria (SEMAT)<br>
                    </b>
                </td>
            </tr>

    </table>






    <table style="width: 100%;">

            <tr>
                <td style="width: 80%;">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(170)->generate($taxes[0]->taxes->fiscal_period)) !!} " >
                </td>
            </tr>


        <tr>
            <td style="width: 20%;">

            </td>
        </tr>
    </table>
</div>
</body>
</html>