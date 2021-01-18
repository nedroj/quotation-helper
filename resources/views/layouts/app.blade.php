<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="fixed-left">

    @include('layouts.partials.ajax-loader')

    <div id="wrapper">
        @include('layouts.partials.topbar')

        @include('layouts.partials.leftbar')

        <div class="content-page">
            <div class="content">
                @include('layouts.partials.alerts')

                @yield('content')
            </div>
        </div>
    </div>
    @routes
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
