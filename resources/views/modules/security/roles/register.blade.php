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
                <form action="" method="post" class="card" id="register">
                    <div class="card-header center-align">
                        <h5>Registrar Rol</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12">
                            <i class="icon-assignment prefix"></i>
                            <input type="text" name="name" id="name" class="validate" value="{{ $role->name }}"  required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 center-align">
                            <h5>Listado de Permisos</h5>
                        </div>
                        @foreach ($permissions as $permission)
                        <div class="input-field col s12 m4">
                            <p>
                                <label for="customCheck{{ $permission->id  }}">
                                    {{ Form::checkbox('permissions[]', $permission->id, $role->hasPermissionTo($permission->id), ['id' => 'customCheck'.$permission->id]) }}
                                    <!-- <input type="checkbox" id="" name=""/> -->
                                    <span class="truncate">{{ $permission->name }}</span>
                                </label>
                            </p>
                        </div>
                        @endforeach
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
    <script src="{{ asset('js/data/roles_permissions.js') }}"></script>
    
@endsection