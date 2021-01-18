@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="{{ route('push.post') }}" id="mainform">
                    @csrf
                    <div class="card-box">
                        <h1>{{__('Push issuelists to Jira') }}</h1>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Project') }}</label>
                                    <select id="project" name="project" class="form-control select2" required>
                                        <option value="">(maak een keuze)</option>
                                        @foreach($projects as $id => $data)
                                            <option value="{{ $id }}">{{$data['key']}} - {{ $data['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('project')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="reporter">{{ __('Ticket reporter') }}</label>
                                    <select id="reporter" name="reporter" class="form-control select2" required>
                                        <option value="">(maak een keuze)</option>
                                        @foreach($users as $id => $data)
                                            <option value="{{ $id }}">{{ $data['displayName'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('reporter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="float-left"><label for="issuelists">{{ __('Issuelists') }}</label></div>
                                    <div class="float-left m-l-15"><select id="issuelist_tag_filter" class="select2" data-tags="true" data-placeholder="Filter..." data-width="200" multiple>
                                            @foreach($availableTags as $availableTag)<option value="{{$availableTag->name}}">{{$availableTag->name}}</option>@endforeach
                                        </select></div>
                                    <div class="clearfix"></div>
                                    <div id="issueliststagfiltered">
                                        @include('push.issuelists')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-box">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="issuelists"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#mainform")
                .on("change", ".issuelist_checkbox", function(e) {
                    $.ajax({
                        url: route('push.get-issuestable'),
                        type: 'post',
                        data: $('#mainform').serialize(),
                        success: (function(data, textStatus) {
                            $("#issuelists").html(data);
                        })
                    });
                })

                .on('change', '.select-all', function() {
                    $('input:checkbox', $(this).parent().next()).prop('checked', this.checked);
                })

                .on('change', '#issuelist_tag_filter', function() {
                    console.debug('tag filter change');
                    $.ajax({
                        url: route('push.get-issueliststable'),
                        type: 'post',
                        data: {tags: $('#issuelist_tag_filter').val() },
                        success: (function(data, textStatus) {
                            $("#issueliststagfiltered").html(data);
                        })
                    })
                });
        });
    </script>
@endpush
