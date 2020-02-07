@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" >Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}" >Configuración</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.manage') }}">Gestionar Alicuota</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alicuota.register') }}">Registrar Alicuota de Inmubles </a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" enctype="multipart/form-data" id="register">
                    @csrf
                    <div class="card-header center-align">
                        <h4>Registrar Alicuota de Inmubles</h4>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <i class="icon-text_fields prefix"></i>
                            <input type="text" name="name" id="name" pattern="[a-zA-Z0-9 ]+" title="Solo puede escribir números y letra en mayúsculas." class="validate" minlength="5" maxlength="30" required>
                            <label for="name"> Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input type="text" name="value" id="value" pattern="[0-9,.]+" title="Solo puede escribir números." class="validate number-only only-number-positive"  maxlength="2"  required>
                            <label for="value">Valor</label>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/alicuota.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection