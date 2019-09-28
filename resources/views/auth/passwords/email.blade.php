@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <form method="post" action="{{ route('password.email') }}" class="col s12 m8 offset-m2">
                <div class="card">
                    <div class="card-header">
                        {{ __('Reset Password') }}
                    </div>
                    <div class="card-content row">
                        @if (session('status'))
                        <div class="alert alert-success col s12" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        @csrf
                        <div class="input-field col s12">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" name="email" class="validate" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn blue waves-effect waves-light">{{ __('Send Password Reset Link') }}</button>
                    </div>
                </div>
            </form>
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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
