<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<table border="1">
    <thead>
    <tr>
        <th>CODIGO</th>
        <th>PERIODO FISCAL</th>
        <th>ESTADO</th>
    </tr>
    </thead>
    <tbody>

    @foreach($taxes as $taxe)
        <tr>
            <th>{{$taxe->code}}</th>
            <th>{{$taxe->fiscal_period}}</th>
            @if($taxe->payments->isEmpty())
                <th>SIN CONCILIAR AÚN</th>
                <th><button>Pagar</button></th>

            @endif
            @foreach($taxe->payments as $payment)
                <th>{{$payment->status}}</th>
                <th><button><a href="{{url('payments/taxes/'.$taxe->id)}}">DESCARGAR SOLVENCIA</a></button></th>
            @endforeach
        </tr>
    @endforeach


    </tbody>
</table>


</body>
</html>