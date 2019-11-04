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
                            <i class="icon-check prefix"></i>                                                                                   
                            <input id="name" type="text" name="name" required value="{{ $fines->name }}">
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-swap_vertical_circle prefix"></i>                                                        
                            <input id="undTributo" type="text" name="undTributo" required value="{{ $fines->cant_unid_tribu }}">
                            <label for="undTributo">Cantidad de unidades tributarias</label>
                        </div>
                        <div class="col s12 m6 center-align">
                            <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light">
                                Actualizar
                                <i class="icon-send right"></i>
                            </button>
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
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection