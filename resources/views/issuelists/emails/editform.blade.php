@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h1>{{ $email->exists ? __('Edit email') : __('Add email') }}</h1>
                    <form method="post" action="{{ route($email->exists ? 'issuelists.emails.update' : 'issuelists.emails.store', [$email->issuelist, $email]) }}" enctype="multipart/form-data">
                        @csrf
                        @if($email->exists)
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="subject">{{ __('Subject') }}</label>
                                    <input type="text"
                                           class="form-control @error('subject') is-invalid @enderror"
                                           id="subject"
                                           name="subject"
                                           value="{{ old('subject', $email->subject) }}"
                                    >
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="subject">{{ __('Default recipient') }}</label>
                                    <input type="text"
                                           class="form-control @error('default_recipient') is-invalid @enderror"
                                           id="default_recipient"
                                           name="default_recipient"
                                           value="{{ old('default_recipient', $email->default_recipient) }}"
                                    >
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="attachments">{{ __('Attachments') }}</label>
                                    <input type="file" class="form-control-file" id="attachments" name="attachments[]" multiple>

                                    <ul>
                                    @foreach($email->getMedia('attachments') as $media)
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
                                    <label for="name">{{ __('Body') }}</label>
                                    <textarea class="form-control @error('body') is-invalid @enderror summernote"
                                              id="body"
                                              name="body"
                                    >{{ old('body', $email->body) }}</textarea>
                                    @error('body')
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
    {!! JsValidator::formRequest(\App\Http\Requests\EmailFormRequest::class) !!}
    <script>
        $(function() {
            $(".deleteattachement").click(function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
            })
        })
    </script>
@endpush
