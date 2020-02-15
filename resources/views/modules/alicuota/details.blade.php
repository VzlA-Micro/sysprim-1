@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.manage') }}">Gestionar Alicuota</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.read') }}" >Consultar Alicuota</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.details',['id' => $alicuota->id]) }}">Detalles</a></li>

                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" enctype="multipart/form-data" id="update">
                    @csrf
                    <div class="card-header center-align">
                        <h4>Detalles de Alicuota</h4>
                    </div>
                    <div class="card-content row">
                        <input type="hidden" name="id" id="id" value="{{ $alicuota->id }}">


                        <div class="input-field col s12 m6">
                            <i class="icon-time_to_leave prefix"></i>
                            <input type="text" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Solo puede escribir números y letra en mayúsculas." class="validate" value="{{ $alicuota->name }}" required readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-time_to_leave prefix"></i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only-float" value="{{ $alicuota->value }}" required readonly>
                            <label for="value">Valor</label>
                        </div>
                    </div>
                    @can('Actualizar Alicuota')
                    <div class="card-footer center-align">
                        <a href="#!" class="btn btn-large blue btn-rounded waves-effect waves-light" id="btn-modify">
                            <i class="icon-update right"></i>
                            Modificar
                        </a>
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light hide" id="btn-update">
                            <i class="icon-send right"></i>
                            Actualizar
                        </button>
                    </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/data/alicuota.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection