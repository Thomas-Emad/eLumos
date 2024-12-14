@extends('layouts.app')
@section('title', 'Categoires')

@section('css')
    <style>
        body {
            background-color: #eee !important;
        }
    </style>
@endsection

@section('content')
    <div class="min-h-60 bg-center bg-contain relative mt-16 flex items-center"
        style="background-image: url({{ asset('assets/images/dashboard.jpg') }})">
        <div class="absolute top-0 left-0 w-full h-full z-[1] bg-[#22222299] "></div>
        <div class="container mx-auto max-w-screen-xl px-4 py-8 relative z-[2] text-white text-center">
            <h1 class="text-6xl font-bold">@yield('title')</h1>
        </div>
    </div>
    <div class="container mx-auto max-w-screen-xl p-4 text-gray-900 dark:text-gray-100">
        <div class="grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-5 mt-6">
            @foreach ($topCatgeoiresUsed as $item)
                <a href="{{ route('courses', ['category' => $item->category->id]) }}"
                    class="flex flex-col items-center p-4 px-16 bg-white border border-gray-200 rounded-lg hover:-translate-y-2 hover:shadow-md transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/' . $item->category->url) }}" class="h-8 w-8"
                        alt="icon $item->name"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/icons/categories/where.png') }}';">
                    <span class="font-bold text-xl my-2 whitespace-nowrap">{{ $item->category->name }}</span>
                    <span class="text-gray-700 dark:text-gray-200 text-sm">{{ $item->count }} Courses</span>
                </a>
            @endforeach
        </div>
    </div>
@endsection
