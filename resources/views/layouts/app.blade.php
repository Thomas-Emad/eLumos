<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'eLumos') }} | @yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    @yield('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#fafafa] dark:bg-gray-800 dark:text-gray-100">
    <div id="loader"
        class="fixed top-0 left-0 w-screen h-screen bg-white dark:bg-gray-900 z-[5000] flex items-center justify-center">
        <img src="{{ asset('assets/images/favicon.png') }}" class="w-20 h-20" alt="Loading Site">
    </div>



    @if (session('notification'))
        @include('components.notifications.' . session('notification.type'))
    @endif
    <div class="notifications"></div>

    <div class="min-h-screen">
        @include('layouts.header')

        <!-- Page Content -->
        <main>
            @yield('content')

        </main>

        @include('layouts.footer')
    </div>

    {{-- Script JS --}}
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    @yield('js')

</body>

</html>
