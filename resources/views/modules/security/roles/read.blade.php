@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('security.manage') }}" class="breadcrumb">Seguridad</a>
                <a href="{{ route('roles.manage') }}" class="breadcrumb">Gestionar Roles</a>
                <a href="{{ route('roles.read') }}" class="breadcrumb">Consultar Roles</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <table class="centered striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Rol</th>
                                    <th>Descripción</th>
                                    <th>Módulos</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Superusuario</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, nam.</td>
                                    <td>
                                        <div class="input-field left-align">
                                            <p>
                                                <label>
                                                    <input type="checkbox" />
                                                    <span>Gestionar Usuario</span>
                                                </label>
                                            </p>
                                            <p>
                                                <label>
                                                    <input type="checkbox" />
                                                    <span>Gestionar Empresas</span>
                                                </label>
                                            </p>
                                            <p>
                                                <label>
                                                    <input type="checkbox" />
                                                    <span>Gestionar Pagos</span>
                                                </label>
                                            </p>
                                            <p>
                                                <label>
                                                    <input type="checkbox" />
                                                    <span>Gestionar Multas</span>
                                                </label>
                                            </p>
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-floating amber waves-effect waves-light"><i class="icon-pageview"></i></a>
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