@extends('layouts.app')

@section('styles')

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
                    <li class="breadcrumb-item"><a href="#!">Ver Imagen</a></li>
                </ul>
            </div>

            @if($images !== null)
                <div class="row">
                @foreach($images as $image)
                        <div class="col s3 m3">
                            <div class="card">
                                <div class="card-image" style="-webkit-background-size: cover;">
                                    <img src="{{route('image.file', ['filename' => $image->path])}}" alt="imagenes para login" style="max-height: 150px;">
                                    {{--<a id="delete" data-image="{{$image->id}}" class="btn-floating halfway-fab waves-effect waves-light red-gradient"><i class="icon-delete"></i></a>--}}
                                    <a href="{{ route('image.delete', $image->id)  }}" class="btn-floating halfway-fab waves-effect waves-light red-gradient"><i class="icon-delete"></i></a>
                                    {{--<span class="card-title">Inicio</span>--}}
                                </div>
                                <div class="card-action">
                                    <a href="#" class="activator orange-text text-darken-2">Seleccionar Imagen</a>
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4">Cambiar fondo<i class="icon-close right"></i></span>

                                    <div class="row" style="margin-top: 20px">
                                        <div class="col s12 m12 l12">
                                            <a href="#" class="activator red-text text-darken-3">Cambiar imagen del inicio 1</a>
                                        </div>
                                        <div class="col s12 m12 l12">
                                            <a href="#" class="activator red-text text-darken-3">Cambiar imagen del inicio 2</a>
                                        </div>
                                        <div class="col s12 m12 l12">
                                            <a href="#" class="activator red-text text-darken-3">Cambiar imagen del inicio 3</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/image.js') }}"></script>
@endsection