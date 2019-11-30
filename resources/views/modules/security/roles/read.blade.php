@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('security.manage') }}">Seguridad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.manage') }}">Gestionar Roles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.read') }}">Consultar Roles</a></li>
                </ul>
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