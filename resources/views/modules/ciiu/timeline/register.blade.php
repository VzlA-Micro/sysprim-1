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
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.timeline.manage') }}">Gestionar Linea de Tiempo-CIIU</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.timeline.register') }}">Registrar Linea de Tiempo-CIIU</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">

                <form id="register" method="#" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Ramo CIIU</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12">
                            <i class="icon-featured_play_list prefix"></i>
                            <select name="ciu_id" id="ciu_id" >
                                <option value="null" disabled selected>Elije una opción...</option>
                                @foreach($ciiu as $ciu)
                                    <option value="{{ $ciu->id }}">{{ $ciu->name }}</option>
                                @endforeach
                            </select>
                            <label for="type">Ramo CIIU</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>   
                            <input id="alicuota" type="text" name="alicuota" class="validate  number-only-float" required maxlength="2">
                            <label for="alicuota">Alicuota</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="prefix">
                                <img src="{{ asset('images/isologo-BsS.png') }}" style="width: 2rem" alt="BsS" width="100%" height="100%">
                            </i>   
                            <input id="mTM" type="text" name="mTM"  class="validate number-only"  maxlength="5" required>
                            <label for="mTM">Minimo de Tributo Mensual</label>
                        </div>


                        @php
                            $cont=(int)date('Y');
                        @endphp

                        <div class="input-field col s12 m12">
                            <i class="icon-date_range prefix"></i>
                            <select name="since" id="since">
                                <option value="null">Seleccione</option>
                                @while($cont <= 2030)
                                    <option value="{{$cont.'-01-01'}}">{{$cont}}</option>
                                    @php $cont++; @endphp
                                @endwhile
                            </select>
                            <label for="since">Año</label>
                        </div>

                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light">Registrar
                            <i class="icon-send right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/data/timeline-ciiu.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection