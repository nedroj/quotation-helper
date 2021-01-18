@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h1>{{__('Push issuelist to Jira') }}</h1>
                    <form method="post" action="{{ route('issuelists.post-push', [$issuelist]) }}">
                        @csrf

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name">{{ __('Project') }}</label>
                                    <select id="project" name="project" class="form-control select2">
                                        <option value="">(maak een keuze)</option>
                                        @foreach($projects as $id => $data)
                                            <option value="{{ $id }}">{{$data['key']}} - {{ $data['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('project')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="reporter">{{ __('Ticket reporter') }}</label>
                                    <select id="reporter" name="reporter" class="form-control select2">
                                        <option value="">(maak een keuze)</option>
                                        @foreach($users as $id => $data)
                                            <option value="{{ $id }}">{{ $data['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('reporter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="assignee">{{ __('Ticket assignee') }}</label>
                                    <select id="assignee" name="assignee" class="form-control select2">
                                        <option value="">(maak een keuze)</option>
                                        @foreach($users as $id => $data)
                                            <option value="{{ $id }}">{{ $data['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('assignee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="name">{{ __('Description') }}</label>
                                    <textarea id="description"
                                              name="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                                rows="10">{{old('description')}}</textarea>
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
    {!! JsValidator::formRequest(\App\Http\Requests\PushToJiraRequest::class) !!}
@endpush
