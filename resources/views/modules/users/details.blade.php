@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.manage') }}" class="breadcrumb">Gestionar Usuarios</a>
                <a href="{{ route('companies.read') }}" class="breadcrumb">Ver Usuarios</a>
                <a href="#!" class="breadcrumb">Detalles</a>
            </div>
            <div class="col s12 m8 offset-m2">
                @if(Auth::user()->role_id ==3)
                    <div class="card">
                        <div class="card-header center-align">
                            <h5>Nombre de usuario</h5>
                        </div>
                        <div class="card-content row">
                            <div class="col s12 m6 center-align">
                                <img src="{{ asset('images/user.jpg') }}" alt="" srcset=""
                                     class="circle responsive-img">
                            </div>
                            <div class="col s12 m6">
                                {{-- Usar los datos del usuario que se esta viendo --}}
                                <h4 class="center-align">{{ Auth::user()->name . " " . Auth::user()->surname }}</h4>
                                <div class="divider"></div>
                                <div id="user_info">
                                    <ul>
                                        <li><b>Cedula: </b>{{ Auth::user()->ci }}</li>
                                        <li><b>Teléfono: </b>{{ Auth::user()->phone }}</li>
                                        <li><b>E-mail: </b>{{ Auth::user()->email }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer center-align">
                            <a href="{{ route('users.edit') }}" class="btn btn-large blue waves-effect waves-light">Editar</a>
                        </div>
                    </div>
                @endif
                @if(Auth::user()->role_id ==4)
                    <div class="card">
                        <div class="card-header center-align">
                            <h5>Nombre de usuario</h5>
                        </div>
                        <div class="card-content row">
                            <div class="col s12 m6 center-align">
                                <img src="{{ asset('images/user.jpg') }}" alt="" srcset=""
                                     class="circle responsive-img">
                            </div>
                            <div class="col s12 m6">
                                {{-- Usar los datos del usuario que se esta viendo --}}
                                <h4 class="center-align">{{ $user->name . " " . $user->surname }}</h4>
                                <div class="divider"></div>
                                <div id="user_info">
                                    <ul>
                                        <li><b>Cedula: </b>{{ $user->ci }}</li>
                                        <li><b>Teléfono: </b>{{ $user->phone }}</li>
                                        <li><b>E-mail: </b>{{ $user->email }}</li>
                                        <li><b>Tipo De Usuario: </b>{{ $role[0]->name }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer center-align">
                            <a href="{{ url('/users/editar/'.$user->id) }}" class="btn btn-large blue waves-effect waves-light">Editar</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection