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
                <form action="">
                    <div class="flex items-center justify-between gap-2">
                        <h2 class="font-bold text-xl">Curriculum</h2>
                        <button type="button"
                            class="block text-sm font-bold px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 duration-300 rounded-xl"
                            data-modal-target="add-section-modal" data-modal-toggle="add-section-modal">
                            Add Section
                        </button>
                    </div>
                    <div class="mt-2">
                        <div class="bg-gray-100  dark:bg-gray-700  p-4 rounded-xl ">
                            <div class="flex gap-2 justify-between">
                                <div class="flex gap-2 items-center ">
                                    <h3><b>Section 1:</b> JavaScript Beginnings</h3>
                                    <i class="fa-solid fa-pen-to-square p-2 rounded-full hover:bg-white dark:bg-gray-800 duration-300 cursor-pointer"
                                        data-modal-target="edit-section-modal" data-modal-toggle="edit-section-modal"></i>
                                    <i class="fa-solid fa-trash p-2 rounded-full hover:bg-white dark:bg-gray-800 duration-300 cursor-pointer"
                                        data-modal-target="delete-section-modal"
                                        data-modal-toggle="delete-section-modal"></i>
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
                                            data-modal-target="add-lecture-modal"
                                            data-modal-toggle="add-lecture-modal"></i>
                                        <i class="fa-solid fa-trash hover:text-amber-700 duration-300 cursor-pointer"
                                            data-modal-target="delete-lecture-modal"
                                            data-modal-toggle="delete-lecture-modal"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
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
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
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
    @if (request()->input('step') == '2')
        <x-modal id="add-section-modal">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <span>Do you want to add a new section?!</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="add-section-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <p class=" text-sm text-gray-500 dark:text-gray-100 ">What is the name of this new section?!..</p>
                <input type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 dark:text-gray-50 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"
                    placeholder="Title of this section.." required />
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="add-section-modal" type="button"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Add
                </button>
                <button data-modal-hide="add-section-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 dark:text-gray-50 focus:outline-none bg-white  rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </x-modal>
        <x-modal id="edit-section-modal">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <span>Edit in This Section</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="edit-section-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-sm text-gray-500 dark:text-gray-100 ">Do you want to change the name of this section?!..</p>
                <input type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 dark:text-gray-50 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"
                    placeholder="Title of this section.." required />

            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="edit-section-modal" type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Save Changes
                </button>
                <button data-modal-hide="edit-section-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 dark:text-gray-50 focus:outline-none bg-white dark:bg-gray-800 rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </x-modal>
        <x-modal-info id="delete-section-modal">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-100 ">Are you sure you want
                to delete
                this Section?</h3>
            <button data-modal-hide="delete-section-modal" type="button"
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Yes, I'm sure
            </button>
            <button data-modal-hide="delete-section-modal" type="button"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 dark:text-gray-50 focus:outline-none bg-white dark:bg-gray-800 rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                cancel</button>
        </x-modal-info>
        <x-modal id="add-lecture-modal">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <i class="fa-solid fa-laptop-file mr-2"></i>
                    <span>Do you want to add a new lecture?!</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="add-lecture-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <x-input type="text" name='title' nameInput="Title lecture" placeholder="Title of this lecture.."
                    value='' required />
                <hr>
                <div>
                    <div id="lecture" data-tabs-toggle="#lecture-content" role="tablist">
                        <button class="inline-block py-2 px-4  rounded-xl bg-gray-100" id="video-tab"
                            data-tabs-target="#video" type="button" role="tab" aria-controls="video"
                            aria-selected="false">Video</button>
                        <button class="inline-block py-2 px-4 rounded-xl border border-gray-50 hover:bg-gray-50"
                            id="text-tab" data-tabs-target="#text" type="button" role="tab" aria-controls="text"
                            aria-selected="false">Text</button>
                        <button class="inline-block py-2 px-4 rounded-xl border border-gray-50 hover:bg-gray-50"
                            id="exam-tab" data-tabs-target="#exam" type="button" role="tab" aria-controls="exam"
                            aria-selected="false">exam</button>
                    </div>
                    <div id="lecture-content mt-2">
                        <div class="hidden " id="video" role="tabpanel" aria-labelledby="video-tab">

                            <div class="flex items-center justify-center w-full my-2">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-100 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-100 "><span
                                                class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-100 ">Video (MAX.
                                            40MB)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" class="hidden" />
                                </label>
                            </div>


                            <!-- Modal footer -->
                            <div class="flex py-2 items-center border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button data-modal-hide="add-lecture-modal" type="button"
                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    Add
                                </button>
                                <button data-modal-hide="add-lecture-modal" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 dark:text-gray-50 focus:outline-none bg-white dark:bg-gray-800 rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                            </div>
                        </div>
                        <div class="my-2" id="text" role="tabpanel" aria-labelledby="text-tab">

                            <textarea id="message" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 dark:text-gray-50 bg-gray-50 rounded-lg border border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="Write your thoughts here..."></textarea>

                            <!-- Modal footer -->
                            <div class="flex py-2 items-center border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button data-modal-hide="add-lecture-modal" type="button"
                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    Add
                                </button>
                                <button data-modal-hide="add-lecture-modal" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 dark:text-gray-50 focus:outline-none bg-white dark:bg-gray-800 rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                            </div>
                        </div>
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="exam" role="tabpanel"
                            aria-labelledby="exam-tab">
                            <p class="text-sm text-gray-500 dark:text-gray-100 ">This is some placeholder
                                content the
                                <strong class="font-medium text-gray-800  dark:text-white">Settings tab's
                                    associated
                                    content</strong>.
                                Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript
                                swaps
                                classes to control the content visibility and styling.
                            </p>
                        </div>
                    </div>
                </div>
        </x-modal>
        <x-modal-info id="delete-lecture-modal">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-100 ">Are you sure you want
                to delete
                this Lecture?</h3>
            <button data-modal-hide="delete-lecture-modal" type="button"
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Yes, I'm sure
            </button>
            <button data-modal-hide="delete-lecture-modal" type="button"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                cancel</button>
        </x-modal-info>
    @endif
@endsection
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabButtons = document.querySelectorAll("[role='tab']");
            const tabContents = document.querySelectorAll("[role='tabpanel']");

            tabButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // إزالة الفئة النشطة من جميع الأزرار
                    tabButtons.forEach(btn => btn.classList.remove(
                        "bg-gray-100", "text-gray-700", "hover:bg-gray-50"));

                    // إضافة الفئة النشطة للزر الذي تم النقر عليه
                    this.classList.add("bg-gray-100", "text-gray-700", "hover:bg-gray-50");

                    // إخفاء كل المحتوى
                    tabContents.forEach(content => content.classList.add("hidden"));

                    // إظهار المحتوى المرتبط بالزر النشط
                    const target = document.querySelector(this.dataset.tabsTarget);
                    target.classList.remove("hidden");
                });
            });
        });
    </script>
@endsection
