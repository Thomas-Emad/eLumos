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
                <form
                    action="{{ isset($course) ? route('dashboard.instructor.courses.update', ['course' => $course->id]) : route('dashboard.instructor.courses.store') }}"
                    method="POST">
                    @csrf

                    @if (isset($course))
                        @method('PATCH')
                        <input type="hidden" name="step" value="{{ request()->input('step') }}">
                    @endif

                    <x-input name="title" label="Title Course" value="{{ old('title', $course->title ?? '') }}"></x-input>
                    <x-input name="headline" label="Headline Course"
                        value="{{ old('headline', $course->headline ?? '') }}"></x-input>

                    <x-textarea name='description' placeholder='The course description can be written here..'
                        label='Description'>{{ old('description', $course->description ?? '') }}</x-textarea>

                    <div class="mt-2">
                        <x-select-search name='language' placeholder='Choose Lang Your Course'
                            placeholderSearch='Select lang...'>
                            @if ((isset($course) && request()->input('step') == '1') || empty(request()->input('step')))
                                @foreach (\App\Models\Language::all() as $lang)
                                    <option @selected(old('language', $course->language_id ?? '') == $lang->id) value="{{ $lang->id }}"
                                        data-hs-select-option='{
                                            "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ $lang->img }}\" alt=\"{{ $lang->name }}\" />"}'>
                                        {{ $lang->name }}
                                    </option>
                                @endforeach
                            @endif
                        </x-select-search>
                    </div>
                    <div class="mt-2">
                        <x-multi-select name='tags[]' placeholder='Select OR Write Your Tags'>
                            @foreach (\App\Models\Tag::select('id', 'name')->get() as $item)
                                <option value="{{ $item->id }}" @selected(in_array($item->id, old('tags', isset($course) ? $course->tags->pluck('id')->toArray() : [])))>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </x-multi-select>
                    </div>
                    <button type="submit"
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
            @elseif (request()->input('step') == '2')
                <form action='{{ route('dashboard.instructor.courses.update', ['course' => $course->id]) }}'
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

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
                            <input id="bg-course" type="file" name="mockup" class="hidden"
                                accept="image/png, image/jpeg" />
                        </label>
                    </div>
                    @error('mockup')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <input type="hidden" name="step" value="{{ request()->input('step') }}">
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
                            <input id="video-course" type="file" name="video-persentation" class="hidden"
                                accept="video/mp4, video/webm" />
                        </label>
                    </div>
                    @error('video-persentation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <button type="submit"
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
            @elseif (request()->input('step') == '3')
                <form action="{{ route('dashboard.instructor.courses.update', ['course' => $course->id]) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')

                    <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Choose Level Course Target:</h3>
                    <ul class="grid w-full gap-6 md:grid-cols-3">
                        <li>
                            <input type="radio" id="beginner-option" name='level' value="beginner"
                                class="hidden peer" required="" @checked(old('level', $course->level ?? '') == 'beginner')>
                            <label for="beginner-option"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="flex gap-4 items-center">
                                    <img src="{{ asset('assets/images/icons/beginner-student.png') }}"
                                        alt="beginner student" class="w-14">
                                    <div>
                                        <div class="w-full text-lg font-semibold">Beginner</div>
                                        <div class="w-full text-sm">Beginner level or who has no knowledge of this
                                            specialty.
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </li>
                        <li>
                            <input type="radio" id="intermediate-option" name='level' value="intermediate"
                                class="hidden peer" @checked(old('level', $course->level ?? '') == 'intermediate')>
                            <label for="intermediate-option"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="flex gap-4 items-center">
                                    <img src="{{ asset('assets/images/icons/intermediate-student.png') }}"
                                        alt="Intermediate student" class="w-14">
                                    <div>
                                        <div class="w-full text-lg font-semibold">Intermediate</div>
                                        <div class="w-full text-sm">Post-beginner who aims to improve his knowledge.
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </li>
                        <li>
                            <input type="radio" id="advanced-option" name='level' value="advanced"
                                @checked(old('level', $course->level ?? '') == 'advanced') class="hidden peer">
                            <label for="advanced-option"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="flex gap-4 items-center">
                                    <img src="{{ asset('assets/images/icons/advanced-student.png') }}"
                                        alt="Advanced student" class="w-14">
                                    <div>
                                        <div class="w-full text-lg font-semibold">Advanced</div>
                                        <div class="w-full text-sm">Professionals and great presenters, we can say whales..
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </li>
                    </ul>
                    <hr class="my-4">
                    <div class="mb-2">
                        <input type="hidden" name="step" value="{{ request()->input('step') }}">
                        <p class="text-sm text-gray-500 dark:text-gray-100 ">Let's find out what people learn from this
                            course?!..</p>

                        <x-textarea name='learn' placeholder='Write your thoughts here...'
                            label='What do the students learn?'>{{ old('learn', $course->learn ?? '') }}</x-textarea>
                    </div>
                    <div class="mb-1">
                        <p class="text-sm text-gray-500 dark:text-gray-100 ">Are there any requirements to attend this
                            course?!..</p>
                        <x-textarea name='requirements' placeholder='Write your thoughts here...'
                            label='What are the requirements?!..'>{{ old('requirements', $course->requirements ?? '') }}</x-textarea>
                    </div>
                    <button type="submit"
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
            @elseif (request()->input('step') == '4')
                <div class="flex items-center justify-between gap-2">
                    <h2 class="font-bold text-xl">Curriculum</h2>
                    <button type="button"
                        class="block text-sm font-bold px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 duration-300 rounded-xl"
                        data-modal-target="add-section-modal" data-modal-toggle="add-section-modal">
                        Add Section
                    </button>
                </div>
                <div class="mt-2 sections">
                    <!-- Sections sit here -->
                    <p class="text-gray-500 text-center italic">Hmm, it looks like there are no sections. Add one!</p>
                </div>
            @elseif (request()->input('step') == '5')
                <form action="{{ route('dashboard.instructor.courses.update', ['course' => $course->id]) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')
                    @php
                        $message = json_decode($course->message);
                    @endphp
                    <input type="hidden" name="step" value="{{ request()->input('step') }}">
                    <div class="mb-2">
                        <p class="text-sm text-gray-500 dark:text-gray-100 ">Would you prefer to inform the buyer by any
                            message after
                            completing the course?</p>
                        <x-textarea name='message-before-start' placeholder='Message after purchasing the course'
                            label='Message after purchasing the course?!..'>{{ old('message-before-start', isset($course) ? $message->before_start ?? '' : '') }}</x-textarea>
                    </div>
                    <div class="mb-1">
                        <p class="text-sm text-gray-500 dark:text-gray-100 ">Are there any requirements to attend this
                            course?!..</p>
                        <x-textarea name='message-complete' placeholder='Message after completing the course...'
                            label='Message after completing the course?!..'>{{ old('message-complete', isset($course) ? $message->complete ?? '' : '') }}</x-textarea>
                    </div>
                    <button type="submit"
                        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
                        Changes</button>
                </form>
            @elseif (request()->input('step') == '6')
                @if (isset($course) && $course->steps < 6)
                    <p class="bg-gray-900/40 text-white font-bold py-2 px-4 text-center rounded-xl">
                        You should end from prev steps before publish your course
                    </p>
                @endif
                <form action="{{ route('dashboard.instructor.courses.update', ['course' => $course->id]) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="step" value="{{ request()->input('step') }}">
                    <x-input name='price' type="number" label='Price Course'
                        value="{{ old('price', $course->price ?? '') }}" step='0.01'></x-input>
                    @if (isset($course) && $course->steps == 6)
                        <button type="submit"
                            class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Send
                            Course To Preview</button>
                    @endif

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

    {{-- Modals --}}
    @include('dashboard.instructor.course.course-operations-modals')
@endsection
@section('js')
    @if (isset($course))
        @include('dashboard.instructor.course.course-operations-js')
    @endif
@endsection
