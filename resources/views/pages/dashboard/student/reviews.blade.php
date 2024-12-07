@extends('layouts.dashboard')

@section('title', 'Your Reviews')

@section('content-dashboard')
    <div class="min-h-screen container mx-auto py-4">
        <div class="p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
            <h2 class="font-bold text-xl mb-2 border-b border-gray-200 pb-2 flex justify-between items-center">
                Reviews
            </h2>

            <div>
                @forelse ($reviews as $review)
                    <div class="flex flex-row justify-between gap-4 items-center">
                        <div class="flex flex-row gap-4">
                            <img class="w-16 h-16 rounded-xl" src="{{ json_decode($review->course->mockup)->url }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                                alt="Course Mockup Photo">
                            <div>
                                <h3 class="font-bold text-xl hover:text-amber-700 duration-200">
                                    <a href="{{ route('course-details', $review->course->id) }}">
                                        {{ $review->course->title }}
                                    </a>
                                </h3>
                                <span
                                    class="text-sm text-gray-600 dark:text-gray-100">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div data-popover id="popover-default" role="tooltip"
                            class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                            <div
                                class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Your Response</h3>
                            </div>
                            <div class="px-3 py-2">
                                <p>{{ $review->content }}</p>
                            </div>
                            <div data-popper-arrow></div>
                        </div>
                        <div>
                            <div>

                                @for ($i = 1; $i <= floor($review->rate); $i++)
                                    <i class="fa-solid fa-star text-amber-500"></i>
                                @endfor

                                @if ($review->rate - floor($review->rate) >= 0.5)
                                    <i class="fa-solid fa-star-half-stroke text-amber-500"></i>
                                @endif

                                @for ($i = 1; $i <= 5 - ceil($review->rate); $i++)
                                    <i class="fa-solid fa-star text-gray-400"></i>
                                @endfor
                            </div>
                            <div>
                                <button class="text-gray-600 hover:text-amber-700 duration-300 dark:text-gray-100"
                                    data-popover-target="popover-default" type="button">
                                    <i class="fa-solid fa-message"></i>
                                </button>
                                <a href="{{ route('course-details', $review->course_id) }}"
                                    class="inline-block mt-2 text-sm bg-amber-700 text-white font-bold rounded-lg py-2 px-4 hover:bg-amber-600 duration-300 cursor-pointer">
                                    View Course
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr class="mx-6 my-4">
                @empty
                    <p class="text-center italic text-gray-600">It looks like you haven't added any reviews yet.</p>
                @endforelse
                @if (sizeof($reviews) > 0)
                    {{ $reviews->links('pagination::tailwind') }}
                @endif
            </div>
        </div>
    </div>

@endsection
