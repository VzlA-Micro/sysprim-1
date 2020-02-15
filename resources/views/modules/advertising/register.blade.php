@extends('layouts.app')

@section('styles')
    
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
            	<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.manage') }}">Configuración</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('advertising-type.manage') }}">Gestionar Tipo de Publicidad</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('advertising-type.register') }}">Registrar</a></li>
                </ul>
            </div>
            <div class="col s12 m8 offset-m2">
                <form action="" method="post" class="card" id="register">
                    <div class="card-header center-align">
                        <h4>Registrar Tipo de Publicidad</h4>
                    </div>
                    <div class="card-content row">
                        @csrf

                        <div class="input-field col s12">
                            <i class="icon-featured_play_list prefix"></i>
                            <select name="group_id" id="group_id">
                                <option value="null" disabled selected>Elije una opción...</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <label for="type">Grupo CIIU</label>
                        </div>




                        <div class="input-field col s12 m6">
                            <i class="icon-local_library prefix"></i>
                            <input type="text" name="name" id="name" required minlength="3" maxlength="100">
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-looks_one prefix"></i>
                            <input type="text" name="value" id="value" required maxlength="6" class="validate number-date only-number-positive">
                            <label for="value">Valor UTC</label>
                        </div>
                    </div>
                    <div class="card-footer center-align">
                        <button type="submit" class="btn btn-large btn-rounded peach waves-effect waves-light">
                            <i class="icon-send right"></i>
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/data/advertising-type.js') }}"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
@endsection