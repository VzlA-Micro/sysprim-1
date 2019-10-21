@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Mis Empresas</a>
                <a href="" class="breadcrumb">Nombre de la empresa</a>
                <a href="" class="breadcrumb">Mis Pagos</a>
                <a href="" class="breadcrumb">Pagar Mis Vehiculos</a>                
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Elija un vehículo para pagar</h5>
                    </div>
                    <div class="card-content">
                        <table class="striped centered resposive-table">
                            <thead>
                                <tr>
                                    <th>Licencia</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Imagen</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>L121151</td>
                                    <td>Ford</td>
                                    <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus unde saepe omnis possimus pariatur, ducimus asperiores molestias corrupti maxime amet.</td>
                                    <td>
                                        <img src="" alt="{{ asset('images/backgroud-3.jpg') }}" class="responsive-img materialboxed">
                                    </td>
                                    <td></td>
                                </tr>
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