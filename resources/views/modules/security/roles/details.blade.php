@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
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
                    <li class="breadcrumb-item"><a href="#!">Detalles</a></li>

                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <form action="" method="post" class="card" id="update">
                	@csrf
                    <div class="card-header center-align">
                        <h5>Detalles Rol</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12">
                        	<input type="hidden" name="id" value="{{ $role->id }}">
                            <i class="icon-assignment prefix"></i>
                            <input type="text" name="name" id="name" class="validate" value="{{ $role->name }}" >
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 center-align">
                            <h5>Listado de Permisos</h5>
                        </div>






                            <table class="centered highlight" id="rates" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Permisos</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>
                                            <p style="text-align: justify">
                                                <label for="customCheck{{ $permission->id  }}">
                                                    {{ Form::checkbox('permissions[]', $permission->id, $role->hasPermissionTo($permission->id), ['id' => 'customCheck'.$permission->id, '']) }}
                                                    <span class="truncate">{{ $permission->name }}</span>
                                                </label>
                                            </p>
                                        </td>
                                @endforeach

                                </tbody>
                            </table>
                    </div>
                    @can('Actualizar Roles')
                    <div class="card-footer center-align">
						<!-- <button class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Editar
                        </button> -->
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Actualizar
                        </button>
                    </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        $('#rates').DataTable({
            responsive: true,
            scroller: true,
            "scrollX": true,
            "pageLength": 10,
            "aaSorting": [],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Todavia este contribuyente ningun pago.",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "<i class='icon-navigate_next'></i>",
                    "sPrevious": "<i class='icon-navigate_before'></i>"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            }
        });
    </script>
    <script src="{{ asset('js/data/roles_permissions.js') }}"></script>
@endsection