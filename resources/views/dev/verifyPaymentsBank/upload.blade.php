@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m8 offest-m2 l4 offset-l4">
                <form action="{{ route('saveFileBank') }}" method="post" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>Cargar Estados de cuenta</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="file-field input-field">
                            <div class="btn blue waves-light">
                              <span>Cargar Archivo</span>
                              <input type="file" name="file" id="file">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text" placeholder="Buscar archivo...">
                            </div>
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
