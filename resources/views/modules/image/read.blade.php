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
      </div>
            @if(Session::has('message'))
                <div class="message message-danger">
                    <div class="message-body">
                        <strong>{{ session('message') }}</strong>
                    </div>
                </div>
            @endif

        @if(Session::has('mesage'))
            <div class="message message-success">
                <div class="message-body">
                    <strong>{{ session('mesage') }}</strong>
                </div>
            </div>
        @endif

            <div class="row">
            @if($images !== null)

                @foreach($images as $image)
                        <div class="col s3 m3">
                            <div class="card">
                                <div class="card-image" style="-webkit-background-size: cover;">
                                    <img src="{{route('image.file', ['filename' => $image->path])}}" alt="imagenes para login" style="max-height: 150px;">
                                    {{--<a id="delete" data-image="{{$image->id}}" class="btn-floating halfway-fab waves-effect waves-light red-gradient"><i class="icon-delete"></i></a>--}}
                                    <a href="{{ route('image.delete', $image->id)  }}" class="btn-floating halfway-fab waves-effect waves-light red-gradient"><i class="icon-delete"></i></a>
                                    {{--<span class="card-title">Inicio</span>--}}
                                </div>

                                @can('Habilitar/Deshabilitar Imagen')
                                @if($image->status == "enabled")
                                    <div class="card-action">
                                        <a href="#" class="activator green-text text-darken-2">Imagen Hablitada (Presione para deshabilitarla)</a>
                                    </div>
                                    <div class="card-reveal">
                                        <span class="card-title grey-text text-darken-4">Deshabilitar Imagen de Inicio<i class="icon-close right"></i></span>

                                           <div class="row" style="margin-top: 20px">
                                                <div class="col s12 m12 l12">
                                                    <a href="{{ route('image.status', $image->id)  }}" class="activator waves-effect waves-light btn red-gradient">Deshabilitar</a>
                                                </div>
                                            </div>
                                    </div>
                                @elseif($image->status == "disabled")
                                    <div class="card-action">
                                        <a href="#" class="activator orange-text text-darken-2">Seleccionar Imagen (Presione para habilitar)</a>
                                    </div>
                                    <div class="card-reveal">
                                        <span class="card-title grey-text text-darken-4">Habilitar Imagen de Inicio<i class="icon-close right"></i></span>

                                            <div class="row" style="margin-top: 20px">
                                                <div class="col s12 m12 l12">
                                                    <a href="{{ route('image.status', $image->id)  }}" class="activator waves-effect waves-light btn green-gradient">Habilitar</a>
                                                </div>
                                            </div>
                                    </div>
                                @endif
                                @endcan
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            @endif
        </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/image.js') }}"></script>
@endsection