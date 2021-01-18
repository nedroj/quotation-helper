@extends('layouts.auth')

@section('content')
    <form method="POST" class="form-horizontal m-t-20" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group row">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                    </div>
                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" autocomplete="username" value="{{ old('username', '') }}" placeholder="{{ __('Email address') }}" autofocus required>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <button class="btn btn-primary" type="submit">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </div>
    </form>
@endsection
