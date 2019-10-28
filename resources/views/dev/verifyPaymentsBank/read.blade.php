@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('users.manage') }}" class="breadcrumb">Pagos Verificados</a>
                <a href="#!" class="breadcrumb">Ver Pagos Verificados</a>
            </div>
            <div class="col s12 m10 offset-m1">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Pagos Verificados</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight centered responsive-table">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Empresa</th>
                                    <th>Licencia</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taxes as $taxe)
                                <tr>
                                    <td>{{$taxe->code}}</td>
                                    <td>{{$taxe->companies->name}}</td>
                                    <td>{{$taxe->companies->license}}</td>
                                    <td>{{$taxe->amount}}</td>
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