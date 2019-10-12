@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m6 offest-m3 l4 offset-l4">
                <form action="{{route('updateFines',['id'=>$fines->id])}}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles Multa</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <input id="name" type="text" name="name" required value="{{$fines->name}}">
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="undTributo" type="text" name="undTributo" required value="{{$fines->cant_unid_tribu}}">
                         </div>
                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn green">Actualizar</button>
                    </div>

                    <div class="card-action center">
                        <a href="{{url('/delete-fines/'.$fines->id)}}" class="btn reds">Eliminar</a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
@endsection
