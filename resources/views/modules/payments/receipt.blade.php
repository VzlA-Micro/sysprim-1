<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="http://sysprim.com.devel/css/pdf.css">
</head>
<body>
    <div class="receipt-header font-nunito">
    	<table style="width: 100%; border-collapse: collapse;">
	        <tr style="text-align: center">
	            <td style="width: 25%;">
					<img src="http://sysprim.com.devel/images/alcaldia_logo.png" style="width:180px; height:80px" alt="Logo" width="100%" height="100%">
	            </td>
	            <td style="width: 50%;" style="text-align: center;">
					República Bolivariana de Venezuela <br>
					Alcaldía Bolivariana del Municipio Iribarren <br>
					Barquisimeto - Edo. Lara
	            </td>
	            <td style="width: 25%;">
					<img src="http://sysprim.com.devel/images/semat_logo.png" style="width:180px; height:80px" alt="Logo" width="100%" height="100%">
	            </td>
	        </tr>
	    </table>
    </div>
    <h2 style="text-align: center;">Nombre de la empresa</h2>
    <h2 style="text-align: center;">Código: L222536</h2>
    <table style="width: 100%; border-collapse: collapse;">
        <tr style="text-align: center">
            <td style="width: 15%;"></td>
            <td style="width: 70%;">
				<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate("http://sysprim.com.devel/paymentsTaxes-register/1")) !!} " style="width:400px" alt="base png" width="100%" height="100%">
            </td>
            <td style="width: 15%;"></td>
        </tr>
    </table>
    <div class="container">
        <h2>Detalles:</h2>
        <hr>
        <table style="width: 100%; border-collapse: collapse; text-align:center;">
            <thead>
                <tr>
                    <th style="width: 15%">CIIU</th>
                    <th style="width: 25%">DESCRIPCIÓN</th>
                    <th style="width: 20%">LAPSO</th>
                    <th style="width: 20%">BASE IMPONIBLE</th>
                    <th style="width: 20%">IMPUESTO</th>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td>3111685</td>
                    <td>ABASTO, MINI ABASTO Y PANADERIA</td>
                    <td>01/07/2019</td>
                    <td>180.500.777.15</td>
                    <td>3.610.015.54</td>
                </tr>

                <tr>
                    <td>3111685</td>
                    <td>DT.DE CHARCUTERIAS Y QUESOS</td>
                    <td>01/07/2019</td>
                    <td>216.600.932.58</td>
                    <td>4.332.018.65</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="margin-top: 5px;">
            <h5>TOTAL A PAGAR ES:7.692.034.19 BS</h5>
        </div>
        <div class="divider"></div>
        
        <div style="margin-top: 5px;float: right;">
            <span style="display: block;">**ESTE CÓDIGO SOLO ES VALIDO POR 48 HORAS***</span>
            <span>**<b>NO VALIDO COMO SOLVENCIA</b>***</span>
        </div>
</body>
</html>