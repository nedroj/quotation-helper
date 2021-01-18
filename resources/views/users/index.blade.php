@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="table-responsive table-striped">
                        <h4 class="header-title">{{ __('Manage users') }}</h4>
                        <a href="{{ route('users.create') }}" class="btn btn-primary float-right"><i class="far fa-user-plus"></i> {{ __('Add user') }}</a>

                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', [$user]) }}">{{ __('Edit') }}</a>
                                        <form action="{{ route('users.destroy', [$user]) }}" method="POST" class="float-right destroyform">
                                            @method('DELETE')
                                            @csrf
                                            <button>{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">{{ __('No users found') }}.</td>
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
