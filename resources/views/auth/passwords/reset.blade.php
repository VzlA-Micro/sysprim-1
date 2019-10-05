@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form method="POST" action="{{ route('password.update') }}" class="card">
                    <div class="card-header center-align">
                        {{ __('Reset Password') }}
                    </div>
                    <div class="card-content row">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="input-field col s12">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required>
                        </div>
                        <div class="input-field col s12">
                            <input id="password" type="password" name="password" required>
                            <label for="password">{{ __('Password') }}</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="password-confirm" type="password" name="password_confirmation" required>
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-outline-success waves-effect waves-green">
                            <i class="icon-send right"></i>
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
{{-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    <form method="POST" action="">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
