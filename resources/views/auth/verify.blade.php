@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Verify Your Email Address') }}
                    </div>
                    <div class="card-content">
                        @if (session('resent'))
                            <div class="alert alert-success">
                                {{ __('Se ha enviado un código de verificación a tu dirección de E-mail para restablecer tu contraseña.') }}
                            </div>
                        @endif
                        {{ __('Antes de proceder, por favor verifica tu código para restablecer tu contraseña.') }}
                        {{ __('Si no has recbido un código aún') }}, <a href="{{ route('verification.resend') }}">{{ __('click aqui para obtener un nuevo código.') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://kit.fontawesome.com/e3f4029a28.js" crossorigin="anonymous"></script>
@endsection