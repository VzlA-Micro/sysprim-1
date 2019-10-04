@extends('layouts.app2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m6 offest-m3 l4 offset-l4">
                <form action="{{route('updateCiu',['id'=>$ciu->id])}}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles Ciu</h5>
                    </div>
                    <div class="card-content row">
                        @csrf

                        
                        <!--<input id="id" type="hidden" name="id" required value="{{$ciu->id}}">-->
                        <div class="input-field col s12 m6">
                            <input id="name" type="text" name="name" required value="{{$ciu->name}}">
                            
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="value" type="text" name="value" required value="{{$ciu->value}}">
                           
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="code" type="text" name="code" required value="{{$ciu->code}}">
                          
                        </div>
                     
                   
                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn green">Actualizar</button>
                    </div>

                    <div class="card-action center">
                        <a href="{{url('/delete-ciu/'.$ciu->id)}}" class="btn reds">Eliminar</a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
@endsection
