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
                    <li class="breadcrumb-item"><a href="{{ route('ciu-branch.register') }}">Registrar Ramo CIIU</a></li>
                </ul>            
            </div>
            <div class="col s12 m8 offset-m2">

                <form id="ciuu" method="#" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Ramo CIIU</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12">
                            <i class="icon-featured_play_list prefix"></i>
                            <select name="idGroupCiiu" id="idGroupCiiu" >
                                <option value="null" disabled selected>Elije una opción...</option>
                                @foreach($groupCiiu as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <label for="type">Grupo CIIU</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input id="code" type="text" name="code"  class="validate code-only" required minlength="5" maxlength="15">
                            <label for="code">Codigo</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <input id="name" type="text" name="name" class="validate" required  minlength="5" maxlength="200">
                            <label for="name">Nombre</label>
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
    <script src="{{ asset('js/dev/ciiu.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection