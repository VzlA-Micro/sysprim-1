@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.manage') }}" class="breadcrumb">Gestionar Empresas</a>
                <a href="#!" class="breadcrumb">Ver Empresa</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Empresas Registradas</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight responsive-table centered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>RIF</th>
                                    <th>Licencia</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Abastecer CA</td>
                                    <td>J12325347347</td>
                                    <td>L124235</td>
                                    <td>+582511234567</td>
                                    <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolore delectus, iusto magnam atque aspernatur quis. Voluptatem sapiente harum quis nesciunt.</td>
                                    <td>
                                        <a href="" class="btn btn-floating red"><i class="icon-pageview"></i></a>
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