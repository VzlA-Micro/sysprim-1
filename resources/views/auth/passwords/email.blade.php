@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if (session('status'))
            <div class="alert alert-success col s12" style="margin-top: 1rem">
                {{ session('status') }}
            </div>
            @endif
            <form method="post" action="{{ route('password.email') }}" class="col s12 m8 offset-m2">
                <div class="card bg-light-opacity-8" style="margin-top:40px">
                    <div class="card-header center-align">
                        <h5>Reestablecer Contraseña</h5>
                    </div>
                    <div class="card-content row">
                        @csrf
                        <div class="input-field col s12">
                            <i class="icon-contact_mail prefix"></i>
                            <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">{{ __('E-Mail') }}</label>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn btn-rounded btn-large peach waves-effect waves-light">{{ __('Enviar Código para reestablecer Contraseña') }}
                        <i class="icon-send right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://kit.fontawesome.com/e3f4029a28.js" crossorigin="anonymous"></script>
@endsection