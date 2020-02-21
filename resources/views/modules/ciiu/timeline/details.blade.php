@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.companies') }}">Configuración de Act. Económica</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.manage') }}">Gestionar Ramos CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.timeline.manage') }}">Gestionar Línea de Tiempo-CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.timeline.index') }}">Consultar Línea de Tiempo-CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.timeline.index') }}">Detalles de Línea de Tiempo-CIIU</a></li>
                </ul>
            </div>
            <div class="col s12 m10 l8 offset-m1 offset-l2">
                <form id="ciiu-timiline-details" method="#" class="card">
                    <div class="card-header center-align">
                        <h5>Detalles Línea de Tiempo de CIIU</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <!--<div class="input-field col s12">

                        </div>-->
                        <input id="id" type="hidden" name="id" value="{{ $ciu->id }}">
                        <input  type="hidden" name="ciu_id" value="{{ $ciu->ciiu->id }}">


                        <div class="input-field col s12">
                            <i class="icon-featured_play_list prefix"></i>
                            <select name="ciu_id" id="ciu_id" disabled >
                                <option value="null" disabled>Elije una opción...</option>
                                @foreach($ciiu as $ciu_all)
                                    @if($ciu_all->id==$ciu->id)
                                        <option value="{{ $ciu_all->id }}" selected>{{ $ciu_all->name }}</option>
                                    @else

                                        <option value="{{ $ciu_all->id }}">{{ $ciu_all->name }}</option>
                                    @endif

                                @endforeach
                            </select>
                            <label for="type">Ramo CIIU</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <input id="name" type="text" name="name" required  class="validate" value="{{ $ciu->ciiu->name }}"  minlength="3" maxlength="100"  readonly>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input id="code" type="text" name="code" class="validate code-only" required value="{{ $ciu->ciiu->code }}" minlength="3" maxlength="30" readonly>
                            <label for="code">Codigo</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input id="alicuota" type="text" name="alicuota" class="validate  number-only-float" required maxlength="2" value="{{$ciu->alicuota}}" readonly>
                            <label for="alicuota">Alicuota</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>
                            <input id="mTM" type="text" name="mTM"  class="validate number-only"  maxlength="5" required value="{{$ciu->min_tribu_men}}" readonly>
                            <label for="mTM">Minimo de Tributo Mensual</label>
                        </div>

                        @php
                            $cont=(int)date('Y');
                        @endphp

                        <div class="input-field col s12 m12">
                            <i class="icon-date_range prefix"></i>
                            <select name="since" id="since" disabled>
                                <option value="null" selected disabled>Seleccione</option>
                                @while($cont <= 2030)

                                    @if($ciu->since==$cont.'-01-01')
                                        <option value="{{$cont.'-01-01'}}" selected>{{$cont}}</option>
                                    @else
                                        <option value="{{$cont.'-01-01'}}">{{$cont}}</option>
                                    @endif

                                    @php $cont++; @endphp
                                @endwhile
                            </select>
                            <label for="since">Año</label>
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
    <script src="{{ asset('js/data/timeline-ciiu.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection