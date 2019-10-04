@extends('layouts.app2')

@section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="col s12 m6 offest-m3 l4 offset-l4">
                    @if($errors->any())
                            @foreach($errors->all() as $error)
                                {{$error}}
                             @endforeach
                        @endif
                    <form action="{{route('companies.save')}}" method="post" class="card" enctype="multipart/form-data">
                        <div class="card-header center-align">
                            <h5>Registrar mi Empresa</h5>
                        </div>
                        <div class="card-content row">
                            @csrf
                            <div class="input-field col s12 m6">
                                <input id="name" type="text" name="name" required>
                                <label for="name">Nombre</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="RIF" type="text" name="RIF" required>
                                <label for="RIF">RIF</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <input id="license" type="text" name="license" required>
                                <label for="license">Licencia</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="opening_date" type="text" class="datepicker" name="opening_date" required>
                                <label for="opening_date">Fecha de Apertura</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <textarea id="address" name="address" required class="materialize-textarea"></textarea>
                                <label for="address">Direccion</label>
                            </div>

                            <div class="input-field col s12">
                                <select multiple name="ciu[]">
                                    <option value="" disabled>Seleccionar CIU</option>
                                     @foreach($ciu as $ciu):
                                    <option value="{{$ciu->id}}">{{$ciu->name}}</option>
                                     @endforeach
                                </select>
                                <label>Materialize Multiple Select</label>
                            </div>

                            <div class="input-field col s12 m12">
                                <input id="image" type="file" name="image">
                                <label for="image">Imagen</label>
                            </div>


                        </div>

                        <div class="card-action center">
                            <button type="submit" class="btn green">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection