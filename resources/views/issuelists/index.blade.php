@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="table-responsive table-striped">
                        <h4 class="header-title">{{ __('Manage issuelists') }}</h4>

                        <a href="{{ route('issuelists.create') }}" class="btn btn-primary float-right">{{ __('Add issuelist') }}</a>
                        <a href="{{ route('push.get') }}" class="m-r-10 btn btn-success float-right">{{ __('Push') }}</a>
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($issuelists as $issuelist)
                                <tr>
                                    <td><a href="{{ route('issuelists.show', [$issuelist]) }}">{{ $issuelist->name }}</a></td>
                                    <td>
                                        <a href="{{ route('issuelists.edit', [$issuelist]) }}">{{ __('Edit') }}</a>
                                        <form action="{{ route('issuelists.destroy', [$issuelist]) }}" method="POST" class="float-right">
                                            @method('DELETE')
                                            @csrf
                                            <button>{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{ __('No issuelists found') }}.</td>
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
