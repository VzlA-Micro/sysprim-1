@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('vehicles.my-vehicles') }}" class="breadcrumb">Mis Vehículos</a>   
                <a href="{{ route('vehicles.register') }}" class="breadcrumb">Ver mis Vehículo</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Mis Vehículos</h5>
                    </div>
                    <div class="card-content">
                        <table class="centered striped responsive-table">
                            <thead>
                                <tr>
                                    <th>Licencia</th>
                                    <th>Color</th>
                                    <th>Marca</th>
                                    <th>Módelo</th>
                                    <th>Año</th>
                                    <th>Valor</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>L1S2M3</td>
                                    <td>Negro</td>
                                    <td>BWM</td>
                                    <td>No se</td>
                                    <td>2020</td>
                                    <td>100UTC</td>
                                    <td>
                                        <a href="" class="btn btn-floating orange waves-light"><i class="icon-pageview"></i></a>
                                    </td>
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