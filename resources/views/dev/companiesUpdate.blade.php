<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
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
<form action="{{route('companies.update')}}" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="id" value="1">

    @csrf
    <div class="input-field col s12 m6">
        <input id="name" type="text" name="name" required value="{{$companies->name}}">
        <label for="name">Nombre</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="RIF" type="text" name="RIF" value="{{$companies->RIF}}" required >
        <label for="RIF">RIF</label>
    </div>

    <div class="input-field col s12 m6">
        <input id="license" type="text" name="license" value="{{$companies->license}}" required>
        <label for="license">Licencia</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="opening_date" type="text" class="datepicker" name="opening_date" value="{{$companies->opening_date}}" required>
        <label for="opening_date">Fecha de Apertura</label>
    </div>
    <div class="input-field col s12 m12">
        <textarea id="address" name="address" required class="materialize-textarea">{{$companies->address}}</textarea>
        <label for="address">Direccion</label>
    </div>
    <h4>CIU DE LA EMPRESA</h4>
    <div>--------------------------------</div>
    <ul>
    @foreach($companies->ciu as $ciu_selected)

            <li>{{$ciu_selected->name}}</li>

    @endforeach
    </ul>

    <h4>AÑADIR CIU</h4>
    <div>--------------------------------</div>
    <div class="input-field col s12">
        <select multiple name="ciu[]">

            <option value="" disabled>Seleccionar CIU</option>
            @foreach($ciu as $ciu):
            <option value="{{$ciu->id}}">{{$ciu->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="input-field col s12 m12">
        <input id="image" type="file" name="image">
        <label for="image">Imagen</label>
    </div>




    <button type="submit" class="btn green">ACTUALIZAR</button>

</form>


</body>
</html>