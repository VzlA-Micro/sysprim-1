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
            <div class="col s12 m8 offset-m2">
                <form id="ciuu" method="post" class="card">
                    <div class="card-header center-align">
                        <h5>Registrar Ramo CIIU</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12">
                            <i class="icon-featured_play_list prefix"></i>
                            <select name="groupCiiu" id="groupCiiu" required>
                                <option value="" disabled selected>Elije una opción...</option>
                                @foreach($groupCiiu as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <label for="type">Grupo CIIU</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-check prefix"></i>
                            <input id="name" type="text" name="name" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-confirmation_number prefix"></i>
                            <input id="code" type="text" name="code" required>
                            <label for="code">Codigo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-attach_money prefix"></i>
                            <input id="alicuota" type="text" name="alicuota" required>
                            <label for="alicuota">Alicuota</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="icon-attach_money prefix"></i>
                            <input id="mTM" type="text" name="mTM" required>
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
@endsection