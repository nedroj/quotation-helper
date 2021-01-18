@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h1>{{ $epic->exists ? __('Edit epic') : __('Add epic') }}</h1>
                    <form method="post"
                          action="{{ route($epic->exists ? 'epics.update' : 'epics.store', [$epic]) }}">
                        @csrf
                        @if($epic->exists)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="title">{{ __('Title') }}</label>
                                    <input type="text"
                                           class="form-control @error('Title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{old('title', $epic->title)}}">
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">{{ __('Description') }}</label>
                                    <input type="text"
                                           class="form-control @error('Description') is-invalid @enderror"
                                           id="description"
                                           name="description"
                                           value="{{old('description', $epic->description)}}">
                                    @error('description')
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
