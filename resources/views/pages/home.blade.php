@extends('layouts.app')
@section('title', 'Home')

@section('css')
@endsection

@section('content')
    {{-- Section One  --}}
    <div class="bg-cover bg-no-repert bg-left md:bg-center mt-4"
        style="height:400px;background-image:url('{{ asset('assets/images/landing.png') }}')">
        <div class="max-w-screen-xl container mx-auto p-4  flex items-center min-h-full">
            <div>
                <h1 class="font-bold text-5xl text-black">
                    Build Skills with <br> Online Course
                </h1>
                <p class="mt-2 text-gray-700">We understand the amount of time and your success, it's all
                    only here.</p>
            </div>
        </div>
    </div>

    {{-- Section Two (Categories) --}}
    <div class="container mx-auto p-4 mt-4 max-w-screen-xl -translate-x-full  an-section an-right">
        <div class="flex items-center justify-between flex-col gap-2 md:flex-row">
            <div class="text-center md:text-left">
                <h2 class="font-bold text-2xl">Top Categories</h2>
                <p class="text-gray-700 dark:text-gray-200">Explore our Popular Categories</p>
            </div>
            <a href="{{ route('categories') }}"
                class="block px-6 py-3 rounded-full text-gray-800 dark:text-gray-200 border-2 border-gray-800 hover:border-black hover:text-black dark:border-gray-200 dark:hover:border-amber-700 duration-300">All
                Categories</a>
        </div>
        <div class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-5 mt-6">
            @foreach ($content['categories'] as $item)
                <a href="{{ route('courses', ['category' => $item->category->id]) }}"
                    class="flex flex-col items-center p-4 px-16 border border-gray-200 rounded-lg hover:-translate-y-2 hover:shadow-md transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/' . $item->category->url) }}" class="h-8 w-8"
                        alt="icon $item->name"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/icons/categories/where.png') }}';">
                    <span class="font-bold text-xl my-2 whitespace-wrap text-center">{{ $item->category->name }}</span>
                    <span class="text-gray-700 dark:text-gray-200 text-sm">{{ $item->count }} Courses</span>
                </a>
            @endforeach
        </div>
        @if (sizeof($content['categories']) == 0)
            <p class="font-bold italic text-center text-gray-500">
                It seems that there are no Categories here.
            </p>
        @endif
    </div>

    <hr class="w-10/12 m-auto my-4">

    {{-- Section Three (courses) --}}
    <div class="container mx-auto p-4 mt-4 max-w-screen-xl -translate-x-full  an-section an-right">
        <div class="flex items-center justify-between flex-col gap-2 md:flex-row">
            <div class="text-center md:text-left">
                <h2 class="font-bold text-2xl">Featured courses</h2>
                <p class="text-gray-700 dark:text-gray-200">Explore our Popular Courses</p>
            </div>
            <a href="{{ route('courses') }}"
                class="block px-6 py-3 rounded-full text-gray-800 dark:text-gray-200 border-2 border-gray-800 hover:border-black hover:text-black dark:border-gray-200 dark:hover:border-amber-700 duration-300">All
                Courses</a>
        </div>
        <div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-5 mt-6">
            @foreach ($content['courses'] as $item)
                <div
                    class="flex flex-col overflow-hidden rounded-xl border border-gray-200 transition-all duration-300 hover:shadow-md hover:-translate-y-2">
                    <a href="{{ route('course-details', $item->course->id) }}" class="relative">
                        <img src="{{ json_decode($item->course?->mockup)?->url }}" alt="photo course">
                        <span
                            class="absolute top-3 left-3 px-3 py-1 bg-gray-900 shadow shadow-gray-800 text-white text-sm rounded-lg">
                            {{ $item->course->category->name }}
                        </span>
                    </a>
                    <div class="p-4 flex flex-col gap-2">
                        <span class="text-sm hover:text-amber-800 duration-200">
                            <span class="text-gray-800 dark:text-gray-200 ">by</span>
                            <a href="{{ route('dashboard.profile', $item->course->user->username) }}" class="font-bold">
                                {{ $item->course->user->name }}
                            </a>
                        </span>
                        <a href="{{ route('course-details', $item->course->id) }}"
                            class="font-bold text-gray-800 dark:text-gray-200 dark:hover:text-amber-500 text-2xl -mt-2 hover:text-black transition">
                            {{ \Str::limit($item->course->title, 20) }}
                        </a>
                        <div class="flex justify-between">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-clock text-amber-600"></i>
                                <span
                                    class="text-sm text-gray-800 dark:text-gray-200">{{ explainSecondsToHumans($item->lectures_sum_video_duration) }}</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-amber-600"></i>
                                <span class="text-sm text-gray-800 dark:text-gray-200">{{ $item->count }} Student</span>
                            </span>
                        </div>
                        <hr>
                        <div class="flex justify-between text-gray-800 dark:text-gray-200">
                            <span
                                class="text-sm">{{ $item->course->price > 0 ? $item->course->price . '$' : 'Free' }}</span>
                            <a href="{{ route('course-details', $item->course->id) }}" class="font-bold">View More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if (sizeof($content['courses']) == 0)
            <p class="font-bold italic text-center text-gray-500">
                It seems that there are no courses here.
            </p>
        @endif
    </div>

    {{-- Section Four (baaner) --}}
    <div class="container mx-auto mt-4 p-4 max-w-screen-xl -translate-x-full an-section an-right ">
        <div class="bg-cover bg-no-repert bg-left md:bg-center rounded-xl flex items-center min-h-60"
            style="background-image:url('{{ asset('assets/images/learn-press.png') }}')">
            <div
                class="text-gray-800 w-96 md:w-1/2 h-fit p-4 md:py-6 bg-[#f3f3f3cf] md:bg-transparent rounded-xl  flex flex-col items-center md:items-start gap-2  mx-auto md:m-0 text-center md:text-start">

                <span>GET MORE POWER FROM</span>
                <h3 class="font-bold text-2xl">LearnPress Add-Ons</h3>
                <p>The next level of Lumos - Lumos Courses. More Powerful,
                    Flexible and Magical
                    Inside.</p>
                <a href="#"
                    class="inline w-fit px-4 py-2  text-white bg-amber-500 hover:bg-amber-600 transition font-bold rounded-full">Explorer
                    Courses</a>
            </div>
        </div>
    </div>

    {{-- Section Five (Counter) --}}
    <div class="container mx-auto mt-4 p-4 max-w-screen-xl -translate-x-full  an-section an-right ">
        <div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4">
            <div
                class="flex flex-col items-center gap-2 bg-gray-100 px-6 py-4 rounded-lg cursor-pointer  transition duration-300 hover:-translate-y-2 dark:bg-gray-700">
                <span class="font-bold text-3xl text-amber-600 counter-target"
                    data-target='{{ $content['counters']->courses }}'>{{ $content['counters']->courses }}</span>
                <span class="font-bold">Courses</span>
            </div>
            <div
                class="flex flex-col items-center gap-2 bg-gray-100 px-6 py-4 rounded-lg cursor-pointer  transition duration-300 hover:-translate-y-2 dark:bg-gray-700">
                <span class="font-bold text-3xl text-amber-600 counter-target"
                    data-target='{{ $content['counters']->students }}'>{{ $content['counters']->students }}</span>
                <span class="font-bold">Active Students</span>
            </div>
            <div
                class="flex flex-col items-center gap-2 bg-gray-100 px-6 py-4 rounded-lg cursor-pointer  transition duration-300 hover:-translate-y-2 dark:bg-gray-700">
                <span class="font-bold text-3xl text-amber-600 counter-target"
                    data-target='{{ $content['counters']->instructors }}'>{{ $content['counters']->instructors }}</span>
                <span class="font-bold">Instructors</span>
            </div>
            <div
                class="flex flex-col items-center gap-2 bg-gray-100 px-6 py-4 rounded-lg cursor-pointer  transition duration-300 hover:-translate-y-2 dark:bg-gray-700">
                <span class="font-bold text-3xl text-amber-600 counter-target"
                    data-target='{{ $content['counters']->earns }}'>{{ $content['counters']->earns }}</span>
                <span class="font-bold">Our Sales</span>
            </div>
        </div>
    </div>

    <hr class="w-10/12 m-auto my-4">

    {{-- Section Six (Grow Your Skills) --}}
    <div class="container mx-auto mt-4 p-4 max-w-screen-xl -translate-x-full  an-section an-right ">
        <div class="flex flex-col items-center  md:flex-row gap-6">
            <img class="w-full md:w-1/2" src="{{ asset('assets/images/grow-up.png') }}" alt="grow up your skills"
                style="max-width: 100%">
            <div>
                <h3 class="text-4xl ">Grow us your skill <br>
                    with eLumos Online</h3>
                <p class="text-gray-700 dark:text-gray-200 my-4">We have a strong and informative community here, with
                    outstanding teachers
                    in
                    all areas</p>
                <div>
                    <div>
                        <i class="fa-solid fa-check text-green-500"></i> <span
                            class="text-gray-700 dark:text-gray-200">Certificate</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-check text-green-500"></i> <span
                            class="text-gray-700 dark:text-gray-200">Great
                            following</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-check text-green-500"></i> <span
                            class="text-gray-700 dark:text-gray-200">Multiple exams</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-check text-green-500"></i> <span
                            class="text-gray-700 dark:text-gray-200">Continuous
                            development</span>
                    </div>
                </div>
                <a href="#"
                    class="inline-block w-fit mt-4 px-4 py-2  text-white bg-amber-500 hover:bg-amber-600 transition font-bold rounded-full">Explorer
                    Courses</a>
            </div>
        </div>
    </div>

    {{-- Section Siven (Banner) --}}
    <div class="container mx-auto mt-4 p-4 max-w-screen-xl -translate-x-full  an-section an-right">
        <div class="bg-cover bg-no-repert bg-left md:bg-center rounded-xl flex items-center min-h-64"
            style="background-image:url('{{ asset('assets/images/education.png') }}')">
            <div
                class="text-gray-800 w-96 md:w-1/2 h-fit p-4 md:py-6 bg-[#f3f3f3cf] md:bg-transparent rounded-xl  flex flex-col items-center gap-2  mx-auto text-center">
                <span class="font-bold">PROVIDING AMAZING</span>
                <h3 class="font-bold text-3xl">Education Wordpress Theme</h3>
                <p>The next level of eLumos. Learn anytime and anywhere.</p>
                <a href="#"
                    class="inline w-fit px-4 py-2  text-white bg-amber-500 hover:bg-amber-600 transition font-bold rounded-full">Explorer
                    Courses</a>
            </div>
        </div>
    </div>

    {{-- Section (FeedBacks) --}}
    <div class="container mx-auto mt-4 p-4 max-w-screen-xl -translate-x-full  an-section an-right">
        <div class="text-center">
            <h2 class="font-bold text-2xl">Student feedbacks</h2>
            <p class="text-gray-700 dark:text-gray-200 text-sm">What Students Say About Academy eLumos</p>
        </div>
        <div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4 mt-4">
            <div class="flex flex-col gap-2 border border-gray-200 p-4 rounded-xl">
                <img class="w-8 h-8" src="{{ asset('assets/images/icons/quote.png') }}" alt="icon quote">
                <p class="my-2">
                    I must explain to you how all this mistaken . Tdea of denouncing pleasure and praising pain was born and
                    I will give you a complete account of the system and expound
                </p>
                <div>
                    <p class="font-bold">Thomas Emad</p>
                    <span>Designer</span>
                </div>
            </div>
            <div class="flex flex-col gap-2 border border-gray-200 p-4 rounded-xl">
                <img class="w-8 h-8" src="{{ asset('assets/images/icons/quote.png') }}" alt="icon quote">
                <p class="my-2">
                    I must explain to you how all this mistaken . Tdea of denouncing pleasure and praising pain was born and
                    I will give you a complete account of the system and expound
                </p>
                <div>
                    <p class="font-bold">Thomas Emad</p>
                    <span>Designer</span>
                </div>
            </div>
            <div class="flex flex-col gap-2 border border-gray-200 p-4 rounded-xl">
                <img class="w-8 h-8" src="{{ asset('assets/images/icons/quote.png') }}" alt="icon quote">
                <p class="my-2">
                    I must explain to you how all this mistaken . Tdea of denouncing pleasure and praising pain was born and
                    I will give you a complete account of the system and expound
                </p>
                <div>
                    <p class="font-bold">Thomas Emad</p>
                    <span>Designer</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Siven (Banner) --}}
    <div class="container mx-auto mt-4 p-4 max-w-screen-xl -translate-x-full an-section an-right">
        <div class="bg-cover bg-no-repert bg-left md:bg-center rounded-xl min-h-56 p-4 flex justify-between items-center flex-col md:flex-row"
            style="background-image:url('{{ asset('assets/images/let-start.png') }}')">
            <div class="flex gap-4 items-center">
                <img src="{{ asset('assets/images/let-start-icon.png') }}" alt="let start icon">
                <p class="text-gray-800">Let’s Start With Academy eLumos</p>
            </div>
            <div class="flex gap-4">
                <a href="#"
                    class="inline w-fit px-4 py-2  text-amber-600 hover:text-white bg-transparent hover:bg-amber-600 border-2 border-amber-600 transition font-bold rounded-full">I'm
                    Student</a>
                <a href="#"
                    class="inline w-fit px-4 py-2  text-white  bg-amber-600 hover:bg-amber-700 transition border-2 border-amber-600 font-bold rounded-full">Explorer
                    Courses</a>
            </div>
        </div>
    </div>

    <hr class="w-10/12 m-auto my-4">

    {{-- Section (Articles) --}}
    <div class="container mx-auto mt-4 p-4 max-w-screen-xl -translate-x-full  an-section an-right">
        <div class="flex items-center justify-between flex-col gap-2 md:flex-row">
            <div class="text-center md:text-left">
                <h2 class="font-bold text-2xl">Latest articles</h2>
                <p class="text-gray-700 dark:text-gray-200">Explore our Free Acticles</p>
            </div>
            <a href="{{ route('articles.index') }}"
                class="block px-6 py-3 rounded-full text-gray-800 dark:text-gray-200 border-2 border-gray-800 hover:border-black hover:text-black dark:border-gray-200 dark:hover:border-amber-700 duration-300">All
                Articles</a>
        </div>
        <div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4 mt-4">
            <div
                class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-2 transition duration-300">
                <a href="#">
                    <img class="max-w-full w-full" src="{{ asset('assets/images/article.png') }}" alt="photo article">
                </a>
                <div class="p-4">
                    <a href="#" class="font-bold hover:text-amber-500 transition">Best LearnPress WordPress Theme
                        Collection for 2023</a>
                    <div class="text-gray-600 flex gap-2 items-center text-sm">
                        <i class="fa-solid fa-calendar-days text-amber-500"></i>
                        <span>Jan 24, 2023</span>
                    </div>
                    <p class="text-gray-600">
                        Looking for an amazing & well-functional LearnPress WordPress Theme?...
                    </p>
                </div>
            </div>
            <div
                class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-2 transition duration-300">
                <a href="#">
                    <img class="max-w-full w-full" src="{{ asset('assets/images/article.png') }}" alt="photo article">
                </a>
                <div class="p-4">
                    <a href="#" class="font-bold hover:text-amber-500 transition">Best LearnPress WordPress Theme
                        Collection for 2023</a>
                    <div class="text-gray-600 flex gap-2 items-center text-sm">
                        <i class="fa-solid fa-calendar-days text-amber-500"></i>
                        <span>Jan 24, 2023</span>
                    </div>
                    <p class="text-gray-600">
                        Looking for an amazing & well-functional LearnPress WordPress Theme?...
                    </p>
                </div>
            </div>
            <div
                class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-2 transition duration-300">
                <a href="#">
                    <img class="max-w-full w-full" src="{{ asset('assets/images/article.png') }}" alt="photo article">
                </a>
                <div class="p-4">
                    <a href="#" class="font-bold hover:text-amber-500 transition">Best LearnPress WordPress Theme
                        Collection for 2023</a>
                    <div class="text-gray-600 flex gap-2 items-center text-sm">
                        <i class="fa-solid fa-calendar-days text-amber-500"></i>
                        <span>Jan 24, 2023</span>
                    </div>
                    <p class="text-gray-600">
                        Looking for an amazing & well-functional LearnPress WordPress Theme?...
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
