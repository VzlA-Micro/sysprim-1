@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu.manage') }}">Gestionar CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.manage') }}">Gestionar Ramos CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.read') }}">Ver Ramos CIIU's</a></li>
                    <li class="breadcrumb-item"><a href="#!">Detalles</a></li>
                </ul>
            </div>
            <div class="col s12 m10 l8 offset-m1 offset-l2">
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
                    @can('Actualizar Ramos CIIU')
                    <div class="card-action center">
                        <button type="submit" class="btn btn-rounded green waves-effect waves-light">Actualizar</button>
                    </div>
                    @endcan
                    <!-- <div class="card-action center">
                        <a href="{{ route('ciu-branch.delete', ['id' => $ciu->id]) }}" class="btn btn-rounded red waves-effect waves-light">Eliminar</a>
                    </div> -->
                   
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dev/ciiu.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection