@extends('layouts.app')
@section('title', 'Privacy Policy')

@section('content')
    <div class="min-h-60 bg-center bg-contain relative mt-16 flex items-center"
        style="background-image: url({{ asset('assets/images/dashboard.jpg') }})">
        <div class="absolute top-0 left-0 w-full h-full z-[1] bg-[#22222299] "></div>
        <div class="container mx-auto max-w-screen-xl px-4 py-8 relative z-[2] text-white text-center">
            <h1 class="text-6xl font-bold">@yield('title')</h1>
        </div>
    </div>
    <div class="container mx-auto max-w-screen-xl p-4 text-gray-900 dark:text-gray-100">
        <div class="text-2xl font-bold mb-2">
            <h2>Effective date: <span class="text-amber-700">23rd of March, 2022</span></h2>
        </div>
        <div class="mb-2">
            <h3 class="text-lg font-bold">This is a H1, Perfect's for titles.</h3>
            <p class="my-1 text-gray-800 dark:text-gray-200 text-sm">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Stress, for the United States element ante. Duis
                cursus, mi quis viverra ornare, eros pain, sometimes none at all, freedom of the living creature was as the
                profit and financial security. Jasmine neck adapter and just running it lorem makeup sad smile of the
                television set.
            </p>
        </div>
        <div class="mb-2">
            <h3 class="text-lg font-bold">This is a H1, Perfect's for titles.</h3>
            <p class="my-1 text-gray-800 dark:text-gray-200 text-sm">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Stress, for the United States element ante. Duis
                cursus, mi quis viverra ornare, eros pain, sometimes none at all, freedom of the living creature was as the
                profit and financial security. Jasmine neck adapter and just running it lorem makeup sad smile of the
                television set.
            </p>
        </div>
        <div class="mb-2">
            <h3 class="text-lg font-bold">This is a H1, Perfect's for titles.</h3>
            <p class="my-1 text-gray-800 dark:text-gray-200 text-sm">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Stress, for the United States element ante. Duis
                cursus, mi quis viverra ornare, eros pain, sometimes none at all, freedom of the living creature was as the
                profit and financial security. Jasmine neck adapter and just running it lorem makeup sad smile of the
                television set.
            </p>
        </div>
        <div class="mb-2">
            <h3 class="text-lg font-bold">This is a H1, Perfect's for titles.</h3>
            <p class="my-1 text-gray-800 dark:text-gray-200 text-sm">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Stress, for the United States element ante. Duis
                cursus, mi quis viverra ornare, eros pain, sometimes none at all, freedom of the living creature was as the
                profit and financial security. Jasmine neck adapter and just running it lorem makeup sad smile of the
                television set.
            </p>
        </div>
    </div>
@endsection

@section('js')
@endsection
