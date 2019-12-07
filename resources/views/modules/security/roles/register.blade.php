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
                    <li class="breadcrumb-item"><a href="{{ route('roles.register') }}">Registrar Rol</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <form action="" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Rol</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <i class="icon-assignment prefix"></i>
                            <input type="text" name="name" id="name" class="validate"   required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-directions prefix"></i>
                            <textarea name="description" id="description" cols="30" rows="10" class="materialize-textarea" required></textarea>
                            <label for="description">Descripción</label>
                        </div>
                        <table class="striped centered">
                            <thead>
                                <tr>
                                    <th>Módulo</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p>
                                            <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Gestionar Usuario</span>
                                            </label>
                                        </p>

                                    </td>
                                    <td>
                                        <div class="input-field col s12 m6 left-align">
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Registrar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Consultar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Modificar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Eliminar</span>
                                              </label>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>
                                            <label>
                                                <input type="checkbox" />
                                                <span>Gestionar Empresas</span>
                                            </label>
                                        </p>

                                    </td>
                                    <td>
                                        <div class="input-field col s12 m6 left-align">
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Registrar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Consultar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Modificar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Eliminar</span>
                                              </label>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>
                                            <label>
                                                <input type="checkbox" />
                                                <span>Gestionar Pagos</span>
                                            </label>
                                        </p>

                                    </td>
                                    <td>
                                        <div class="input-field col s12 m6 left-align">
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Registrar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Consultar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Modificar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Eliminar</span>
                                              </label>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>
                                            <label>
                                                <input type="checkbox" />
                                                <span>Gestionar Multas</span>
                                            </label>
                                        </p>

                                    </td>
                                    <td>
                                        <div class="input-field col s12 m6 left-align">
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Registrar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Consultar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Modificar</span>
                                              </label>
                                            </p>
                                            <p>
                                              <label>
                                                <input type="checkbox" id="" name=""/>
                                                <span>Eliminar</span>
                                              </label>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection