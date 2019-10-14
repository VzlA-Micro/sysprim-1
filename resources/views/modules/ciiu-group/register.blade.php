@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('ciu.manage') }}" class="breadcrumb">Gestionar CIIU</a>
                <a href="#!" class="breadcrumb">Registrar Grupo CIIU</a>
            </div>
            <div class="col s12 m8 offest-m2 l6 offset-l3">
                <form action="{{ route('ciu-group.save') }}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Grupo de CIIU</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12 m6">
                            <input id="code" type="text" name="code" required>
                            <label for="code">Codigo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="name" type="text" name="name" required>
                            <label for="name">Nombre</label>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn green">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection