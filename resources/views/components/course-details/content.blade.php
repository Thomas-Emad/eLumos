@props(['course', 'hasThisCourse'])
{{-- Content Course info --}}
<div class="container mx-auto max-w-screen-xl p-4 flex flex-col-reverse md:flex-row gap-4">
    <div class="w-full md:w-2/3 ">
        <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 break-words">
            <h2 class="font-bold text-xl text-amber-700 mb-3">Overview</h2>
            <div class="text-sm">
                <h3 class="font-bold">Course Description</h3>
                <p class="text-gray-600 dark:text-gray-100 ">
                    {{ $course->description }}
                </p>
            </div>
            <div class="text-sm mt-2">
                <h3 class="font-bold">What you'll learn</h3>
                <div class="text-gray-600 dark:text-gray-100 ps-2">
                    {{ $course->learn }}
                </div>
            </div>
            <div class="text-sm mt-2">
                <h3 class="font-bold">Requirements</h3>
                <div class="text-gray-600 dark:text-gray-100 ps-2">
                    {{ $course->requirements }}
                </div>
            </div>

        </div>
        <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 mt-4">
            <div class="flex justify-between gap-2 items-center font-bold">
                <h2 class=" text-xl text-amber-700 mb-3">Course Content</h2>
                <div>
                    {{ $course->totalLectures }} Lectures /
                    {{ explainSecondsToHumans($course->totalLecturesTime) }}
                </div>
            </div>

            <div id="content-course" data-accordion="collapse">
                @php
                    $isFirstSetion = true;
                @endphp
                @foreach ($course->sections as $section)
                    <div
                        class="border first:border-b-0 only-of-type:border   border-gray-200 first-of-type:rounded-t-xl last-of-type:rounded-b-xl only-of-type:rounded-xl  overflow-hidden">
                        <h2 id="content-course-heading-{{ $section->id }}">
                            <button type="button"
                                class="flex items-center justify-between w-full px-4 py-2 font-sm rtl:text-right text-gray-500   hover:bg-gray-100 gap-3 "
                                data-accordion-target="#content-course-body-{{ $section->id }}" aria-expanded="true"
                                aria-controls="content-course-body-{{ $section->id }}">
                                <span>{{ $section->title }}</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="content-course-body-{{ $section->id }}" class="hidden"
                            aria-labelledby="content-course-heading-{{ $section->id }}">
                            <div class="p-2 border border-b-0 border-gray-200 text-gray-600 dark:text-gray-100 text-sm">
                                @foreach ($section->lectures as $lecture)
                                    <div
                                        class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                        <div>
                                            <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                            <span>
                                                Lecture {{ $section->order_sort }}.{{ $lecture->order_sort }} /
                                                {{ $lecture->title }}
                                            </span>
                                        </div>
                                        <div
                                            class='flex gap-2 items-center  text-sm text-gray-400 dark:text-ammber-500'>
                                            <div class='flex gap-2 items-center'>
                                                {!! getLectureIcons(
                                                    text: !is_null($lecture->content),
                                                    video: !is_null($lecture->video),
                                                    exam: !is_null($lecture->exam),
                                                ) !!}
                                            </div>
                                            @if ($isFirstSetion && !is_null($lecture->video))
                                                <button type='button'
                                                    data-url="{{ json_decode($lecture->video)->url }}"
                                                    data-modal-target="view-lecture" data-modal-toggle="view-lecture"
                                                    class="cursor-pointer underline hover:text-amber-600 duration-300 mr-1">Preview</button>
                                            @elseif(!$isFirstSetion)
                                                <i class="fa-solid fa-lock "></i>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @php
                        $isFirstSetion = false;
                    @endphp
                @endforeach
            </div>
        </div>
        {{-- Instructor, Reviews --}}
        <x-course-details.instructor-reviews :course="$course" :hasThisCourse="$hasThisCourse"></x-course-details.instructor-reviews>
    </div>
    <div class="w-full md:w-1/3 h-fit -translate-y-0 md:-translate-y-36 z-[2] flex flex-col gap-4">
        <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 ">
            <div class="relative cursor-pointer rounded-xl overflow-hidden" data-modal-target="video-preview"
                data-modal-toggle="video-preview">
                <img src="{{ json_decode($course->mockup)->url }}"
                    onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                    class="w-full h-[200px] " alt="view course">
                <div
                    class="px-4 py-2 rounded-full bg-gray-300/75 w-fit absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transition duration-300 hover:bg-gray-300 z-[2]">
                    <i class="fa-solid fa-play text-white text-xl"></i>
                </div>
                <div class="absolute top-0 left-0 w-full h-full bg-gray-800/50 z-[1]"></div>
            </div>
            <div class="flex justify-between items-center gap-2 py-4">
                <span class="text-bold text-2xl text-green-500">{{ $course->price }}$</span>
                <div class="text-gray-600 dark:text-gray-100 text-sm">
                    <span class="line-through">100$</span>
                    <span>50% off</span>
                </div>
            </div>
            <div class="text-sm text-amber-700 flex justify-between items-center gap-2">
                <form action="{{ route('wishlist.controll', $course->id) }}" method='POST'>
                    @csrf
                    @if (Auth::check() &&
                            auth()->user()->wishlist()->where('course_id', $course->id)->whereNull('deleted_at')->exists())
                        <button type="submit" name="type" value="remove"
                            class="whitespace-nowrap w-full transition duration-300 px-4 py-2 border border-amber-700 rounded-full hover:bg-amber-700 hover:text-white ">
                            <i class="fa-solid fa-heart mr-1"></i>
                            <span>Remove from Wishlist</span>
                        </button>
                    @else
                        <button type="submit" name="type" value="add"
                            class="whitespace-nowrap w-full transition duration-300 px-4 py-2 border border-amber-700 rounded-full hover:bg-amber-700 hover:text-white ">
                            <i class="fa-regular fa-heart mr-1"></i>
                            <span>Add To Wishlist</span>
                        </button>
                    @endif
                </form>
                <div data-popover-target="share-course-tooltipe" data-modal-target="course-modal"
                    data-modal-toggle="course-modal"
                    class="cursor-pointer whitespace-nowrap w-full transition duration-300 px-4 py-2 border border-amber-700 rounded-full   hover:bg-amber-700 hover:text-white">
                    <i class="fa-regular fa-share-from-square"></i>
                    <span>Share</span>
                </div>

                <div data-popover id="share-course-tooltipe" role="tooltip"
                    class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                    <div class="px-3 py-2 text-center">
                        <p>Want Share This Course?!</p>
                    </div>
                    <div data-popper-arrow></div>
                </div>
            </div>
            <div class="mt-2">
                @php
                    $existsInBasket = checkCourseInBasket($course->id);
                @endphp
                @if ($hasThisCourse)
                    <a href="{{ route('dashboard.student.show', ['course' => $course->id]) }}"
                        class="block w-full change-cart rounded-full py-2 px-4 bg-green-500 text-sm text-center font-bold text-white hover:bg-green-700 transition duration-300">
                        Watch Course
                    </a>
                @elseif(!$existsInBasket)
                    <button type="button" data-id="{{ $course->id }}"
                        class="block w-full change-cart rounded-full py-2 px-4 bg-green-500 text-sm text-center font-bold text-white hover:bg-green-700 transition duration-300">
                        Enroll Now
                    </button>
                @elseif ($existsInBasket)
                    <button type="button" data-id="{{ $course->id }}"
                        class="block w-full change-cart rounded-full py-2 px-4 text-sm text-center font-bold text-amber-700 hover:text-white border border-amber-700 hover:bg-amber-700 transition duration-300">
                        Remove form Basket
                    </button>
                @endif
            </div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200">
            <h3 class="font-bold text-xl pb-2">Includes</h3>
            <div class="flex flex-col gap-2 text-sm text-gray-600 dark:text-gray-100">
                <div class="p-2 border-b border-gray-200 last-of-type:border-none">
                    <i class="fa-solid fa-users text-amber-700 mr-2"></i>
                    <span>
                        <span>Enrolled:</span>
                        <span class="font-bold"> {{ $course->enrolleds->count() }} students</span>
                    </span>
                </div>
                <div class="p-2 border-b border-gray-200 last-of-type:border-none">
                    <i class="fa-solid fa-hourglass-half text-amber-700 mr-2"></i>
                    <span>
                        <span>Duration:</span>
                        <span class="font-bold">{{ explainSecondsToHumans($course->totalLecturesTime) }}</span>
                    </span>
                </div>
                <div class="p-2 border-b border-gray-200 last-of-type:border-none">
                    <i class="fa-solid fa-layer-group text-amber-700 mr-2"></i>
                    <span>
                        <span>Level:</span>
                        <span class="font-bold"> {{ $course->level }}</span>
                    </span>
                </div>
                <div class="p-2 border-b border-gray-200 last-of-type:border-none">
                    <i class="fa-solid fa-graduation-cap text-amber-700 mr-2"></i>
                    <span>
                        <span> Certificate of Completion</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
