@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="header-title">{{ __('View project quotations') }}</h4>
                    <table class="table mb-0">
                        <tbody>
                        <tr>
                            <th scope="row">{{ __('Name') }}</th>
                            <td>{{ $project->title }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="m-t-20">
                        {{--                        <a href="{{ route('issuelists.edit', [$project]) }}" class="btn btn-primary">{{ __('Edit') }}</a>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="table-responsive table-striped">
                        {{--                        <h4 class="header-title">{{ __('Manage quotations') }}</h4>--}}
                        {{--                                                <a href="{{ route('quotations.show', [$project]) }}" class="btn btn-primary float-right">{{ __('Add quotation') }}</a>--}}

                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>{{ __('Round') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Options') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($project->projectQuotations as $projectQuotation)
                                <tr>
                                    <td>{{ $projectQuotation->round}}</td>
                                    {{--<td>{{$projectQuotation->quotation}}</td>--}}
                                    <td>{{ $projectQuotation->quotation->status->title}}</td>
                                    <td>
                                        {{--<a href="{{ route('issuelists.issues.edit', [$issuelist, $issue]) }}">{{ __('Edit') }}</a>--}}
                                        <a class="fa fa-file-pdf-o" href="{{route('quotations.pdf', $projectQuotation->quotation)}}">
                                            <span class="menu-icon"><i class="fa fa-file-pdf" aria-hidden="true"></i></span>
                                            {{ __('Pdf') }}
                                        </a>
                                        <form action="{{ route('quotations.destroy', [$projectQuotation->quotation]) }}"
                                              method="POST" class="float-right">
                                            @method('DELETE')
                                            @csrf
                                            <button>{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{ __('No quotations found') }}.</td>
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
