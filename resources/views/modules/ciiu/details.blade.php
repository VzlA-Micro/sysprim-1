@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('ciu.manage') }}" class="breadcrumb">Gestionar Grupo CIIU</a>
                <a href="{{ route('ciu-branch.manage') }}" class="breadcrumb">Gestionar Ramo CIIU</a>
                <a href="#!" class="breadcrumb">Ver Ramos CIIU's</a>
                <a href="#!" class="breadcrumb">Detalles</a>
            </div>
            <div class="col s12 m6 offset-m3">
                <form id="ciiu-details"  method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles Ramo CIIU</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <!--<div class="input-field col s12">

                        </div>-->
                        <input id="id" type="hidden" name="id" value="{{ $ciu->id }}">
                        <input id="idGroupCiiu" type="hidden" name="idGroupCiiu" value="{{ $groupCiu->id }}">

                        <div class="input-field col s12">
                            <i class="icon-check prefix"></i>
                            <input id="groupCiiu" type="text" name="groupCiiu" readonly value="{{ $groupCiu->name }}">
                            <label for="name">Nombre Del Grupo CIIU</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <input id="name" type="text" name="name" required value="{{ $ciu->name }}">
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input id="code" type="text" name="code" required value="{{ $ciu->code }}">
                            <label for="code">Codigo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input id="alicuota" type="text" name="alicuota" required value="{{ $ciu->alicuota }}">
                            <label for="code">Alicuota</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>   
                            <input id="mTM" type="text" name="mTM" required value="{{ $ciu->min_tribu_men }}">
                            <label for="mTM">Minimo de Tributo Mensual</label>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button type="submit" class="btn btn-rounded green waves-effect waves-light">Actualizar</button>
                    </div>
                    <div class="card-action center">
                        <a href="{{ route('ciu-branch.delete', ['id' => $ciu->id]) }}" class="btn btn-rounded red waves-effect waves-light">Eliminar</a>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/ciiu.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection