@extends('layouts.app2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 m8 offest-m2 l4 offset-l4">
                <form action="{{route('saveReferenceBank')}}" method="post" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>Cargar Estados de cuenta</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="file-field input-field">
                            <div class="btn">
                              <span>Archivo</span>
                              <input type="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text">
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
