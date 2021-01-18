@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h1>{{ $user->exists ? __('Edit user') : __('Add user') }}</h1>
                    <form method="post"
                          action="{{ route($user->exists ? 'users.update' : 'users.store', [$user]) }}">
                        @csrf
                        @if($user->exists)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="first_name">{{ __('Name') }}</label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{old('name', $user->name)}}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{old('email', $user->email)}}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password">{{ __('Password') }}</label>
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   id="password"
                                                   name="password">
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">{{ __('Password confirmation') }}</label>
                                            <input type="password"
                                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                                   id="password_confirmation"
                                                   name="password_confirmation">
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest(\App\Http\Requests\UserFormRequest::class) !!}
@endpush
