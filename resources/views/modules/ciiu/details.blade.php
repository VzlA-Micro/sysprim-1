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
                <form id="ciiu-details" method="#" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles Ramo CIIU</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <!--<div class="input-field col s12">

                        </div>-->
                        <input id="id" type="hidden" name="id" value="{{ $ciu->id }}">

                        <div class="input-field col s12">
                            <i class="icon-featured_play_list prefix"></i>
                            <select name="idGroupCiiu" id="idGroupCiiu" required disabled>
                                <option value="#" disabled selected>Elije una opción...</option>
                                @foreach($groupCiu as $group)
                                    @if($ciu->group_ciu_id==$group->id )
                                        <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                    @else
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="type">Grupo CIIU</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <input id="name" type="text" name="name" required  class="validate" value="{{ $ciu->name }}"  minlength="3" maxlength="100"  readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input id="code" type="text" name="code" class="validate" required value="{{ $ciu->code }}" minlength="3" maxlength="30" readonly>
                            <label for="code">Codigo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input id="alicuota" type="text" name="alicuota" class="validate number-only " required value="{{ $ciu->alicuota }}"  maxlength="5"  minlength="1" readonly>
                            <label for="code">Alicuota</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="">
                            </i>
                            <input id="mTM" type="text" name="mTM" required value="{{ $ciu->min_tribu_men }}"  maxlength="3"  minlength="1" readonly>
                            <label for="mTM">Minimo de Tributo Mensual</label>
                        </div>
                    </div>
                    @can('Actualizar Ramos CIIU')


                @endcan

                    <div class="card-footer center-align">
                        <a href="#!" class="btn btn-rounded btn-large blue waves-effect waves-light "
                           id="btn-edit">
                            <i class="icon-send right"></i>
                            Editar
                        </a>
                        <button type="submit"
                                class="btn btn-rounded btn-large peach waves-effect waves-light"
                                style="display: none" id="btn-update">
                            <i class="icon-save right"></i>
                            Guardar
                        </button>
                    </div>
                <!-- <div class="card-action center">
                        <a href="{{--route('ciu-branch.delete', ['id' => $ciu->id]) --}}" class="btn btn-rounded red waves-effect waves-light">Eliminar</a>
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