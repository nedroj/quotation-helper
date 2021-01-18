@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box container-show-bounce">
                    <h4 class="header-title">{{ __('View bounce') }}</h4>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('Subject') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            {{ $bounce->subject }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('Server') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9 email-server" style="--color: {{ $bounce->server->color }}">
                            {{ $bounce->server->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('To') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            {{ $bounce->address_to }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('From') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            {{ $bounce->address_from }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('Description') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            {{ $bounce->description }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('Details') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            {{ $bounce->details }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('Name') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            {{ $bounce->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('Tag') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            {{ $bounce->tag }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('Type') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            {{ $bounce->type }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <strong>{{ __('Bounced at') }}</strong>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-9">
                            {{ $bounce->bounced_at->format('d-m-Y H:i') }}
                        </div>
                    </div>


                    <a class="btn btn-postmark"
                       href="{{ $bounce->postmark_url }}"
                       target="_blank">
                        {{ __('View in postmark') }}
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
