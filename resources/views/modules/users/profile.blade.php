@extends('layouts.app')

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
                        <div class="col s12 m6">
                            <img src="{{ asset('images/user.jpg') }}" alt="" srcset="" class="circle responsive-img">
                        </div>
                        <div class="col s12 m6">
                            <h4 class="center-align">Jhon Doe</h4>
                            <div class="divider"></div>
                            <ul>
                                <li><b>Teléfono: </b>+584121234567</li>
                                <li><b>E-mail: </b>jhondoe@mail.com</li>
                            </ul>
                            {{-- <div class="divider"></div> --}}
                            <div class="row">
                                <div class="col s12">
                                    <button class="btn green col s12">Editar Perfil</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection