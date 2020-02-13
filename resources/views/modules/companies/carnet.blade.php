<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carnet</title>
</head>
<body>
    <table style="width:100%; border: solid 1px black; font-family: Helvetica;">
        <tbody>
            <tr>
                <td style="width: 25%; text-align: left;">
                    <img src="{{ asset('images/semat_logo.png') }}" style="width: 130px; height: 60px;" alt="Logo Semat" width="100%" height="100%">
                </td>
                <td style="width: 50%; text-align: center;">
                    <span style="font-size: 12px !important;">
                        República Bolivariana de Venezuela <br>
                        Alcaldía Bolivariana del Municipio Iribarren <br>
                        Barquisimeto - Edo. Lara
					</span>
                </td>
                <td style="width: 25%; text-align: right;">
                    <img src="{{ asset('images/alcaldia_logo.png') }}" style="width: 130px; height: 60px;" alt="Logo Semat" width="100%" height="100%">
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center; border-bottom: 1px solid #000; padding: 15px; border-top: 1px solid #000">
                    REGISTRO MUNICIPAL DE INFORMACIÓN FISCAL.
                </td>
            </tr>

            <tr>
                <td style="width:25%; text-align: left;">
                    <b>Fecha de Registro: </b>
                </td>
                <td style="width:60%; text-align: left;font-size: 12px!important;">
                    <span>{{ $company->created_at->format('d-m-Y') }}</span>
                </td>
            </tr>
            <tr>
                <td style="width:15%; text-align: left;">
                    <b>Razón Social: </b>
                </td>
                <td style="width:60%; text-align: left;font-size: 12px!important;" colspan="">
                    <span>{{ $company->name }}</span>
                </td>
                <td style="width:20%;" rowspan="5">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->generate($company->license.'-'.$company->created_at)) !!} " style="width: 150px; height: 150px; margin: auto;" alt="Imagen V" width="100%" height="100%" ><br>
                </td>
            </tr>
            <tr>
                <td style="width:15%; text-align: left;">
                    <b>RIF: </b>
                </td>
                <td style="width:60%; text-align: left;font-size: 12px!important;">
                    <span>{{ $company->RIF }}</span>
                </td>
            </tr>
            <tr>
                <td style="width:15%; text-align: left;">
                    <b>Dirección: </b>
                </td>
                <td style="width:60%; text-align: left;font-size: 12px!important;">
                    <span>{{ $company->address}}</span>
                </td>
            </tr>
            <tr>
                <td style="width:15%; text-align: left;">
                    <b>Licencia: </b>
                </td>
                <td style="width:60%; text-align: left;font-size: 12px!important;">
                    <span>{{ $company->license }}</span>
                </td>
            </tr>
            <tr>
                <td style="width:15%;">
                    <img src="{{ asset('images/logo.png') }}" style="width: 160px; height: 120px;" alt="logo" width="100%" height="100%">
                </td>
                <td style="width:60%;font-size: 10px;text-align: center;">
                    <img src="{{ asset('images/pdf/firma-director.png') }}" style="width: 150px; height: 120px;position: relative; left: 270px !important; top: 180px; margin-bottom:-13px;" alt="Firma" width="100%" height="100%"><br>
                    __________________________________________<br>
                    ABG. YOLIBETH GRACIELA NELO HERNÁNDEZ<br>
                    Directora (E) de la Dirección de Hacienda y<br>
                    Gerenta General (E) del Servicio Municipal<br> de Administración Tributaria (SEMAT)<br>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 3px; border-top: 1px solid #000">

                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>