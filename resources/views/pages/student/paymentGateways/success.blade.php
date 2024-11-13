@extends('layouts.app')
@section('title', 'Purchase completed')
@section('description', 'course details')


@section('content')
    <div
        class="container mx-auto p-4 mt-16 max-w-screen-xl min-h-screen -translate-x-full an-section an-right text-gray-900 flex flex-col items-center justify-center gap-4">
        <img src="{{ asset('assets/images/congratulation.png') }}" alt="success" class="w-64 mx-auto">
        <h1 class="font-bold text-2xl">Congratulations, your purchase has been successful.</h1>
        <a href="{{ route('dashboard.courses-list') }}"
            class="py-2 px-4 text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 font-medium rounded-lg text-sm dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800">
            Your Courses
        </a>
    </div>

@endsection
