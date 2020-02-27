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
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Fecha de creación</th>
                                    @can('Detalles Roles')
                                    <th>Detalles</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($role as $rol)
                                <tr>
                                    <td>{{ $rol->id }}</td>
                                    <td>{{ $rol->name }}</td>
                                    <td>{{$rol->created_at->format('d-m-Y h:m:s')}}</td>
                                    @can('Detalles Roles')
                                    <td>
                                        <a href="{{ route('roles.details', ['id' => $rol->id]) }}" class="btn btn-floating amber waves-effect waves-light"><i class="icon-pageview"></i></a>
                                    </td>
                                    @endcan
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