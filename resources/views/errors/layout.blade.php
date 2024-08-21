@extends('layouts.app')
@yield('title')

@section('content')
    <div class="container mx-auto max-w-screen-xl p-4  mt-16">
        <div class="flex flex-col items-center">
            <img src="{{ asset('assets/images/error.png') }}" alt="Error photo" class="w-2/3">
            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100" class="margin-top:-20px"> @yield('message')</p>
        </div>
    </div>
@endsection
