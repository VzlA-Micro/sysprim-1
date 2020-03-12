@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/imagePreview.css') }}">

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="#!">Configuración General</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.images.manage') }}">Gestionar Imagenes</a></li>
                    <li class="breadcrumb-item"><a href="#!">Insertar Imagen</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <form method="post" action="{{ route('save.images') }}" class="card" enctype="multipart/form-data" id="register">
                    <div class="card-header center-align">
                        <h4>Insertar Imagen</h4>
                    </div>
                    <div class="card-content row">
                        @csrf

                        <div class="col s12">
                            <div class="preview img-wrapper center-align valing-wrapper">
                                <i class="icon-add_a_photo medium"></i>
                            </div>
                            <div class="file-upload-wrapper">
                                <input type="file" name="image" id="image" class="file-upload-native" accept="image/*" />
                                <input type="text" disabled placeholder="Subir imagen" class="file-upload-text" />
                            </div>
                        </div>

                        <div id="content"></div>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/imagePreview.js') }}"></script>
    <script src="{{ asset('js/data/image.js') }}"></script>
@endsection