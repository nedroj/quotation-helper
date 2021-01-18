@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="header-title">{{ __('View issuelist') }}</h4>
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th scope="row">{{ __('Name') }}</th>
                                <td>{{ $issuelist->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Tags') }}</th>
                                <td>
                                    @foreach($issuelist->tags as $tag)
                                        <span class="badge badge-secondary">{{ $tag->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="m-t-20">
                        <a href="{{ route('issuelists.edit', [$issuelist]) }}" class="btn btn-primary">{{ __('Edit') }}</a>

                        <a href="{{ route('issuelists.push', [$issuelist]) }}" class="btn btn-success">{{ __('Push to jira') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="table-responsive table-striped">
                        <h4 class="header-title">{{ __('Manage issues') }}</h4>
                        <a href="{{ route('issuelists.issues.create', [$issuelist]) }}" class="btn btn-primary float-right">{{ __('Add issue') }}</a>

                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($issues as $issue)
                                <tr>
                                    <td>{{ $issue->name }}</td>
                                    <td>
                                        <a href="{{ route('issuelists.show', [$issuelist, 'up' => $issue->id]) }}">
                                            <i class="fa fa-sort-up"></i>
                                        </a>
                                        <a href="{{ route('issuelists.show', [$issuelist, 'down' => $issue->id]) }}">
                                            <i class="fa fa-sort-down"></i>
                                        </a>
                                        <a href="{{ route('issuelists.issues.edit', [$issuelist, $issue]) }}">{{ __('Edit') }}</a>
                                        <form action="{{ route('issuelists.issues.destroy', [$issuelist, $issue]) }}" method="POST" class="float-right">
                                            @method('DELETE')
                                            @csrf
                                            <button>{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{ __('No issues found') }}.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="table-responsive table-striped">
                        <h4 class="header-title">{{ __('Manage emails') }}</h4>
                        <a href="{{ route('issuelists.emails.create', [$issuelist]) }}" class="btn btn-primary float-right">{{ __('Add email') }}</a>

                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>{{ __('Subject') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($emails as $email)
                                <tr>
                                    <td>{{ $email->subject }}</td>
                                    <td>
                                        <a href="{{ route('issuelists.show', [$issuelist, 'email_up' => $email->id]) }}">
                                            <i class="fa fa-sort-up"></i>
                                        </a>
                                        <a href="{{ route('issuelists.show', [$issuelist, 'email_down' => $email->id]) }}">
                                            <i class="fa fa-sort-down"></i>
                                        </a>
                                        <a href="{{ route('issuelists.emails.edit', [$issuelist, $email]) }}">{{ __('Edit') }}</a>
                                        <form action="{{ route('issuelists.emails.destroy', [$issuelist, $email]) }}" method="POST" class="float-right">
                                            @method('DELETE')
                                            @csrf
                                            <button>{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{ __('No emails found') }}.</td>
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
