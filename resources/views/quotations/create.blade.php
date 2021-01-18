@extends('layouts.app')

@section('content')
    @yield('content')
    <div id="example-component">
        <template>
            <div class="container-fluid">
                <div>
                    <flash-message></flash-message>
                </div>
                <div class="row">

                    <selecter-epic-component></selecter-epic-component>
                </div>
            </div>
        </template>
    </div>
@endsection
