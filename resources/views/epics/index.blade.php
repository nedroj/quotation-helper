@extends('layouts.app')

@section('content')
    @yield('content')
    <div id="example-component">
        <template>
            <div class="container-fluid">
                {{--                <alert-component v-if="successmessage"></alert-component>--}}
                <flash-message></flash-message>
                <div class="col-lg-12 row">
                    <epics-component @inputepic="updateEpic"></epics-component>
                </div>
            </div>
        </template>
    </div>
@endsection
