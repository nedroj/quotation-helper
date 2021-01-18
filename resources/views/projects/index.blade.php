@extends('layouts.app')

@section('content')
    @yield('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="table-responsive table-striped">
                        <h4 class="header-title">{{ __('Manage projects') }}</h4>

{{--                        <a href="{{ route('projects.create') }}" class="btn btn-primary float-right">{{ __('Add project') }}</a>--}}
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>{{ __('title') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td><a href="{{ route('projects.show', [$project]) }}">{{ $project->title }}</a></td>
                                    <td>
{{--                                        <a href="{{ route('projects.edit', [$project]) }}">{{ __('Edit') }}</a>--}}
                                        <form action="{{ route('projects.destroy', [$project]) }}" method="POST" class="float-right">
                                            @method('DELETE')
                                            @csrf
                                            <button>{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{ __('No projects found') }}.</td>
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
