<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 3cm 1cm 0.51cm;
        }

        html {
            margin: 0 0px !important;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            font-weight: bold;
            color: #000;
            text-align: center;
            line-height: 30px;
        }

        .page-break {
            page-break-after: always;
        }


    </style>
</head>
<body marginwidth="0" marginheight="0">
<header>
    <table style="width: 100%; border-collapse: collapse;">
        <tr style="text-align: center">
            <td style="width: 20%;" rowspan="2">
                <img src="https://sysprim.com/images/alcaldia_logo.png" style="width:120px; height:80px" alt=""><br>
                <span></span><br>
                <span style="font-size: 5px;"></span>
                <br>
            </td>
            <td style="width: 60%;text-align: center;font-size: 10px !important;" rowspan="2">
                <b>
                <span style="font-size: 16px !important;">
					República Bolivariana de Venezuela <br>
					Alcaldía Bolivariana del Municipio Iribarren<br>
					Barquisimeto - Edo. Lara
                </span>
                </b>
            </td>
            <td style="width: 20%;" rowspan="2">
                <img src="https://sysprim.com/images/semat_logo.png" style="width:120px; height:80px" alt=""><br>
                <span style="font-size: 10px !important;"></span><br>
                <span style="font-size: 10px !important;"></span><br>

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
</header>

<main>
    <table style="width: 100%; border-collapse: collapse;margin:10px!important; font-size: 15px !important;">
        <tr style="">
            <td><b>Ciudadano (a): {{$company->name}}</b></td>
        </tr>
        <tr>
            <td><b>Dirección: {{$company->address}}</b></td>
        </tr>
        <tr>
            <td><b>Ciudad:</b></td>
        </tr>
    </table>
    <p style="text-align: justify;font-size: 15px;width: 100%!important;">
        Se le notifica que de conformidad con los
        artículos 171 y 172 del Decreto con Rango, Valor y Fuerza de Ley del
        Orgánico Tributario, la ciudadana <b>Abogada YOLIBETH GRACIELA NELO HERNÁNDEZ</b>,
        titular de la cédula de identidad N° V-14.877.484, en su carácter de Directora (E)
        de la Dirección de Hacienda de la Alcaldía del Municipio Iribarren y Gerenta General (E) del Servicio Municipal
        de Administración Tributaria (SEMAT), según Resolución N° RRHHAL-091-2018, de fecha 22 de noviembre de 2018 y
        publicada en Gaceta Municipal Extraordinaria Nº 4566, de fecha 23/11/2018, y conforme a lo establecido en el
        numeral 19 del artículo 12 del Decreto Nº 40-2016, publicado en la Gaceta Municipal Ordinaria Nº 118, de fecha
        06/06/2016, dictó la Resolución Nº MV-NI-01-2019, de fecha de 26 de junio de 2019, en
        la cual se Resolvió imponer multa de <b>{{strtoupper(NumerosEnLetras::convertir($fines[0]->cant_unid_tribu))}} UNIDADES
            TRIBUTARIAS</b> equivalentes
        a la cantidad de <b> {{strtoupper(NumerosEnLetras::convertir($fines[0]->pivot->unid_tribu_value*$fines[0]->cant_unid_tribu))}} BOLIVARES SOBERANOS SIN CENTIMOS (Bs.{{$fines[0]->pivot->unid_tribu_value*$fines[0]->cant_unid_tribu }}),
        por concepto por no inscribir el vehículo en el lapso correspondiente, monto este que se expresa
        en unidades tributarias, y se utilizará el valor de la unidad tributaria vigentepara el momento
        del pago de conformidad al Parágrafo Primero del artículo 91 del Decreto con Rango, Valor y Fuerza de
        Ley del Código Orgánico Tributario vigente</b>  . A los efectos legales se anexa el texto íntegro de la
        Resolución contentiva Dos (02) folios útiles a la presente. Igualmente se hace del conocimiento, en caso
        de considerar lesionados sus derechos e intereses por la presente Resolución, podrá optar entre interponer
        alguno
        de los dos recursos que se señalan a continuación. a) El Recurso Jerárquico, previsto en los artículos 242 y 244
        del
        Código Orgánico Tributario, el cual será decidido por el ciudadano Alcalde, deberá ser presentado por ante el
        Servicio
        Municipal de Administración Tributaria (SEMAT), en la Gerencia de Información, Asistencia y Divulgación
        Tributaria,
        ubicada en la Calle 26 entre Carreras 15 y 16, Torre David, Nivel Semi-Sótano, Barquisimeto-Estado Lara, dentro
        de los
        Veinticinco (25) días hábiles siguientes a la presente notificación. b) Interponer el Recurso Contencioso
        Tributario
        por ante el Tribunal Superior de lo Contencioso Tributario de la Región Centro Occidental, el cual se encuentra
        situado
        en el Tercer Piso del Palacio de Justicia (antiguo Edificio Nacional), ubicado en la Carrera 17 entre Calles 24
        y 25 de
        esta ciudad de Barquisimeto conforme a los artículos 193, 259 y 261 del Código Orgánico Tributario dentro de los
        Veinticinco
        (25) días hábiles siguientes a la notificación. En ambos casos los lapsos se inician con la notificación del
        presente acto.
        De igual manera se le informa que podrá ejercer los mencionados recursos de forma subsidiaria, es decir
        ejerciendo el
        Recurso Jerárquico arriba referido y señalando de forma expresa en el texto que lo contiene, que en caso que las
        resultas
        del mismo conllevasen a una expresa denegación total o parcial, o denegación tácita, usted tiene la intención de
        ejercer
        el Recurso ContenciosoTributario, todo ello a tenor de lo dispuesto en el Parágrafo Primero del artículo 259 del
        Código
        Orgánico Tributario.
    </p>
    <table style="width:100%!important; border-collapse: collapse;margin-top: -1.5cm;">
        <tr>
            <td style="width: 20%;" rowspan="2">

            </td>
            <td style="width: 60%">
                <img src="http://sysprim.com.devel/images/pdf/firma-director.png" style="width:150px; height:120px;margin: 0;" alt="">
            </td>
            <td style="width: 20%;" rowspan="2">
            </td>
        </tr>
        <tr style="width: 100%!important;">
            <td style="text-align: center;font-size: 15px" ><b>ABG. YOLIBETH GRACIELA NELO HERNÁNDEZ<br>
                Directora (E) de la Dirección de Hacienda y
                Gerenta General (E) del Servicio Municipal de Administración Tributaria (SEMAT)<br>
                N° RRHHAL-091-2018, de fecha 22 de noviembre de 2018 y publicada en GME<br>
                Nº 4566, de fecha 23/11/2018</b>
            </td>
        </tr>
    </table>

    <p style="text-align: center;"><b> NOTIFICACIÓN</b></p>
    <table style="width:100%!important; border-collapse: collapse;font-size: 14px;">
        <tr>
            <td style="width: 40%;">
               <b> NOMBRE DEL RECEPTOR:</b>
            </td>
            <td>
                <b> __________________________________________________</b>
            </td>
        </tr>
        <tr>
            <td style="width: 40%;">
                <b>CEDULA DE IDENTIDAD:</b>
            </td>
            <td>
                <b> __________________________________________________</b>
            </td>
        </tr>
        <tr>
            <td style="width: 40%;" >
                <b>FECHA DE RECIBO:</b>
            </td>
            <td>
                <b> ______________HORA:__________TLF________________</b>
            </td>
        </tr>
        <tr>
            <td style="width: 40%;">
                <b>CORREO ELECTRONICO:</b>
            </td>
            <td>
                __________________________________________________
            </td>
        </tr>
        <tr>
            <td style="width: 40%;">
                <b>FIRMA:</b>
            </td>
            <td>
                ___________ <b>CEL: __________________________________</b>
            </td>

        </tr>

    </table>
    <table style="padding: 0;margin: 0">
        <tr>
            <td style="width: 60%;" colspan="2">
               <b> NOTA: Deberá ser firmada por el Representante Legal de la empresa.</b>
            </td>
        </tr>
    </table>




</main>
<div class="page-break"></div>


<p style="text-align: center;"><b>RESOLUCION Nº  MV-NI-06-2019</b></p>


<p style="text-align: justify;">
    Quien suscribe, la Abogada YOLIBETH GRACIELA NELO HERNÁNDEZ,
    titular de la cédula de identidad N° V-14.877.484,
    en su carácter de Directora (E)  de la Dirección de Hacienda
    de la Alcaldía del Municipio Iribarren y Gerenta General (E) del
    Servicio Municipal de Administración Tributaria (SEMAT), según Resolución
    N° RRHHAL-091-2018, de fecha 22 de noviembre de 2018 y publicada en
    Gaceta Municipal Extraordinaria Nº 4566, de fecha 23/11/2018, en uso
    de las atribuciones establecidas en los artículos 16, 17, 21 y 51 de la
    Ordenanza de Impuesto sobre Vehículos,  publicada en la Gaceta Extraordinaria Nº
    4576, de fecha 14 de diciembre de 2018, en concordancia con lo previsto en los numerales 1, 2, 7y 15 del Artículo 12 del Decreto N° 40-2016, publicado en la Gaceta Municipal Ordinaria Nº 118 fecha 06 de junio de 2016, dicta la siguiente resolución:

</p>




<p style="text-align: center;"><b>CONSIDERANDO 1</b></p>


<p style="text-align: justify;">
    Que de acuerdo a la verificación del cumplimiento de los
    deberes formales realizada al contribuyente: {{$company->name}}
    en su carácter de propietario (a) del vehículo identificado con la placa: IAO82S,
    quien tiene domicilio en la jurisdicción del municipio Iribarren en {{$company->address}}.
    Barquisimeto, se determinó que  no realizó la inscripción de vehículo en el lapso correspondiente,
    contraviniendo lo establecido en el artículo 16 de la Ordenanza de Impuesto sobre Vehículos,
    publicada en la Gaceta Extraordinaria Nº  4576, de fecha 14 de diciembre de 2018, que consagra lo siguiente:
    ARTÍCULO 16: La inscripción de vehículo en el Registro de Vehículo deberá hacerse dentro de los treinta (30) días continuos siguientes a la fecha de adquisición del mismo, a la del establecimiento de la residencia o domicilio en el Municipio Iribarren o a la de haberse dado uno de los supuestos previsto en el Artículo 7.


</p>


<p style="text-align: center;"><b>CONSIDERANDO 2</b></p>


<p style="text-align: justify;">
    Que el artículo 51 de la ordenanza in comento, prevé:

    ARTÍCULO 51: “Serán sancionados en la forma prevista en este artículo:

    4.	Quienes no inscribieren los vehículos dentro del lapso previsto en el artículo 16, con multa de ciento cincuenta Unidades Tributarias Municipal de Iribarren. (150 U.T.M.I.)…”
</p>



<p style="text-align: center;"><b>CONSIDERANDO 2</b></p>


<p style="text-align: justify;">
    CONSIDERANDO 2
    Que el Decreto con Rango, Valor y
    Fuerza de Ley del Código Orgánico Tributario vigente, en su artículo 91 Parágrafo Primero, señala lo siguiente:

    Artículo 91: “Cuando las multas establecidas en este Código
    estén expresadas en unidades tributarias (U.T.), se utilizará el valor de la unidad tributaria que estuviere vigente para el momento del pago.”


</p>



<p style="text-align: center;"><b>CONSIDERANDO 4</b></p>


<p style="text-align: justify;">

    Que en fecha 21 de noviembre de 2018,
    se pública en Gaceta Municipal Extraordinaria N° 4564,
    ordenanza mediante la cual se crea la Unidad Tributaria Municipal
    de Iribarren y de conformidad con el Decreto N° 17-2019, publicado en Gaceta Municipal
    Extraordinaria N° 4.608 de fecha 14 de mayo de 2019, se fija el valor de la Unidad Tributaria
    Municipal de Iribarren (UTMI), por Diecisiete Bolívares Soberanos (Bs.S. 50,00),
    para el cálculo de los tributos, sanciones, precios y tarifas en el Municipio Iribarren.

</p>


<p style="text-align: center;"><b>CONSIDERANDO 5</b></p>


<p style="text-align: justify;">
    Que en virtud de las consideraciones realizadas anteriormente, este Despacho:
</p>

<div class="page-break">

</div>

<p style="text-align: center;">
    R E S U E L V E
</p>
<p style="text-align: justify;">
    ARTÍCULO 1: Imponer al contribuyente {{}},
    antes identificado multa de CIENTO CINCUENTA UNIDADES TRIBUTARIAS
    equivalentes a la cantidad de SIETE MIL QUINIENTOS BOLIVARES SOBERANOS
    SIN CENTIMOS (Bs. 7.500,00), por concepto por no
    inscribir el vehículo dentro del lapso previsto en el artículo
    16 establecido en la Ordenanza de Impuesto sobre Vehículos,  publicada en la Gaceta Extraordinaria Nº  4576, de fecha 14 de diciembre de 2018, monto este que se expresa en unidades tributarias, y se utilizará el valor de la unidad tributaria vigente para el momento del pago de conformidad al Parágrafo Primero del artículo 91 del Decreto con Rango, Valor y
    Fuerza de Ley del Código Orgánico Tributario vigente.

</p>

<p style="text-align: justify;">
    ARTÍCULO 2: El monto de la multa deberá ser pagado por ante las Oficinas Receptoras de Fondos Municipales dentro del lapso de treinta (30) días contados a partir de la notificación de la presente resolución, de conformidad con lo establecido en el artículo 39 de Ordenanza de Hacienda Pública Municipal.
    <br>
    <br>

    ARTICULO 3: SE EXHORTA al contribuyente antes identificado, a efectuar el pago de la multa indicada en la presente resolución.

    Dado, firmado y sellado en el Despacho de la Gerencia General del Servicio Municipal de Administración Tributaria (SEMAT), a los   (01) días del mes de julio de 2019.
</p>

<table style="width:100%!important; border-collapse: collapse;margin-top: -1.5cm;">
    <tr>
        <td style="width: 20%;" rowspan="2">

        </td>
        <td style="width: 60%">
            <img src="http://sysprim.com.devel/images/pdf/firma-director.png" style="width:150px; height:120px;margin: 0;" alt="">
        </td>
        <td style="width: 20%;" rowspan="2">
        </td>
    </tr>
    <tr style="width: 100%!important;">
        <td style="text-align: center;font-size: 15px" ><b>ABG. YOLIBETH GRACIELA NELO HERNÁNDEZ<br>
                Directora (E) de la Dirección de Hacienda y
                Gerenta General (E) del Servicio Municipal de Administración Tributaria (SEMAT)<br>
                N° RRHHAL-091-2018, de fecha 22 de noviembre de 2018 y publicada en GME<br>
                Nº 4566, de fecha 23/11/2018</b>
        </td>
    </tr>
</table>

<table style="width: 100%">
    <tr>
        <td style="width: 80%;">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate(\Illuminate\Support\Facades\Crypt::encrypt(30))) !!} " style="right: 10cm !important;left:7cm; !important;position: absolute;">
        </td>
    </tr>
</table>


</body>
</html>




