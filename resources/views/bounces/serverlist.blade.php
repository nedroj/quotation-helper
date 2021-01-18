@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="table-responsive table-striped">
                        <h4 class="header-title">{{ __('Overview servers') }}</h4>
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th width="35px"></th>
                                <th>{{ __('Name') }}</th>
                                <th width="150px"></th>
                                <th width="200px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($servers as $server)
                                <tr>
                                    <td class="email-server" style="--color: {{ $server->Color }}"></td>
                                    <td>{{ $server->Name }}</td>
                                    <td>
                                        <a class="btn btn-postmark btn-sm" href="{{ $server->ServerLink }}" target="_blank">
                                            {{ __('View in postmark') }}
                                        </a>
                                    </td>
                                    <td>
                                        @if(strlen($server->bouncehookurl) === 0)
                                            <form method="post" action="{{ route('email.servers.webhook.add', ['servertoken' => $server->ApiTokens[0], 'serverid' => $server->id]) }}">
                                                @csrf
                                                <button class="btn btn-primary btn-sm" type="submit">
                                                    {{ __('Add bounce webhook') }}
                                                </button>
                                            </form>
                                        @else
                                            <form method="post" action="{{ route('email.servers.webhook.delete', ['servertoken' => $server->ApiTokens[0], 'webhookid' => \App\EmailBounce::getWebhooks($server->ApiTokens[0])->webhooks[0]->id]) }}">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" type="submit">
                                                    {{ __('Remove bounce webhook') }}
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{ __('No servers found') }}.</td>
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
