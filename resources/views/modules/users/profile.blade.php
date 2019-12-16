@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/imageUpload.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profile') }}">Mi Perfil</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <div class="card">
                    <div class="card-content row">
                        <div class="col s12 m6 center-align">
                            @if (Storage::disk('users')->has(Auth::user()->image))
                            <div class="wrapper center">
                                <!-- <form action="" method="post" id="change-image"> -->
                                    @csrf
                                    <!-- <input type="file" name="image" id="image" value="{{ Auth::user()->image }}" style="display: none"> -->
                                    <button class="no-image" id="img-result" style="background-image: url('{{ route('users.getImage', ['filename' => Auth::user()->image]) }}') !important">Upload Image</button>
                                <!-- </form> -->
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
                                    <input type="hidden" name="id" id="id" value="{{ Auth::user()->id }}">
                                    <div class="input-field col s12">
                                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="validate number-and-capital-letter-only" readonly>
                                        <label for="name">Nombre</label>    
                                    </div>
                                    <div class="input-field col s12">
                                        <input type="text" name="surname" id="surname" value="{{ Auth::user()->surname }}" class="validate" readonly>
                                        <label for="surname number-and-capital-letter-only">Apellido</label>    
                                    </div>
                                    <div class="input-field col s6">
                                        <!-- <i class="icon-phone prefix tooltipped" data-position="S" data-tooltip="412: Digitel<br>414/424: Movistar<br>416/426: Movilnet<br>251: Local"></i> -->
                                        <select name="country_code" id="country_code_company" required>
                                            <option value="null" selected disabled>...</option>
                                            <option value="+58412" @if (Auth::user()->operator=='+58412'){{"selected"}}@endif >(412)</option>
                                            <option value="+58414" @if (Auth::user()->operator=='+58414'){{"selected"}}@endif>(414)</option>
                                            <option value="+58416" @if (Auth::user()->operator=='+58416'){{"selected"}}@endif>(416)</option>
                                            <option value="+58424" @if (Auth::user()->operator=='+58424'){{"selected"}}@endif>(424)</option>
                                            <option value="+58426" @if (Auth::user()->operator=='+58426'){{"selected"}}@endif>(426)</option>
                                            <option value="+58251" @if (Auth::user()->operator=='+58251'){{"selected"}}@endif>(251)</option>
                                        </select>
                                        <label for="country_code">Operadora</label>
                                    </div>
                                    <div class="input-field col s6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números">
                                        <label for="phone">Teléfono</label>
                                        <input id="phone" type="tel" name="phone" value="{{ Auth::user()->numberPhone }}" class="validate number-only" pattern="[0-9]+" title="Solo puede escribir números." placeholder="Ej. 1234567" maxlength="7" minlength="7" required readonly>
                                    </div>
                                    <div class="input-field col s12">
                                        <input type="text" name="email" id="email" value="{{ Auth::user()->email }}" class="validate">
                                        <label for="email">E-mail</label> 
                                    </div>
                                    <div class="input-field col s12 center-align">
                                        <button type="submit" class="btn green col s12 btn-rounded">Actualizar</button>
                                    </div>
                                    <div class="input-field col s12 center-align">
                                        <a href="#" id="change-password" class="btn red col s12 btn-rounded">Cambiar contraseña</a>
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
    <script src="{{ asset('js/imageUpload.js') }}"></script>
    <script src="{{ asset('js/dev/profile.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>

@endsection