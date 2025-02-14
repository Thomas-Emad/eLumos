@extends('layouts.app')
@section('title', 'Dashboard')
@section('css')
    <style>
        *:not(body)::-webkit-scrollbar {
            height: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto min-h-auto-xl flex gap-4 flex-col p-4 mt-20">
        <div class="flex justify-between gap-2 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg p-2">
            <h1 class="font-bold text-2xl text-gray-800 dark:text-gray-50">Add New Course:</h1>
            <a href="{{ route('dashboard.instructor.courses.index') }}"
                class="font-bold px-4 py-2 border border-green-500 text-green-500 hover:text-white hover:bg-green-500 duration-300 rounded-xl">
                Save for Now
            </a>
        </div>
        <div
            class="text-gray-500 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg shadow-sm  sm:p-4 font-medium text-center  p-4">

            <!-- Title Section -->
            <h1 class="font-bold text-2xl text-gray-800 dark:text-gray-50 mb-2">
                @if (request()->input('step') == '1' || empty(request()->input('step')))
                    Course landing Page
                @elseif (request()->input('step') == '2')
                    Course Media
                @elseif (request()->input('step') == '3')
                    Course Details
                @elseif (request()->input('step') == '4')
                    Curriculum
                @elseif (request()->input('step') == '5')
                    Course Message
                @elseif (request()->input('step') == '6')
                    Settings
                @endif
            </h1>

            <!-- Course Steps, Progsess Bar -->
            <ol class="overflow-x-auto flex items-center w-full space-x-2  whitespace-nowrap  sm:space-x-4 pb-3">
                <li class="@if (request()->input('step') == '1' || empty(request()->input('step'))) text-blue-600 @endif">
                    <a href="@if (Route::is('dashboard.instructor.courses.edit')) {{ route('dashboard.instructor.courses.edit', ['course' => $course->id]) }}?step=1 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course)) pointer-events-none @endif">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0 @if (request()->input('step') == '1') border-blue-500 @else border-gray-500 @endif ">
                            1
                        </span>
                        Course landing Page
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                        </svg>
                    </a>
                </li>

                <li class="@if (request()->input('step') == '2') text-blue-600 @endif">
                    <a href="@if (Route::is('dashboard.instructor.courses.edit')) {{ route('dashboard.instructor.courses.edit', ['course' => $course->id]) }}?step=2 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course)) pointer-events-none @endif">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0 @if (request()->input('step') == '2') border-blue-500 @else border-gray-500 @endif">
                            2
                        </span>
                        Course Media
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                        </svg>
                    </a>
                </li>

                <li class="@if (request()->input('step') == '3') text-blue-600 @endif">
                    <a href="@if (Route::is('dashboard.instructor.courses.edit')) {{ route('dashboard.instructor.courses.edit', ['course' => $course->id]) }}?step=3 @endif"
                        class="flex items-center hover:text-amber-600 duration-300">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border  rounded-full shrink-0 @if (request()->input('step') == '3') border-blue-500 @else border-gray-500 @endif">
                            3
                        </span>
                        Course Details
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                        </svg>
                    </a>
                </li>

                <li class=" @if (request()->input('step') == '4') text-blue-600 @endif disabled:opacity-50">
                    <a href="@if (Route::is('dashboard.instructor.courses.edit')) {{ route('dashboard.instructor.courses.edit', ['course' => $course->id]) }}?step=4 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course)) pointer-events-none @endif">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border  rounded-full shrink-0 @if (request()->input('step') == '4') border-blue-500 @else border-gray-500 @endif">
                            4
                        </span>
                        Curriculum
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                        </svg>
                    </a>
                </li>

                <li class="@if (request()->input('step') == '5') text-blue-600 @endif">
                    <a href="@if (Route::is('dashboard.instructor.courses.edit')) {{ route('dashboard.instructor.courses.edit', ['course' => $course->id]) }}?step=5 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course)) pointer-events-none @endif">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border  rounded-full shrink-0  @if (request()->input('step') == '5') border-blue-500 @else border-gray-500 @endif">
                            5
                        </span>
                        Course Message
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                        </svg>
                    </a>
                </li>

                <li class="@if (request()->input('step') == '6') text-blue-600 @endif">
                    <a href="@if (Route::is('dashboard.instructor.courses.edit')) {{ route('dashboard.instructor.courses.edit', ['course' => $course->id]) }}?step=6 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course)) pointer-events-none @endif">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border  rounded-full shrink-0 @if (request()->input('step') == '6') border-blue-500 @else border-gray-500 @endif">
                            6
                        </span>
                        Settings
                    </a>
                </li>
            </ol>

        </div>

        <div
            class=" w-full p-4 space-y-2 font-medium text-gray-500 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg shadow-sm  sm:p-4 sm:space-y-4 ">
            @if (request()->input('step') == '1' || empty(request()->input('step')))
                @include('components.course-operations.step-1')
            @elseif (request()->input('step') == '2')
                @include('components.course-operations.step-2')
            @elseif (request()->input('step') == '3')
                @include('components.course-operations.step-3')
            @elseif (request()->input('step') == '4')
                @include('components.course-operations.step-4')
            @elseif (request()->input('step') == '5')
                @include('components.course-operations.step-5')
            @elseif (request()->input('step') == '6')
                @include('components.course-operations.step-6')
            @endif
        </div>

        <!-- Course Navigation Section -->
        @if (!empty($course))
            <div
                class="flex items-center justify-between w-full p-2 space-x-2 font-medium text-center text-gray-500 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg shadow-sm sm:space-x-4">
                @php
                    $currentStep = request()->input('step') ?? 1;
                @endphp

                @if ($currentStep > 1)
                    <a href="{{ route('dashboard.instructor.courses.edit', ['course' => $course->id]) }}?step={{ $currentStep - 1 }}"
                        class="font-bold px-4 py-2 border border-gray-500 text-gray-500 dark:text-gray-100 hover:text-white hover:bg-gray-500 duration-300 rounded-xl">
                        Prev
                    </a>
                @else
                    <div></div>
                @endif

                @if ($currentStep < 6)
                    <a href="{{ route('dashboard.instructor.courses.edit', ['course' => $course->id]) }}?step={{ $currentStep + 1 }}"
                        class="font-bold px-4 py-2 border border-green-500 text-green-500 hover:text-white hover:bg-green-500 duration-300 rounded-xl">
                        Next
                    </a>
                @else
                    <div></div>
                @endif
            </div>
        @endif
    </div>
@endsection
@section('js')
    @if (isset($course))
        @include('pages.dashboard.instructor.controll-course.course-operations-js')
    @endif
@endsection
