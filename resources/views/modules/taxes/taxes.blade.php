<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
<ul>
        <li>CÓDIGO:{{$taxes->code}}</li>
        <li>PERIODO FISCAL:{{$taxes->fiscal_period}}</li>
        <li>FECHA:{{$taxes->created_at}}</li>
    <li>-------------------------------------------</li>
</ul>
    <ul>
        <li>Datos de EMPRESA</li>
        <li>-------------------------------------------</li>

            <li>NOMBRE:{{$taxes->companies->name}}</li>
            <li>RIF:{{$taxes->companies->rif}}</li>
            <li>LICENCIA:{{$taxes->companies->license}}</li>
            <li>FECHA DE APERTURA:{{$taxes->companies->opening_date}}</li>
            <li>DIRECCION:{{$taxes->companies->andress}}</li>
            <li>IMAGE:{{$taxes->companies->image}}</li>


    </ul>
<ul>
    <li>Datos de impuesto-CIU</li>
    <li>-------------------------------------------</li>
    @foreach($taxes->taxesCiu as $ciu)
        <li>NOMBRE:{{$ciu->name}}</li>
        <li>CODIGO:{{$ciu->code}}</li>
        <li>BASE IMPONIBLE:{{$ciu->pivot->base}}</li>
        <li>DEDUCCIONES:{{$ciu->pivot->deductions}}</li>
        <li>CREDITO FISCAL:{{$ciu->pivot->fiscal_credits}}</li>
        <li>DEDUCCIONES:{{$ciu->pivot->withholding}}</li>
        <li>-------------------------------------------</li>
    @endforeach
</ul>

</body>
</html>