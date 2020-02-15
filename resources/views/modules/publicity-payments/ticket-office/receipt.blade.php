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
                <img src="https://sysprim.com/images/alcaldia_logo.png" style="width:180px; height:80px" alt="Image" width="100%" height="100%"><br>
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
                <img src="https://sysprim.com/images/semat_logo.png" style="width:180px; height:80px" alt="Image" width="100%" height="100%"><br>


                @php $i=count($taxes[0]->payments); @endphp
                <span style="font-size: 10px !important;">{{$taxes[0]->payments[$i-1]->code}}</span><br>

                <span style="font-size: 10px !important;">{{$taxes[0]->created_at->format('d-m-Y')}}</span><br>

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

@if($taxes[0]->status==='verified'||$taxes[0]->status==='verified-sysprim')
    <h4 style="text-align:center">RECIBO DE PAGO VERIFICADO (PROPAGANDA Y PUBLICIDAD COMERCIAL)</h4>
@else
    <h4 style="text-align:center">DEPOSITO TRIBUTARIO MUNICIPAL(PROPAGANDA Y PUBLICIDAD COMERCIAL)</h4>
@endif
<table style="width: 100%; border-collapse: collapse;">
    <tr style="">
        <td style="width:15%;font-size: 12px !important; "><b>Contribuyente:</b></td>
        @if($type == 'user')
            <td style="width:35%;font-size: 11px !important;">{{ $data->name." ".$data->surname }}</td>
        @elseif($type == 'company')
            <td style="width:35%;font-size: 11px !important;">{{ $data->name }}</td>
        @endif

        {{--        @if($property->code_catastal)--}}
        <td style="width:20%;font-size: 12px !important;"><b>Codigo de Publicidad:</b></td>
        <td style="width:30%;font-size: 11px !important;">{{$publicity->code}}</td>

        {{--@else--}}
        {{--<td style="width:20%;font-size: 12px !important;"><b></b></td>--}}
        {{--<td style="width:30%;font-size: 11px !important;"></td>--}}
        {{--@endif--}}
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Cedula o RIF:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{$data->ci .''. $data->RIF}}</td>
        @if($data->license)
            <td style="width:20%;font-size: 12px !important;"><b>Cód. Licencia:</b></td>
            <td style="width:30%;font-size: 11px !important">{{$data->license}}</td>
            {{--@else
                <td style="width:20%;font-size: 12px !important;"><b></b></td>
                <td style="width:30%;font-size: 11px !important;"></td> --}}
        @endif
    </tr>

    <tr>
        <td style="width:15%;font-size: 12px !important"><b>Dirección:</b></td>
        <td style="width:35%;font-size: 11px !important">{{$data->address}}</td>

        <td style="width:15%;font-size: 12px !important;"><b>Pers. Responsable</b></td>
        <td style="width:35%;font-size: 11px !important;">{{ $publicity->users[0]->name. ' ' . $publicity->users[0]->surname }}</td>
    </tr>
    <tr>
        @if($data->phone)
            <td style="width:15%;font-size: 12px !important;"><b>Telf. Empresa:</b></td>
            <td style="width:35%;font-size: 11px !important;">{{"0".substr($data->phone,3,10)}}</td>
        @else
            <td style="width:15%;font-size: 12px !important;"><b></b></td>
            <td style="width:35%;font-size: 11px !important;"></td>
        @endif
    </tr>
    <tr>
        <td style="width:15%;font-size: 12px !important;"><b>Usuario Web:</b></td>
        <td style="width:35%;font-size: 11px !important;">{{ $publicity->users[0]->email }}</td>
        <td style="width:20%;font-size: 12px !important;"><b>Telf. Responsable</b></td>
        <td style="width:30%;font-size: 11px !important;">{{ $publicity->users[0]->phone }}</td>
    </tr>
</table>

<table style="width: 100%;">
    <thead>
    <tr style="border: 1px solid #000; !important;">
        {{--<td style="width: 10%;font-size: 12px !important;" class="border">Código</td>--}}
        <td style="width: 20%;font-size: 12px !important;" class="border">Descripción</td>
        <td style="width: 10%;font-size: 12px !important;" class="border"></td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Ramo</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Lapso</td>
        <td style="width: 15%;font-size: 12px !important;" class="border">Base Imponible</td>
        <td style="width: 15%;font-size: 12px !important;" class="border">Monto o Benef/CF</td>
        <td style="width: 10%;font-size: 12px !important;" class="border">Impuesto</td>
    </thead>

    <tbody>
    {{--@php $total_taxes=0;@endphp--}}
    {{--    @foreach($taxes->rateTaxes as $rate)--}}

    {{--@php dd($taxes); die(); @endphp--}}

    @php $totalAcum = 0; @endphp
    @foreach($taxes as $taxe)
        <tr>
            {{--<td style="width: 10%;font-size: 10px !important;">{{$taxes->code}}</td>--}}
            <td style="width: 30%;font-size: 10px;!important;">{{ strtoupper($taxe->publicities[0]->advertisingType->name) }}</td>
            <td style="width: 10%;font-size: 10px !important;"></td>
            <td style="width: 10%;font-size: 10px;!important">{{ $taxe->branch }}</td>
            <td style="width: 10%;font-size: 10px; !important;">{{Carbon\Carbon::parse($taxe->fiscal_period)->format('m-Y')."/".Carbon\Carbon::parse($taxe->fiscal_period_end)->format('m-Y')}}</td>
            <td style="width: 15%;font-size: 10px;!important">{{ $taxe->publicities[0]->advertisingType->value }}</td>
            <td style="width: 15%;font-size: 10px;!important"></td>
            <td style="width: 10%;font-size: 10px;!important">{{number_format($taxe->publicities[0]->pivot->base_imponible,2,',','.')}}</td>
        </tr>

        @php $totalAmount = $taxe->publicities[0]->pivot->base_imponible; @endphp

        {{--@if($taxe->properties[0]->pivot->interest != 0)
            <tr>
                <td style="width: 10%;font-size: 10px !important;"></td>
                <td style="width: 10%;font-size: 10px !important;text-align: right">Interés por Mora</td>
                <td style="width: 10%;font-size: 10px !important;"></td>
                <td style="width: 10%;font-size: 10px !important;"></td>
                <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
                <td style="width: 10%;font-size: 10px !important;">{{ number_format($taxe->properties[0]->pivot->interest,2,',','.') }}</td>
                @php $totalAmount += $taxe->properties[0]->pivot->interest; @endphp
                <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
            </tr>
        @endif--}}
        @if($taxe->publicities[0]->pivot->fiscal_credit != 0)
            <tr>
                <td style="width: 10%;font-size: 10px !important;"></td>
                <td style="width: 10%;font-size: 10px !important;text-align: right">Créditos Fiscales</td>
                <td style="width: 10%;font-size: 10px !important;"></td>
                <td style="width: 10%;font-size: 10px !important;"></td>
                <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
                <td style="width: 10%;font-size: 10px !important;">-{{ number_format($taxe->publicities[0]->pivot->fiscal_credit,2,',','.') }}</td>
                @php $totalAmount -= $taxe->publicities[0]->pivot->fiscal_credit; @endphp
                <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
            </tr>
        @endif
        <tr>
            <td style="width: 10%;font-size: 10px !important;" colspan="7">
                _________________________________________________________________________________________________________________________________
            </td>
        </tr>
        @php    $totalAcum += $totalAmount;
                $totalAmount = 0;
        @endphp
    @endforeach

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>TOTAL</td>
        <td style="font-size: 14px !important; text-align: left">{{number_format($totalAcum,2,',','.')}}</td>
    </tr>
    </tbody>


    <hr>
    <tr>
        <td colspan="7">{{strtoupper(NumerosEnLetras::convertir($totalAcum))."."}}</td>
    </tr>
</table>
<table>

    @if(!$taxes[0]->payments->isEmpty()&&substr($taxes[0]->payments[0]->code,0,3)!='PPV')
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
            <td style="font-size: 12px !important;text-align: center;">{{$taxes[0]->payments[0]->code}}</td>
            <td style="font-size: 12px !important;text-align: center;">{{$taxes[0]->payments[0]->digit}}</td>
            <td style="font-size: 12px !important;text-align: center;">{{substr($taxes[0]->payments[0]->code,3,13)}}</td>
            @if($type == 'user')
                <td style="font-size: 12px !important;text-align: center;">{{$data->ci}}</td>
            @else
                <td style="font-size: 12px !important;text-align: center;">{{$data->license}}</td>
            @endif
            <td style="font-size: 12px !important;text-align: center;">{{number_format($totalAcum,2,',','.')}}</td>
        </tr>

    @else

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
            <td style="font-size: 12px !important;text-align: center;"></td>
            <td style="font-size: 12px !important;text-align: center;">
            </td>
            <td style="font-size: 12px !important;text-align: center;"></td>
            <td style="font-size: 12px !important;text-align: center;"></td>
            <td style="font-size: 12px !important;text-align: center;"></td>
        </tr>
    @endif
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
        @if($taxes[0]->status!='verified'&&$taxes[0]->status!='verified-sysprim')
            <td style="width: 100%;text-align: center; font-size: 14px;">
                @if($taxes[0]->bank==44)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BOD*****
                @elseif($taxes[0]->bank==77)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BICENTENARIO*****
                @elseif($taxes[0]->bank==99)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BNC*****
                @elseif($taxes[0]->bank==33)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE 100%BANCO*****
                @elseif($taxes[0]->bank==55)
                    ***** SOLAMENTE PARA SER CANCELADA A TRAVÉS DE BANESCO *****
                @else
                    ***** PLANILLA VALIDA PARA EL PAGO POR PUNTO DE VENTA *****<br> EN TAQUILLA DEL SEMAT <br>Torre David Planta Baja Calle 26 entre Carreras 15 y 16
                @endif
            </td>
    </tr>
    <tr>
        <td style="width: 100%;text-align: center; font-size: 14px;">
            **ESTA PLANILLA ES VÁLIDA SOLO POR EL DIA: {{date("d-m-Y", strtotime($taxes[0]->created_at))}}**
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

            @if($taxes[0]->status==='verified'||$taxes[0]->status==='verified-sysprim')
                <td style="width: 80%;text-align: center;margin-bottom: -50px!important;">
                    <img src="https://sysprim.com/images/pdf/firma-director.png" style="width:180px; height:190px;" alt="Image" width="100%" height="100%">
                </td>
            @else
                <td style="width: 40%;text-align: center;">
                    __________________________________________
                </td>
            @endif

        </tr>
        <tr>
            @if($taxes[0]->status==='verified'||$taxes[0]->status==='verified-sysprim')
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

            @if($taxes->status[0]!='verified'&&$taxes[0]->status!='verified-sysprim')
                <td style="width: 80%;">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(170)->generate(\Illuminate\Support\Facades\Crypt::encrypt($taxes[0]->id))) !!} "
                         style="float:left ;position: absolute;top: -10px;right: 800px !important;left: 900px;" alt="Image">
                </td>
        @else

            <tr>
                <td style="width: 80%;">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(170)->generate($taxes[0]->fiscal_period.'-'.$taxes[0]->code.'-'.$taxes[0]->created_at)) !!} "
                         style="float:left ;position: absolute;top: 100px !important;right: 800px !important;left: 900px;" alt="Image">
                </td>
            </tr>

        @endif

        <tr>
            <td style="width: 20%;">
                @if($taxes[0]->status!='verified'&&$taxes[0]->status!='verified-sysprim')
                    @if($taxes[0]!=null)
                        <img src="https://sysprim.com/images/pdf/{{$taxes[0]->bank.".png"}}"
                             style="width:180px; height:100px ;float: right;top: -120px; position: absolute;" alt="Image">
                    @endif
                @endif
            </td>
        </tr>
    </table>
</div>
</body>
</html>