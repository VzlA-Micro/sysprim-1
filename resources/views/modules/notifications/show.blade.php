@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('notifications.manage') }}">Gestionar Notificaciones</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('notifications.show') }}">Ver Notificaciones</a></li>
                </ul>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <table class="striped centered" style="width: 100%;" id="finesCompany">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Notificación</th>
                                    <th>Visto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jhon Doe</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet voluptate laborum at tempora! A quisquam odio explicabo aut. Omnis, esse.</td>
                                    <td>
                                    	<!-- La condicion debe cambiar  -->
                                    	@if(\Auth::user()->confirmed == 1)
                                        <i class="icon-check green-text" style="font-size: 20px"></i>
                                        @else
                                        <i class="icon-close red-text" style="font-size: 20px"></i>
                                        @endif
                                    </td>
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