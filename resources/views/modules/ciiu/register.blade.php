@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('ciu.manage') }}" class="breadcrumb">Gestionar Grupo CIIU</a>
                <a href="{{ route('ciu-branch.manage') }}" class="breadcrumb">Gestionar Ramo CIIU</a>
                <a href="#!" class="breadcrumb">Registrar Ramo CIIU</a>
            </div>
            <div class="col s12 m8 offest-m2 l6 offset-l3">
                <form action="{{ route('ciu-branch.save') }}" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Ramo CIIU</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12">
                            <select name="groupCiiu" id="groupCiiu" required>
                                <option value="" disabled selected>Elije una opción...</option>
                                @foreach($groupCiiu as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <label for="type">Grupo CIIU</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="name" type="text" name="name" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="code" type="text" name="code" required>
                            <label for="code">Codigo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="alicuota" type="text" name="alicuota" required>
                            <label for="code">Alicuota</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="mTM" type="text" name="mTM" required>
                            <label for="nTM">Minimo de Tributo Mensual</label>
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