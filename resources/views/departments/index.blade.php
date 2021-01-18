@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="table-responsive table-striped">
                        <h4 class="header-title">{{ __('Manage Departments') }}</h4>
                        <a href="{{ route('departments.create') }}" class="btn btn-primary float-right"><i class="far fa-user-plus"></i> {{ __('Add department') }}</a>
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $department)
                                <tr>
                                    <td>{{ $department->name }}</td>
                                    <td>
                                        <a href="{{ route('departments.edit', [$department]) }}">{{ __('Edit') }}</a>
                                        <form action="{{ route('departments.destroy', [$department]) }}" method="POST"
                                              class="float-right destroyform">
                                            @method('DELETE')
                                            @csrf
                                            <button>{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
