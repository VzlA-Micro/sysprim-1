@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('users.manage') }}" class="breadcrumb">Gestionar Usuarios</a>
                <a href="#!" class="breadcrumb">Ver Usuarios</a>
            </div>
            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Usuarios registrados</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight centered responsive-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Doc. Identidad</th>
                                    <th>Teléfono</th>
                                    <th>E-mail</th>
                                    <th>Verificado</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($showUser as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->ci}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <i class="icon-check" style="font-size: 20px"></i>
                                    </td>
                                    <td>
                                        <a href="{{url('/users/details/'.$user->id)}}" class="btn btn-floating orange waves-effect waves-light">
                                            <i class="icon-pageview"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection