@extends('layouts.app')
@section('title', 'purchase canceled')
@section('description', 'course details')


@section('content')
    <div
        class="container mx-auto p-4 mt-16 max-w-screen-xl min-h-screen -translate-x-full an-section an-right text-gray-900 flex flex-col items-center justify-center gap-4">
        <img src="{{ asset('assets/images/canceled.png') }}" alt="canceled" class="w-64 mx-auto">
        <h1 class="font-bold text-2xl">
            It seems that you have cancelled the transaction or the bank that provided it to you has rejected it..
        </h1>
        <a href="{{ route('baskets') }}"
            class="py-2 px-4 text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 font-medium rounded-lg text-sm dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800">
            Back
        </a>
    </div>

@endsection
