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
    <h4 style="text-align:center">CALCULO DE DEPOSITO TRIBUTARIO MUNICIPAL</h4>
@endif
<table style="width: 100%; border-collapse: collapse;">
    <tr style="">
        <td style="width:15%;font-size: 12px !important; "><b>Contribuyente:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$taxes->companies[0]->name}}</td>
        <td style="width:20%;font-size: 12px !important;"><b>Codigo Catastral:</b></td>
        <td style="width:30%;font-size: 11px !important;">{{$taxes->companies[0]->code_catastral}}</td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Cedula o RIF:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$taxes->companies[0]->RIF}}</td>
        <td style="width:20%;font-size: 12px !important;"><b>Cód. Licencia:</b></td>
        <td style="width:30%;font-size: 11px !important">{{$taxes->companies[0]->license}}</td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important"><b>Dirección:</b></td>
        <td style="width:35%;font-size: 11px !important">{{$taxes->companies[0]->address}}</td>

        <td style="width:15%;font-size: 12px !important;"><b></b></td>
        <td style="width:35%;font-size: 11px !important;"></td>
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Telf. Empresa:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{"0".substr($taxes->companies[0]->phone,3,10)}}</td>

    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Usuario Web:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{ $taxes->companies[0]->users[0]->email }}</td>
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
        <td style="width: 15%;font-size: 12px !important;" class="border">Base Imponible</td>
        <td style="width: 15%;font-size: 12px !important;" class="border">Monto o Benef/CF</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Impuesto</td>
    </thead>

    <tbody>
    @php $total_taxes=0;@endphp
    @foreach($ciuTaxes as $ciu)
        @php
            /*	if($ciu->pivot->base!=0&&$ciu->pivot->interest!=0){
                $taxe=$ciu->pivot->base*$ciu->alicuota/100;
               $surchange_total=$ciu->pivot->tax_rate+$taxe;
               $interest_total=$surchange_total+$ciu->pivot->interest;
               $total_taxes+=$surchange_total+$ciu->pivot->mora;
                }else{
                   $taxe=$ciu->pivot->unid_tribu*$ciu->min_tribu_men;
                   $surchange_total=0;
                 $total_taxes+=$taxe;
                }*/
        @endphp





        <tr>
            <td style="width: 10%;font-size: 10px !important;">{{$ciu->ciu->code}}</td>
            <td style="width: 30%;font-size: 10px;!important;">{{$ciu->ciu->name}}</td>
            <td style="width: 10%;font-size: 10px;!important">{{$taxes->branch}}</td>
            <td style="width: 10%;font-size: 10px; !important;">{{\Carbon\Carbon::parse($taxes->fiscal_period)->format('d-m-Y')}}</td>
            <td style="width: 15%;font-size: 10px;!important">@php echo number_format($ciu->base, 2);@endphp</td>
            <td style="width: 15%;font-size: 10px;!important">{{($ciu->ciu->alicuota*100)."%"}}</td>
            <td style="width: 10%;font-size: 10px;!important">{{number_format($ciu->totalCiiu,2)}}</td>
        </tr>



        @if($ciu->interest!=0)
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">Recargo</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;">{{number_format($ciu->totalCiiu,2)}}</td>
                <td style="font-size: 10px !important;">{{number_format($ciu->tax_rate,2)}}</td>
                <td style="font-size: 10px !important;">{{number_format($ciu->totalCiiu+$ciu->tax_rate,2)}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">Interés por mora</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;">{{number_format($ciu->totalCiiu+$ciu->tax_rate,2)}}</td>
                <td style="font-size: 10px !important;">{{number_format($ciu->interest,2)}}</td>
                <td style="font-size: 10px !important;">{{number_format($ciu->totalCiiu+$ciu->tax_rate+$ciu->interest,2)}}</td>
            </tr>

        @endif


        @if($ciu->withholding!=0)
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">Retención al Impuesto del Período Fiscal</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">{{number_format($ciu->withholding,2)}}</td>
                @if($taxes->companies[0]->typeCompany=='R')
                    <td style="font-size: 10px !important;">
                        {{number_format($ciu->totalCiiu+$ciu->tax_rate+$ciu->interest+$ciu->withholding,2)}}
                    </td>
                @else
                    <td style="font-size: 10px !important;">
                        {{number_format($ciu->totalCiiu+$ciu->tax_rate+$ciu->interest-$ciu->withholding,2)}}
                    </td>
                @endif
            </tr>
        @endif

        @if($ciu->deductions!=0)
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">Deducciones</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">{{number_format($ciu->deductions,2)}}</td>
                @if($taxes->companies->typeCompany=='R')
                    <td style="font-size: 10px !important;">
                        {{number_format($ciu->totalCiiu+$ciu->tax_rate+$ciu->interest+$ciu->withholding-$ciu->deductions,2)}}
                    </td>
                @else
                    <td style="font-size: 10px !important;">
                        {{number_format($ciu->totalCiiu+$ciu->tax_rate+$ciu->interest-$ciu->withholding-$ciu->deductions,2)}}
                    </td>
                @endif
            </tr>
        @endif

        @if($ciu->fiscal_credits!=0)
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">Crédito Fiscal</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">{{number_format($ciu->fiscal_credits,2)}}</td>
                @if($taxes->companies[0]->typeCompany=='R')
                    <td style="font-size: 10px !important;">
                        {{number_format($ciu->totalCiiu+$ciu->tax_rate+$ciu->interest+$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits,2)}}
                    </td>
                @else
                    <td style="font-size: 10px !important;">
                        {{number_format($ciu->totalCiiu+$ciu->tax_rate+$ciu->interest-$ciu->withholding-$ciu->deductions-$ciu->fiscal_credits,2)}}
                    </td>
                @endif
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
        <td style="font-size: 14px !important; text-align: left">{{number_format($taxes->amount,2)}}</td>
    </tr>
    </tbody>


    <hr>
    <tr>
        <td colspan="7">{{strtoupper(NumerosEnLetras::convertir($taxes->amount))."."}}</td>
    </tr>
</table>
<table>
    <!--<tr>
        <td style="font-size: 12px !important; text-align: center;">Planilla</td>
        <td style="font-size: 12px !important; text-align: center;">Dígito</td>
        <td style="font-size: 12px !important; text-align: center;">Correlat</td>
        <td style="font-size: 12px !important; text-align: center;">Contrib</td>
        <td style="font-size: 12px !important; text-align: center;">Monto</td>
        <td style="font-size: 12px !important; text-align: center;" rowspan="2"> ESTE DOCUMENTO VA SIN TACHADURA NI ENMENDADURA NO VALIDO COMO SOLVENCIA</td>
    </tr>
    -->

    <tr>
    <!--<tr>

        <td style="font-size: 12px !important;text-align: center;">{{$taxes->code}}</td>
        <td style="font-size: 12px !important;text-align: center;">

        </td>
        <td style="font-size: 12px !important;text-align: center;">{{substr($taxes->code,3,13)}}</td>
        <td style="font-size: 12px !important;text-align: center;">{{$taxes->companies[0]->license}}</td>
        <td style="font-size: 12px !important;text-align: center;">{{number_format($taxes->amount,2)}}</td>
        </tr>
    -->
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


            </td>
        </tr>
        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">
                **ESTA PLANILLA NO TIENE VALIDEZ ALGUNA.**
            </td>
        </tr>
    @endif
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






                <td style="width: 40%;text-align: center;">

                </td>



        </tr>
        <tr>

        </tr>
    </table>
    <table style="width: 100%;margin-bottom:-30px;">
        <tr>
            <td style="width: 80%;">

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