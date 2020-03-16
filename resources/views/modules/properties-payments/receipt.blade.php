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
                        <img src="{{ url('images/alcaldia_logo.png') }}" style="width:180px; height:80px" alt="Logo Semat" width="100%" height="100%"><br>
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
                        <img src="{{ url('images/semat_logo.png') }}" style="width:180px; height:80px" alt="Logo Semat" width="100%" height="100%"><br>
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
            <h4 style="text-align:center">RECIBO DE PAGO VERIFICADO (INMUEBLES URBANOS)</h4>
        @else
            <h4 style="text-align:center">DEPOSITO TRIBUTARIO MUNICIPAL(INMUEBLES URBANOS)</h4>
        @endif
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="">
                <td style="width:15%;font-size: 12px !important; "><b>Contribuyente:</b></td>

                <td style="width:35%;font-size: 11px !important;">{{ $data->name." ".$data->surname }}</td>


        {{--        @if($property->code_catastal)--}}
        <td style="width:20%;font-size: 12px !important;"><b>Codigo Catastral:</b></td>
        <td style="width:30%;font-size: 11px !important;">{{$property->code_cadastral}}</td>

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
        <td style="width:35%;font-size: 11px !important;">{{ $property->users[0]->name. ' ' . $property->users[0]->surname }}</td>
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
        <td style="width:35%;font-size: 11px !important;">{{ $property->users[0]->email }}</td>
        <td style="width:20%;font-size: 12px !important;"><b>Telf. Responsable</b></td>
        <td style="width:30%;font-size: 11px !important;">{{ $property->users[0]->phone }}</td>
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


    @foreach($propertyBuildings as $propertyBuilding)
        @if($propertyBuilding->buildingValue->id == 1 || $propertyBuilding->buildingValue->name == 'NINGUNA')
            @if($property->type->id == 2 || $property->type->id == 3)
                <tr>
                    {{--<td style="width: 10%;font-size: 10px !important;">{{$taxes->code}}</td>--}}
                    <td style="width: 30%;font-size: 10px;!important;">{{ $property->type->name }}</td>
                    <td style="width: 10%;font-size: 10px !important;"></td>

                    <td style="width: 10%;font-size: 10px;!important">{{$taxes->branch}}</td>
                    <td style="width: 10%;font-size: 10px; !important;">{{\Carbon\Carbon::parse($taxes->fiscal_period)->format('d-m-Y')}}</td>
                    <td style="width: 15%;font-size: 10px;!important"></td>
                    <td style="width: 10%;font-size: 10px;!important">{{--{{number_format($propertyTaxes->base_imponible,2,',','.')}}--}}</td>
                    <td style="width: 15%;font-size: 10px;!important">{{ number_format($propertyTaxes->terrain_amount,2,',','.') }}</td>
                </tr>
            @endif
        @else{{--if ($property->type->name == 1 || $property->type->name == 4)--}}
            {{--@if($property->type->name == 1 || $property->type->name == 4)
            <tr>
                <td style="width: 30%;font-size: 10px;!important;">{{ $property->type->name }}</td>
                <td style="width: 10%;font-size: 10px !important;"></td>

                <td style="width: 10%;font-size: 10px;!important">{{$taxes->branch}}</td>
                <td style="width: 10%;font-size: 10px; !important;">{{\Carbon\Carbon::parse($taxes->fiscal_period)->format('d-m-Y')}}</td>
                <td style="width: 15%;font-size: 10px;!important"></td>
                <td style="width: 10%;font-size: 10px;!important">--}}{{--{{number_format($propertyTaxes->base_imponible,2,',','.')}}--}}{{--</td>
                <td style="width: 15%;font-size: 10px;!important">{{ number_format($propertyTaxes->build_amount,2,',','.') }}</td>
            </tr>
            @endif--}}
        <tr>
            {{--<td style="width: 10%;font-size: 10px !important;">{{$taxes->code}}</td>--}}
            <td style="width: 30%;font-size: 10px;!important;">{{ $propertyBuilding->buildingValue->name }}</td>
            <td style="width: 10%;font-size: 10px !important;"></td>

            <td style="width: 10%;font-size: 10px;!important">{{$taxes->branch}}</td>
            <td style="width: 10%;font-size: 10px; !important;">{{\Carbon\Carbon::parse($taxes->fiscal_period)->format('d-m-Y')}}</td>
            <td style="width: 15%;font-size: 10px;!important"></td>
            <td style="width: 10%;font-size: 10px;!important">{{--{{number_format($propertyTaxes->base_imponible,2,',','.')}}--}}</td>
            <td style="width: 15%;font-size: 10px;!important">{{ number_format($propertyBuilding->buildingValue->timelineValue[0]->value,2,',','.') }}</td>
        </tr>
        @endif
    @endforeach




    @php $totalAmount = $propertyTaxes->base_imponible; @endphp
    {{--<tr>
        <td style="width: 10%;font-size: 10px !important;text-align: right">Alicuota</td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($propertyTaxes->alicuota,2,',','.') }}</td>
        @php $totalAmount += $propertyTaxes->alicuota @endphp
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
    </tr>--}}
    @if($propertyTaxes->terrain_amount != 0)
        <tr>
            <td style="width: 10%;font-size: 10px !important;text-align: right">Valor del Terreno</td>
            <td style="width: 10%;font-size: 10px !important;"></td>
            <td style="width: 10%;font-size: 10px;!important">{{--{{$taxes->branch}}--}}</td>
            <td style="width: 10%;font-size: 10px; !important;">{{--{{\Carbon\Carbon::parse($taxes->fiscal_period)->format('d-m-Y')}}--}}</td>
            <td style="width: 10%;font-size: 10px !important;">{{ number_format($propertyTaxes->terrain_amount,2,',','.') }}</td>
            <td style="width: 10%;font-size: 10px !important;"></td>
            {{--@php $totalAmount += $propertyTaxes->recharge; @endphp--}}
            <td style="width: 10%;font-size: 10px !important;">{{ number_format($propertyTaxes->terrain_amount,2,',','.') }}</td>
        </tr>
    @endif
    @if($propertyTaxes->build_amount != 0)
        <tr>
            <td style="width: 10%;font-size: 10px !important;text-align: right">Valor de la Construcción</td>
            <td style="width: 10%;font-size: 10px !important;"></td>
            <td style="width: 10%;font-size: 10px;!important">{{--{{$taxes->branch}}--}}</td>
            <td style="width: 10%;font-size: 10px; !important;">{{--{{\Carbon\Carbon::parse($taxes->fiscal_period)->format('d-m-Y')}}--}}</td>
            <td style="width: 10%;font-size: 10px !important;">{{ number_format($propertyTaxes->build_amount,2,',','.') }}</td>
            <td style="width: 10%;font-size: 10px !important;"></td>
            {{--@php $totalAmount += $propertyTaxes->recharge; @endphp--}}
            <td style="width: 10%;font-size: 10px !important;">{{ number_format($propertyTaxes->build_amount,2,',','.') }}</td>
        </tr>
    @endif

    @if($propertyTaxes->recharge != 0)
    <tr>
        <td style="width: 10%;font-size: 10px !important;text-align: right">Recargos</td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($propertyTaxes->recharge,2,',','.') }}</td>
        @php $totalAmount += $propertyTaxes->recharge; @endphp
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
    </tr>
    @endif
    @if($propertyTaxes->interest != 0)
    <tr>
        <td style="width: 10%;font-size: 10px !important;text-align: right">Interés por Mora</td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($propertyTaxes->interest,2,',','.') }}</td>
        @php $totalAmount += $propertyTaxes->interest; @endphp
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
    </tr>
    @endif
    @if($propertyTaxes->discount != 0)
    <tr>
        <td style="width: 10%;font-size: 10px !important;text-align: right">Descuento: 20%</td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
        <td style="width: 10%;font-size: 10px !important;">-{{ number_format($propertyTaxes->discount,2,',','.') }}</td>
        @php $totalAmount -= $propertyTaxes->discount; @endphp
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
    </tr>
    @endif
    @if($propertyTaxes->fiscal_credit != 0)
    <tr>
        <td style="width: 10%;font-size: 10px !important;text-align: right">Créditos Fiscales</td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;"></td>
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
        <td style="width: 10%;font-size: 10px !important;">-{{ number_format($propertyTaxes->fiscal_credit,2,',','.') }}</td>
        @php $totalAmount -= $propertyTaxes->fiscal_credit; @endphp
        <td style="width: 10%;font-size: 10px !important;">{{ number_format($totalAmount,2,',','.') }}</td>
    </tr>
    @endif
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>TOTAL</td>
        <td style="font-size: 14px !important; text-align: left">{{number_format($taxes->amount,2,',','.')}}</td>
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
        @if($type == 'user')
            <td style="font-size: 12px !important;text-align: center;">{{$data->ci}}</td>
        @else
            <td style="font-size: 12px !important;text-align: center;">{{$data->license}}</td>
        @endif
        <td style="font-size: 12px !important;text-align: center;">{{number_format($taxes->amount,2,',','.')}}</td>
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
        @if($taxes->status!='verified'&&$taxes->status!='verified-sysprim')
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
                    ***** PLANILLA VALIDA PARA EL PAGO POR PUNTO DE VENTA *****<br> EN TAQUILLA DEL SEMAT <br>Torre David Planta Baja Calle 26 entre Carreras 15 y 16
                @endif
            </td>
    </tr>
    <tr>
        <td style="width: 100%;text-align: center; font-size: 14px;">
            **ESTA PLANILLA ES VÁLIDA SOLO POR EL DIA: {{date("d-m-Y", strtotime($taxes->created_at))}}**
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

            @if($taxes->status==='verified'||$taxes->status==='verified-sysprim')
                <td style="width: 80%;text-align: center;margin-bottom: -50px!important;">
                    <img src="{{ url("images/pdf/firma-director.png") }}" style="width:180px; height:190px;" alt="Image" width="100%" height="100%">
                </td>
            @else
                <td style="width: 40%;text-align: center;">
                    __________________________________________
                </td>
            @endif

        </tr>
        <tr>
            @if($taxes->status==='verified'||$taxes->status==='verified-sysprim')
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
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->errorCorrection('H')->size(170)->generate(\Illuminate\Support\Facades\Crypt::encrypt($taxes->id))) !!}"
                         style="float:left ;position: absolute;top: -10px;right: 800px !important;left: 900px;" alt="Image">
                </td>
        @else

            <tr>
                <td style="width: 20%;">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->errorCorrection('H')->merge('/public/images/pdf/sysprim.png', .18)->size(170)->generate(
                      "CODIGO:".$taxes->code."\n".
                      "PERIODO FISCAL:".$taxes->fiscal_period."\n".
                      "RAMO:".$taxes->branch."\n".
                      "ESTADO:".$taxes->statusName."\n".
                      "MONTO:".number_format($taxes->amount,2)."\n".
                      'FECHA DE PAGO:'.$taxes->created_at."\n")) !!} "
                         style="float:left ;position: absolute;top: 100px !important;right: 800px !important;left: 900px; height: 180px !important;width: 180px !important;" alt="Image" >
                </td>
            </tr>

        @endif
        <tr>
            <td style="width: 20%;">
                @if($taxes->status!='verified'&&$taxes->status!='verified-sysprim')
                    @if($taxes->bank!=null)
                        <img src="{{ url("images/pdf/$taxes->bank.png") }}"
                             style="width:180px; height:100px ;float: right;top: -120px; position: absolute;" alt="Image">
                    @endif

               @elseif(isset($taxes->payments)&&$taxes->payments[0]->bank_name=='BANCO VENEZUELA'&&$taxes->payments[0]->status=='verified')
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->errorCorrection('H')->merge('/public/images/pdf/isotipo.png', .2)->size(170)->generate(
                    'CODIGO:'.$taxes->payments[0]->code."\n".
                    'REF:'.$taxes->payments[0]->ref."\n".
                    'MONTO:'.number_format($taxes->payments[0]->amount,2)."\n".
                    'DESCRIPCIÓN:'.$taxes->payments[0]->description."\n".
                    'TEL:'.$taxes->payments[0]->phone."\n".
                    'FECHA:'.$taxes->payments[0]->created_at."\n"
                     ));  !!} " style="float:right ;position: absolute;top: 100px !important;right: 800px !important;left: 900px;  height: 162px!important;width: 162px !important;" alt="Image" >
                @endif
            </td>
        </tr>
    </table>
</div>
</body>
</html>