@extends('layouts.auth')

@section('content')
    <form method="POST" class="form-horizontal m-t-20" action="{{ route('login') }}">
        @csrf

        <div class="form-group row">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                    </div>
                    <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" autocomplete="username" value="{{ old('email', '') }}" placeholder="{{ __('Email address') }}" autofocus required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="mdi mdi-lock"></i></span>
                    </div>
                    <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" placeholder="{{ __('Password') }}" autocomplete="current-password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6">
                <div class="m-l-15 m-t-10 checkbox checkbox-primary">
                    <input id="checkbox-signup" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="checkbox-signup">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>

            <div class="col-sm-6">
                <button class="btn btn-primary" type="submit">
                    {{ __('Login') }}
                </button>
            </div>
        </div>

        @if (Route::has('password.request'))
            <div class="form-group row m-t-10">
                <div class="col-12">
                    <a href="{{ route('password.request') }}" class="text-muted text-ww-vergeten">
                        <i class="fa fa-lock m-r-5"></i>
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            </div>
        @endif

        @include('partials.capslockwarning')
    </form>
@endsection
