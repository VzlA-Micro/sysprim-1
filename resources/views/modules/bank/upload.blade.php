@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <form action="{{ route('saveReferenceBank') }}" method="post" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>Cargar Estados de cuenta</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="file-field input-field">
                            <div class="btn blue waves-light">
                              <span>Seleccionar Archivo</span>
                              <input type="file" name="file" id="file">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text" placeholder="Buscar archivo...">
                            </div>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-light">Cargar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
