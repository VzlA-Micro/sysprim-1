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
                <img src="https://sysprim.com/images/alcaldia_logo.png" style="width:180px; height:80px" alt="Logo Semat" width="100%" height="100%"><br>
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
                <img src="https://sysprim.com/images/semat_logo.png" style="width:180px; height:80px" alt="Logo Semat" width="100%" height="100%"><br>
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

@if($taxes->status==='verified'||$taxes->status==='verified-sysprim')
    <h4 style="text-align:center">RECIBO DE PAGO VERIFICADO (DECLARACIÓN DEFINITIVA)</h4>
@else
    <h4 style="text-align:center">DEPOSITO TRIBUTARIO MUNICIPAL(DECLARACIÓN DEFINITIVA)</h4>
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
        <td style="width: 15%;font-size: 12px !important;" class="border">Base Imponible(Anual)</td>
        <td style="width: 15%;font-size: 12px !important;" class="border">Monto o Benef/CF</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Impuesto</td>
    </thead>

    <tbody>
    @php $total_taxes=0;@endphp
    @foreach($ciuTaxes as $ciu)



        <tr>
            <td style="width: 10%;font-size: 10px !important;">{{$ciu->ciu->code}}</td>
            <td style="width: 30%;font-size: 10px;!important;">{{$ciu->ciu->name}}</td>
            <td style="width: 10%;font-size: 10px;!important">{{$taxes->branch}}</td>
            <td style="width: 10%;font-size: 10px; !important;">{{\Carbon\Carbon::parse($taxes->fiscal_period)->format('Y')}}</td>
            <td style="width: 15%;font-size: 10px;!important">@php echo number_format($ciu->base, 2);@endphp</td>
            <td style="width: 15%;font-size: 10px;!important">{{($ciu->ciu->alicuota*100)."%"}}</td>
            <td style="width: 10%;font-size: 10px;!important">{{number_format($ciu->totalCiiuDefinitive,2)}}</td>
        </tr>

            <tr>
                <td></td>
                <td style="font-size: 10px !important;">IMPUESTO ANTICIPADO</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;">{{number_format($ciu->base_anticipated,2)}}</td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">
                    {{number_format($ciu->base_anticipated,2)}}
                </td>

            </tr>

        @if($ciu->interest!=0)
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">Recargo</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;">{{number_format($ciu->totalCiiu,2)}}</td>
                <td style="font-size: 10px !important;">{{number_format($ciu->recharge,2)}}</td>
                <td style="font-size: 10px !important;">{{number_format($ciu->totalCiiu+$ciu->recharge,2)}}</td>
            </tr>
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">Interés por mora</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;">{{number_format($ciu->totalCiiu+$ciu->recharge,2)}}</td>
                <td style="font-size: 10px !important;">{{number_format($ciu->interest,2)}}</td>
                <td style="font-size: 10px !important;">{{number_format($ciu->totalCiiu+$ciu->interest+$ciu->recharge,2)}}</td>
            </tr>

        @endif


    @endforeach

    @foreach($taxes->companies as $tax)

        @if($tax->pivot->fiscal_credits!=0)
            <tr>
                <td></td>
                <td style="font-size: 10px !important;">CRÉDITO FISCAL DETER.DEFINITIVA</td>
                <td></td>
                <td></td>
                <td style="font-size: 10px !important;"></td>
                <td style="font-size: 10px !important;">{{number_format($tax->pivot->fiscal_credits,2)}}</td>
                <td style="font-size: 10px !important;"></td>

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
        <td colspan="10">{{strtoupper(NumerosEnLetras::convertir(number_format($taxes->amount,2)))."."}}</td>
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
        <td style="font-size: 12px !important;text-align: center;">{{$taxes->companies[0]->license}}</td>
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





    @if(!$taxes->payments->isEmpty()&&substr($taxes->payments[0]->code,0,3)=='PPB')
        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">
                @if($taxes->payments[0]->payments->bank==44)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BOD*****
                @elseif($taxes->payments[0]->payments[0]->bank==77)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BICENTENARIO*****
                @elseif($taxes->payments[0]->payments[0]->bank==99)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BNC*****
                @elseif($taxes->payments[0]->payments[0]->bank==33)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE 100%BANCO*****
                @elseif($taxes->payments[0]->payments[0]->bank==55)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BANESCO *****
                @else
                    ***** PLANILLA VALIDA PARA EL PAGO POR PUNTO DE VENTA *****<br> EN TAQUILLA DEL SEMAT <br>Torre
                    David Planta Baja Calle 26 entre Carreras 15 y 16
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">
                **ESTA PLANILLA ES VÁLIDA SOLO POR EL DIA: {{date("Y-m-d", strtotime($taxes->taxes->created_at))}}**
            </td>
        </tr>

    @else
        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">
                @if($taxes->bank==44)
                    ***** PAGO REALIZADO A TRAVÉS DE PUNTO DE VENTA BOD*****
                @elseif($taxes->bank==77)
                    ***** PAGO REALIZADO A TRAVÉS DE PUNTO DE VENTA BICENTENARIO*****
                @elseif($taxes->bank==99)
                    ***** PAGO REALIZADO A TRAVÉS DE PUNTO DE VENTA BNC*****
                @elseif($taxes->bank==33)
                    ***** PAGO REALIZADO A TRAVÉS DE PUNTO DE VENTA 100%BANCO*****
                @elseif($taxes->bank==55)
                    ***** PAGO REALIZADO A TRAVÉS DE PUNTO DE VENTA BANESCO *****
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 100%;text-align: center; font-size: 14px;">

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

            @if($taxes->status==='verified' ||$taxes->status=='verified-sysprim')
                <td style="width: 80%;text-align: center;margin-bottom: -50px!important;">
                    <img src="http://sysprim.com/images/pdf/firma-director.png" style="width:180px; height:190px;" alt="Image">

                </td>
            @else
                <td style="width: 40%;text-align: center;">
                    __________________________________________
                </td>
            @endif

        </tr>
        <tr>
            @if($taxes->status==='verified' || $taxes->status=='verified-sysprim')
                <td style="width:40%;text-align: center; font-size: 10px;"><b>
                        __________________________________________<br>
                        ABG. YOLIBETH GRACIELA NELO HERNÁNDEZ<br>
                        Directora (E) de la Dirección de Hacienda y<br>
                        Gerenta General (E) del Servicio Municipal<br> de Administración Tributaria (SEMAT)<br>
                    </b>
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

            @if($taxes->status!='verified'&&$taxes->status!='verified-sysprim')
            <td style="width: 80%;">
                <img alt="Imagen Varias" width="100%" height="100%" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(170)->generate(\Illuminate\Support\Facades\Crypt::encrypt($taxes->id))) !!} "
                     style="float:left ;position: absolute;top: -10px;right: 800px !important;left: 900px;">
            </td>
            @else

            <tr>
                <td style="width: 80%;">
                    <img alt="Imagen Varias" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(170)->generate($taxes->fiscal_period.'-'.$taxes->code.'-'.$taxes->created_at)) !!} " style="float:left ;position: absolute;top: 100px !important;right: 800px !important;left: 900px;">
                </td>
            </tr>
            @endif

        <tr>
            <td style="width: 20%;">
                @if($taxes->status!='verified'&&$taxes->status!='verified-sysprim')
                    @if($taxes->bank!=null)
                        <img src="https://sysprim.com/images/pdf/{{$taxes->bank.".png"}}"
                             style="width:180px; height:100px ;float: right;top: -120px; position: absolute;" alt="Imagen Varias" width="100%" height="100%">
                    @endif
				@endif
            </td>
        </tr>
    </table>
</div>
</body>
</html>