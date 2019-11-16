@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/imageUpload.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('profile') }}" class="breadcrumb">Mi Perfil</a>
            </div>
            <div class="col s12 m8 offset-m2">
                <div class="card">
                    <div class="card-content row">
                        <div class="col s12 m6 center-align">
                            @if (Storage::disk('users')->has(Auth::user()->image))
                            <div class="wrapper center">
                                <form action="" method="post" id="change-image">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ Auth::user()->id }}">
                                    <input type="file" name="image" id="image" value="{{ Auth::user()->image }}" style="display: none">
                                    <button class="no-image" id="img-result" style="background-image: url('{{ route('users.getImage', ['filename' => Auth::user()->image]) }}') !important">Upload Image</button>
                                </form>
                            </div>
                            @else
                            <div class="wrapper">
                                <button class="no-image" id="img-result" style="background-image: url('{{ asset('images/user.png') }}') !important">Upload Image</button>
                            </div>
                            @endif
                        </div>
                        <div class="col s12 m6">
                            <h4 class="center-align">{{ Auth::user()->name . " " . Auth::user()->surname }}</h4>
                            <div class="divider"></div>
                            <div id="user_info">
                                <ul>
                                    <li><b>Cedula: </b>{{ Auth::user()->ci }}</li>
                                    <li><b>Teléfono: </b>{{ Auth::user()->phone }}</li>
                                    <li><b>E-mail: </b>{{ Auth::user()->email }}</li>
                                </ul>
                            </div>

                            <div id="user_form" >
                                <form method="post" action="#" class="row" id="update" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-field col s12">
                                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="validate number-and-capital-letter-only">
                                        <label for="name">Nombre</label>    
                                    </div>
                                    <div class="input-field col s12">
                                        <input type="text" name="surname" id="surname" value="{{ Auth::user()->surname }}" class="validate">
                                        <label for="surname number-and-capital-letter-only">Apellido</label>    
                                    </div>
                                    <div class="input-field col s12">
                                        <input type="text" name="phone" id="phone" value="{{ Auth::user()->phone }}" class="validate number-only">
                                        <label for="phone">Teléfono</label> 
                                    </div>
                                    <div class="input-field col s12">
                                        <input type="text" name="email" id="email" value="{{ Auth::user()->email }}" class="validate">
                                        <label for="email">E-mail</label> 
                                    </div>
                                    <div class="input-field col s12 center-align">
                                        <button type="submit" class="btn green col s12 btn-rounded">Actualizar</button>
                                    </div>
                                    <div class="input-field col s12 center-align">
                                        <a class="btn red col s12 btn-rounded">Cambiar contraseña</a>
                                    </div>
                                <form>
                            </div>
                            {{-- <div class="divider"></div> --}}
                            <div class="row">
                                <div class="col s12">
                                    <button class="btn green col s12" id="btn-edit">Editar Perfil</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/profile.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/imageUpload.js') }}"></script>

@endsection