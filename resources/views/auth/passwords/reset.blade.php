@extends('layouts.auth')

@section('content')
    <form method="POST" class="form-horizontal m-t-20" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group row">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                    </div>
                    <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" autocomplete="username" value="{{ old('username', '') }}" placeholder="{{ __('E-Mail Address') }}" autofocus required>

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
                    <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" placeholder="{{ __('Password') }}" autocomplete="new-password" required>

                    @error('password')
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
                    <input class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" type="password" placeholder="{{ __('Confirm Password') }}" autocomplete="new-password" required>
                    @if($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <button class="btn btn-primary" type="submit">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </div>

        @include('partials.capslockwarning')
    </form>
@endsection
