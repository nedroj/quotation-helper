@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h1>{{ $issuelist->exists ? __('Edit issuelist') : __('Add issuelist') }}</h1>
                    <form method="post" action="{{ route($issuelist->exists ? 'issuelists.update' : 'issuelists.store', [$issuelist]) }}">
                        @csrf
                        @if($issuelist->exists)
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{old('name', $issuelist->name)}}"
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tags">{{ __('Tags') }}</label>
                                    <select class="form-control select2 @error('tags') is-invalid @enderror"
                                            id="tags"
                                            data-tags="true"
                                            name="tags[]" multiple>
                                        @foreach($availableTags as $availableTag)
                                            <option
                                                @if(in_array($availableTag->name, $currentTags)) selected @endif
                                                value="{{ $availableTag->name }}">{{ $availableTag->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tags')
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

@push('scripts')
    {!! JsValidator::formRequest(\App\Http\Requests\IssuelistFormRequest::class) !!}
@endpush
