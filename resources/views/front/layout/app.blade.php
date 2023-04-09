<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ahmad Chebbo">
    <link rel="shortcut icon" href="favicon.png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="session-id" content="{{ session()->getId() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('front/css/tiny-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">

        @include('front.includes.header')
        <main>
            @yield('content')
        </main>

    </div>

    @include('front.includes.footer')


    <script src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('front/js/tiny-slider.js') }}"></script>
	<script src="{{ asset('front/js/custom.js') }}"></script>
    {{-- @auth --}}
    <script>
        localStorage.setItem('token', "{{ Cookie::get('token') }}")
    </script>
    {{-- @endauth --}}
</body>

</html>
