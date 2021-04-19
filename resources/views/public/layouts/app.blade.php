<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/vendor/share.js') }}" type="text/javascript"></script> --}}
    {{-- <script src="{{ asset('js/functions.js') }}" type="text/javascript"></script> --}}
    <!-- Animation -->
    <script src="{{ asset('js/vendor/aos.js')}}" type="text/javascript"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/aos.css') }}" rel="stylesheet">


</head>

<body>
    <div id="appa">
        @include('public.layouts.navbar')
        @yield('content')
        @include('public.layouts.footer')
    </div>
</body>
<style>
    body {
        background-color: #009688;
        /* background-image: linear-gradient(180deg, #009688 10%, #055048 100%); */
        background-size: cover;
        height: 100%;
    }

    .bg-login-image {
        background: url(https://source.unsplash.com/K4mSJ7kc0As/600x800);
        background-position-x: 0%;
        background-position-y: 0%;
        background-size: auto;
        background-position: center;
        background-size: cover;
    }
</style>

</html>