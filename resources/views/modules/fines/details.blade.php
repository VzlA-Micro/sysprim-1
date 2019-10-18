@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="" class="breadcrumb">Inicio</a>
                <a href="" class="breadcrumb">Gestionar Multas</a>
                <a href="" class="breadcrumb">Ver Multas</a>
                <a href="" class="breadcrumb">Detalles</a>
            </div>
            <div class="col s12 m6 offset-m3">
                <form action="{{ route('fines.update', ['id' => $fines->id]) }}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles de la Multa</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <input id="name" type="text" name="name" required value="{{ $fines->name }}">
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="undTributo" type="text" name="undTributo" required value="{{ $fines->cant_unid_tribu }}">
                        </div>
                        <div class="col s12 m6 center-align">
                            <button type="submit" class="btn btn-rounded green waves-effect waves-light">Actualizar</button>
                        </div>
                        <div class="col s12 m6 center-align">
                            <a href="{{ route('fines.delete', ['id' => $fines->id]) }}" class="btn btn-rounded red waves-effect waves-light">Eliminar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection