@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h1>{{ $issue->exists ? __('Edit issue') : __('Add issue') }}</h1>
                    <form method="post" action="{{ route($issue->exists ? 'issuelists.issues.update' : 'issuelists.issues.store', [$issue->issuelist, $issue]) }}" enctype="multipart/form-data">
                        @csrf
                        @if($issue->exists)
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
                                           value="{{old('name', $issue->name)}}"
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="default_project">{{ __('Default project') }}</label>
                                    <select name="default_project" class="form-control select2">
                                        <option value="">{{ __('No default') }}</option>
                                        @foreach(\App\Services\JiraService::getProjects() as $project)
                                            <option value="{{ $project['key'] }}"{{ $issue->default_project === $project['key'] ? ' selected' : '' }}>{{ $project['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('default_project')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="default_reporter">{{ __('Default reporter') }}</label>
                                    <select name="default_reporter" class="form-control select2">
                                        <option value="">{{ __('No default') }}</option>
                                        @foreach(\App\Services\JiraService::getUsers() as $userId => $user)
                                            <option value="{{ $userId }}"{{ $issue->default_reporter === $userId ? ' selected' : '' }}>{{ $user['displayName'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('default_reporter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="default_assignee">{{ __('Default assignee') }}</label>
                                    <select name="default_assignee" class="form-control select2">
                                        <option value="">{{ __('No default') }}</option>
                                        @foreach(\App\Services\JiraService::getUsers() as $userId => $user)
                                            <option value="{{ $userId }}"{{ $issue->default_assignee === $userId ? ' selected' : '' }}>{{ $user['displayName'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('default_assignee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="original_estimate">{{ __('Original estimate (minutes)') }}</label>
                                    <input type="number"
                                           class="form-control @error('original_estimate') is-invalid @enderror"
                                           id="original_estimate"
                                           name="original_estimate"
                                           value="{{ old('original_estimate', $issue->original_estimate) }}">
                                </div>

                                <div class="form-group">
                                    <label for="attachments">{{ __('Attachments') }}</label>
                                    <input type="file" class="form-control-file" id="attachments" name="attachments[]" multiple>

                                    @foreach($issue->getMedia('attachments') as $media)
                                        <div>
                                            <input type="hidden" name="keepattachments[]" value="{{ $media->id }}">
                                            <a href="{{ $media->getFullUrl() }}" download>{{ $media->file_name }}</a>
                                            <a href="#" class="deleteattachement"><i class="fa fa-times"></i></a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="name">{{ __('Description') }}</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror summernote"
                                              id="description"
                                              name="description"
                                    >{{ old('description', $issue->description) }}</textarea>
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

@push('scripts')
    {!! JsValidator::formRequest(\App\Http\Requests\IssueFormRequest::class) !!}
    <script>
        $(function() {
            $(".deleteattachement").click(function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
            })
        })
    </script>
@endpush
