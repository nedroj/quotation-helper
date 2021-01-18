@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h1>{{ $department->exists ? __('Edit department') : __('Add department') }}</h1>
                    <form method="post"
                          action="{{ route($department->exists ? 'departments.update' : 'departments.store', [$department]) }}">
                        @csrf
                        @if($department->exists)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{old('name', $department->name)}}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="abbreviation">{{ __('Abbreviation') }}</label>
                                    <input type="text"
                                           class="form-control @error('abbreviation') is-invalid @enderror"
                                           id="abbreviation"
                                           name="abbreviation"
                                           value="{{old('abbreviation', $department->abbreviation)}}">
                                    @error('abbreviation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

{{--@push('scripts')--}}
{{--    {!! JsValidator::formRequest(\App\Http\Requests\UserFormRequest::class) !!}--}}
{{--@endpush--}}
