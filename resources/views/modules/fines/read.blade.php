@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Gestionar Multas</a>
                <a href="" class="breadcrumb">Ver Multas</a>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-header center-align">
                        <h5>Multas Disponibles</h5>
                    </div>
                    <div class="card-content">
                        <table class="centered striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cantidad de unidades tributarias</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($showFines as $fines)
                                <tr>
                                    <td>{{ $fines->name }}</td>
                                    <td>{{ $fines->cant_unid_tribu }}</td>
                                    <td>
                                        <a href="{{ route('fines.details',['id' => $fines->id]) }}" class="btn btn-small btn-floating pink waves-effect effect-light"><i class="icon-pageview"></i></a>
                                    </td>
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