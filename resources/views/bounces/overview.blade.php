@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="table-responsive table-striped">
                        <h4 class="header-title">{{ __('Overview bounces') }}</h4>
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>{{ __('Subject') }}</th>
                                <th>{{ __('Server') }}</th>
                                <th>{{ __('To') }}</th>
                                <th>{{ __('From') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($bounces as $bounce)
                                <tr>
                                    <td>{{ $bounce->subject }}</td>
                                    <td class="email-server" style="--color: {{ $bounce->server->color }}">
                                        {{ $bounce->server->name }}
                                    </td>
                                    <td>{{ $bounce->address_to }}</td>
                                    <td>{{ $bounce->address_from }}</td>
                                    <td>{{ $bounce->type }}</td>
                                    <td>
                                        <a href="{{ route('email.bounces.message', [$bounce]) }}">{{ __('Show') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{ __('No bounces found') }}.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
