@extends('layouts.app')
@section('title', 'Dashboard')
@section('css')
    <style>
        *:not(body)::-webkit-scrollbar {
            height: 10px;
        }

        iframe .ndfHFb-c4YZDc-Wrql6b {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto min-h-auto-xl flex gap-4 flex-col p-4 mt-20">
        <div class="flex justify-between gap-2 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg p-2">
            <h1 class="font-bold text-2xl text-gray-800 dark:text-gray-50">Add New Course:</h1>
            <button
                class="font-bold px-4 py-2 border border-green-500 text-green-500 hover:text-white hover:bg-green-500 duration-300 rounded-xl">Save
                for Now</button>
        </div>
        <div
            class="text-gray-500 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg shadow-sm  sm:p-4 font-medium text-center  p-4">

            <!-- Title Section -->
            <h1 class="font-bold text-2xl text-gray-800 dark:text-gray-50 mb-2">
                @if (request()->input('step') == '1' || empty(request()->input('step')))
                    Course Details
                @elseif (request()->input('step') == '2')
                    Curriculum
                @elseif (request()->input('step') == '3')
                    Course Media
                @elseif (request()->input('step') == '4')
                    Course landing Page
                @elseif (request()->input('step') == '5')
                    Course Message
                @elseif (request()->input('step') == '6')
                    Settings
                @endif
            </h1>

            <!-- Course Steps, Progsess Bar -->
            <ol class="overflow-x-auto flex items-center w-full space-x-2  whitespace-nowrap  sm:space-x-4 pb-3">

                <li class="@if (request()->input('step') == '1' || empty(request()->input('step'))) text-blue-600 @endif">
                    <a href="@if (Route::is('dashboard.add-course')) # @else {{ route('dashboard.course.edit', ['course' => $course->id]) }}?step=1 @endif"
                        class="flex items-center hover:text-amber-600 duration-300">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border  rounded-full shrink-0 @if (request()->input('step') == '1') border-blue-500 @else border-gray-500 @endif">
                            1
                        </span>
                        Course Details
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                        </svg>
                    </a>
                </li>

                <li class=" @if (request()->input('step') == '2') text-blue-600 @endif disabled:opacity-50">
                    <a href="@if (Route::is('dashboard.course.edit')) {{ route('dashboard.course.edit', ['course' => $course->id]) }}?step=2 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course) || $course->steps < 2) pointer-events-none @endif">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border  rounded-full shrink-0 @if (request()->input('step') == '2') border-blue-500 @else border-gray-500 @endif">
                            2
                        </span>
                        Curriculum
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                        </svg>
                    </a>
                </li>
                <li class="@if (request()->input('step') == '3') text-blue-600 @endif">
                    <a href="@if (Route::is('dashboard.course.edit')) {{ route('dashboard.course.edit', ['course' => $course->id]) }}?step=3 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course) || $course->steps < 3) pointer-events-none @endif">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0 @if (request()->input('step') == '3') border-blue-500 @else border-gray-500 @endif">
                            3
                        </span>
                        Course Media
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                        </svg>
                    </a>
                </li>
                <li class="@if (request()->input('step') == '4') text-blue-600 @endif">
                    <a href="@if (Route::is('dashboard.course.edit')) {{ route('dashboard.course.edit', ['course' => $course->id]) }}?step=4 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course) || $course->steps < 4) pointer-events-none @endif">
                        <span
                            class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0 @if (request()->input('step') == '4') border-blue-500 @else border-gray-500 @endif ">
                            4
                        </span>
                        Course landing Page
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                        </svg>
                    </a>
                </li>
                <li class="@if (request()->input('step') == '5') text-blue-600 @endif">
                    <a href="@if (Route::is('dashboard.course.edit')) {{ route('dashboard.course.edit', ['course' => $course->id]) }}?step=5 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course) || $course->steps < 5) pointer-events-none @endif">
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
                    <a href="@if (Route::is('dashboard.course.edit')) {{ route('dashboard.course.edit', ['course' => $course->id]) }}?step=6 @endif"
                        class="flex items-center hover:text-amber-600 duration-300 @if (empty($course) || $course->steps < 6) pointer-events-none @endif">
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
                <form action="{{ route('dashboard.add-course.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <p class="text-sm text-gray-500 dark:text-gray-100 ">Let's find out what people learn from this
                            course?!..</p>

                        <x-textarea name='learn-course' placeholder='Write your thoughts here...'
                            nameInput='What do the students learn?'>{{ old('learn-course', $course->learn ?? '') }}</x-textarea>
                    </div>
                    <div class="mb-1">
                        <p class="text-sm text-gray-500 dark:text-gray-100 ">Are there any requirements to attend this
                            course?!..</p>
                        <x-textarea name='requirements-course' placeholder='Write your thoughts here...'
                            nameInput='What are the requirements?!..'>{{ old('requirements-course', $course->requirements ?? '') }}</x-textarea>
                    </div>
                    <button type="submit"
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
            @elseif (request()->input('step') == '2')
                <div class="flex items-center justify-between gap-2">
                    <h2 class="font-bold text-xl">Curriculum</h2>
                    <button type="button"
                        class="block text-sm font-bold px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 duration-300 rounded-xl"
                        data-modal-target="add-section-modal" data-modal-toggle="add-section-modal">
                        Add Section
                    </button>
                </div>
                <div class="mt-2 sections">
                    <div class="bg-gray-100  dark:bg-gray-700  p-4 rounded-xl mb-2">
                        <div class="flex gap-2 justify-between">
                            <div class="flex gap-2 items-center ">
                                <h3><b>Section 1:</b> JavaScript Beginnings</h3>
                                <i class="fa-solid fa-pen-to-square p-2 rounded-full hover:bg-white dark:bg-gray-800 duration-300 cursor-pointer"
                                    data-modal-target="edit-section-modal" data-modal-toggle="edit-section-modal"></i>
                                <i class="fa-solid fa-trash p-2 rounded-full hover:bg-white dark:bg-gray-800 duration-300 cursor-pointer"
                                    data-modal-target="delete-section-modal" data-modal-toggle="delete-section-modal"></i>
                            </div>
                            <button data-modal-target="add-lecture-modal" data-modal-toggle="add-lecture-modal"
                                type="button"
                                class="block text-sm font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">
                                Add Lecture
                            </button>
                        </div>
                        <div class="flex gap-4 flex-col mt-2">
                            <div
                                class="px-4 py-2 bg-white dark:bg-gray-600 rounded-xl flex justify-between gap-2 items-center">
                                <div class="flex gap-2 items-center font-bold text-gray-900 dark:text-gray-50 text-xl">
                                    <i class="fa-solid fa-laptop-file"></i>
                                    <h4>Introduction</h4>
                                </div>
                                <div class="flex gap-4 text-gray-600">
                                    <i class="fa-solid fa-pen-to-square hover:text-amber-700 duration-300 cursor-pointer"
                                        data-modal-target="add-lecture-modal" data-modal-toggle="add-lecture-modal"></i>
                                    <i class="fa-solid fa-trash hover:text-amber-700 duration-300 cursor-pointer"
                                        data-modal-target="delete-lecture-modal"
                                        data-modal-toggle="delete-lecture-modal"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @foreach ($course->sections as $section)
              <div class="bg-gray-100  dark:bg-gray-700  p-4 rounded-xl mb-2">
                <div class="flex gap-2 justify-between">
                  <div class="flex gap-2 items-center ">
                    <h3><b>Section {{ $section->order }}:</b> {{ $section->title }}</h3>
                    <i class="fa-solid fa-pen-to-square p-2 rounded-full hover:bg-white dark:bg-gray-800 duration-300 cursor-pointer"
                      data-modal-target="edit-section-modal" data-modal-toggle="edit-section-modal"></i>
                    <i class="fa-solid fa-trash p-2 rounded-full hover:bg-white dark:bg-gray-800 duration-300 cursor-pointer"
                      data-modal-target="delete-section-modal" data-modal-toggle="delete-section-modal"></i>
                  </div>
                  <button data-modal-target="add-lecture-modal" data-modal-toggle="add-lecture-modal" type="button"
                    class="block text-sm font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">
                    Add Lecture
                  </button>
                </div>
                <div class="flex gap-4 flex-col mt-2">
                  @forelse ($section->lectures as $lecture)
                    <div class="px-4 py-2 bg-white dark:bg-gray-600 rounded-xl flex justify-between gap-2 items-center">
                      <div class="flex gap-2 items-center font-bold text-gray-900 dark:text-gray-50 text-xl">
                        <i class="fa-solid fa-laptop-file"></i>
                        <h4>{{ $lecture->title }}</h4>
                      </div>
                      <div class="flex gap-4 text-gray-600">
                        <i class="fa-solid fa-pen-to-square hover:text-amber-700 duration-300 cursor-pointer"
                          data-modal-target="add-lecture-modal" data-modal-toggle="add-lecture-modal"></i>
                        <i class="fa-solid fa-trash hover:text-amber-700 duration-300 cursor-pointer"
                          data-modal-target="delete-lecture-modal" data-modal-toggle="delete-lecture-modal"></i>
                      </div>
                    </div>
                  @empty
                    <p class="bg-white p-2 rounded-xl text-sm text-center text-gray-500 dark:text-gray-100">You can add
                      up to 10 lectures</p>
                  @endforelse
                </div>
              </div>
            @endforeach --}}
                </div>
                {{-- <button
            class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
            Changes</button> --}}
            @elseif (request()->input('step') == '3')
                <form action=''>
                    <h2 class="font-bold text-xl mb-1">- Course background</h2>
                    <div class="flex items-center justify-center w-full">
                        <label for="bg-course"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-100 " aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-100 "><span
                                        class="font-semibold">Click
                                        to upload (Background)</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-100 ">PNG or JPG (MAX.
                                    800x400px, 2MB)
                                </p>
                            </div>
                            <input id="bg-course" type="file" class="hidden" accept="image/png, image/jpeg" />
                        </label>
                    </div>

                    <hr class="my-2">

                    <h2 class="font-bold text-xl mb-1">- Video presentation</h2>
                    <div class="flex items-center justify-center w-full">
                        <label for="video-course"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-100 " aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-100 "><span
                                        class="font-semibold">Click
                                        to upload (Video presentation)</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-100 ">Video (MAX.
                                    800x400px, 10MB)
                                </p>
                            </div>
                            <input id="video-course" type="file" class="hidden" accept="video/*" />
                        </label>
                    </div>
                    <button
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
            @elseif (request()->input('step') == '4')
                <form action=''>
                    <x-input name='title-course' nameInput='Title Course' value=''></x-input>
                    <x-input name='subtitle-course' nameInput='Subtitle Course' value=''></x-input>
                    <x-textarea name='description-course' placeholder='The course description can be written here..'
                        nameInput='Description' value=''></x-textarea>

                    <div class="mt-2">
                        <x-select-search name='langs' placeholder='Choose Lang Your Course'
                            placeholderSearch='Select lang...'></x-select-search>
                    </div>
                    <div class="mt-2">
                        <x-tags name='tags' placeholder='Select OR Write Your Tags'></x-tags>
                    </div>
                    <button
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
            @elseif (request()->input('step') == '5')
                <form action="">
                    <div class="mb-2">
                        <p class="text-sm text-gray-500 dark:text-gray-100 ">Would you prefer to inform the buyer by any
                            message after
                            completing the course?</p>
                        <x-textarea name='message-buy-course' placeholder='Message after purchasing the course'
                            nameInput='Message after purchasing the course?!..' value=''></x-textarea>
                    </div>
                    <div class="mb-1">
                        <p class="text-sm text-gray-500 dark:text-gray-100 ">Are there any requirements to attend this
                            course?!..</p>
                        <x-textarea name='message-complate-course' placeholder='Message after completing the course...'
                            nameInput='Message after completing the course?!..' value=''></x-textarea>
                    </div>
                    <button
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
            @elseif (request()->input('step') == '6')
                <form action="">
                    <x-input name='price-course' nameInput='Price Course' value=''></x-input>
                    <div
                        class="flex justify-between gap-2 items-center mt-2 p-4 w-full rounded-lg text-sm border  border-gray-200 dark:border-amber-700">
                        <p class="text-gray-600 dark:text-gray-50">This shows the status of the course, open or stopped</p>
                        <x-switch name='status-course' checked></x-switch>
                    </div>
                    <button
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
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
                    <a href="{{ route('dashboard.course.edit', ['course' => $course->id]) }}?step={{ $currentStep - 1 }}"
                        class="font-bold px-4 py-2 border border-gray-500 text-gray-500 dark:text-gray-100 hover:text-white hover:bg-gray-500 duration-300 rounded-xl">
                        Prev
                    </a>
                @else
                    <div></div>
                @endif

                @if ($currentStep < 6 && $course->steps > $currentStep)
                    <a href="{{ route('dashboard.course.edit', ['course' => $course->id]) }}?step={{ $currentStep + 1 }}"
                        class="font-bold px-4 py-2 border border-green-500 text-green-500 hover:text-white hover:bg-green-500 duration-300 rounded-xl">
                        Next
                    </a>
                @else
                    <div></div>
                @endif
            </div>
        @endif

    </div>

    {{-- Modals --}}
    @include('dashboard.instructor.course.course-operations-modals')
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @if (isset($course))
        @include('dashboard.instructor.course.course-operations-js')
    @endif
@endsection
