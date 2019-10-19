@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form method="post" action="{{ route('password.email') }}" class="col s12 m8 offset-m2">
                @if (session('status'))
                <div class="alert alert-success col s12" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card bg-light-opacity-8">
                    <div class="card-header center-align">
                        <h5>Resetear Contraseña</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12">
                            <label for="email">{{ __('E-Mail') }}</label>
                            <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn blue waves-effect waves-light">{{ __('Enviar Código para reestablecer Contraseña') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection