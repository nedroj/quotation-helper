<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="auth">
    <div id="app">
        <div class="wrapper-page">

            <div class="text-center">
                <a class="logo-lg">
                    <img src="{{ asset('images/doit-logo.png') }}" alt="DO-IT portal">
                </a>

                <h1>{{ config('app.name') }}</h1>
            </div>
            @include('layouts.partials.alerts')

            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>