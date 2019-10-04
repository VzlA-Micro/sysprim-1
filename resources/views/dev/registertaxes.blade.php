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
@if(session('message'))
    {{session('message')}}
@endIf
<form action="{{route('taxes.save')}}" method="post">
    <label for="fiscal_period">Perido Fiscal</label>
    <input type="date" id="fiscal_period" name="fiscal_period" >
    <br>
    <input type="hidden" id="company_id" name="company_id" value="1">
    <div>---------------------------------------------------------------------------------------------------</div>
    @foreach($company->ciu as $ciu)

            <label for="code" >Código</label>
            <input type="text" disabled value="{{$ciu->code}}" style="margin-top: 10px !important;">
            <label for="ciu">Nombre</label>
            <input type="text" value="{{$ciu->name}}" disabled><br>
             <input type="hidden" name="ciu_id[]" value="{{$ciu->id}}" ><br>

            <label for="base">Base Imponible</label>
            <input type="text" id="base" name="base[]">

            <label for="deductions">Deducciones</label>
            <input type="text" id="deductions" name="deductions[]">

            <label for="withholding">Retenciones</label>
            <input type="text" id="withholding" name="withholding[]">


            <label for="fiscal_credits">Credito Fiscal</label>
            <input type="text" id="fiscal_credits" name="fiscal_credits[]"><br>
            <div>---------------------------------------------------------------------------------------------------</div>
    @endforeach
    <button type="submit">Registrar</button>
</form>


<div style="border: 1px solid red;height: 250px;width: 500px;">
    @foreach($notifications as $notification)
        <div>
           <ul>
               <li>titulo: {{$notification->title }}</li>
               <li>mensaje: {{$notification->content}}</li>
           </ul>
        </div>
    @endforeach
</div>


<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
</body>
</html>