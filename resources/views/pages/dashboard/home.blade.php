@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl">
        <div class="grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-4">
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Enrolled Courses</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">{{ $studentStatistics->coursesCount }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Active Courses</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">
                    {{ $studentStatistics->activeCoursesCount }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Completed Courses</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">
                    {{ $studentStatistics->completedCoursesCount }}</p>
            </div>
            @can('instructors-control-courses')
                <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                    <p class="text-gray-700 dark:text-gray-400 text-xl">Total Students</p>
                    <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">{{ $coursesInstructor->totalStudents }}
                    </p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                    <p class="text-gray-700 dark:text-gray-400 text-xl">Total Courses</p>
                    <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">{{ $coursesInstructor->totalCourses }}
                    </p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                    <p class="text-gray-700 dark:text-gray-400 text-xl">Total Earnings</p>
                    <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">${{ $coursesInstructor->totalEarnings }}
                    </p>
                </div>
            @endcan
            @can('admin-control-courses')
                <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                    <p class="text-gray-700 dark:text-gray-400 text-xl">Total Reviews</p>
                    <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">{{ $admin->totalReviews }}
                    </p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                    <p class="text-gray-700 dark:text-gray-400 text-xl">Open Reviews</p>
                    <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">{{ $admin->totalOpenReviews }}
                    </p>
                </div>
            @endcan
            @can('roles')
                <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                    <p class="text-gray-700 dark:text-gray-400 text-xl">Total Sales</p>
                    <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">${{ $admin->totalSales }}
                    </p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                    <p class="text-gray-700 dark:text-gray-400 text-xl">Total Profit</p>
                    <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">${{ $admin->totalProfit }}
                    </p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                    <p class="text-gray-700 dark:text-gray-400 text-xl">Total UnWithdrawn Profit</p>
                    <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">${{ $admin->totalUnwithdrawnProfit }}
                    </p>
                </div>
            @endcan

        </div>
        @can('instructors-control-courses')
            <hr class="my-4">
            <h2 class="font-bold text-gray-800 dark:text-gray-200 text-2xl my-4">Recently Created Courses</h2>
            <div class="w-full overflow-x-auto">
                <div
                    class="bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-400  text-gray-700 dark:text-gray-400  min-width-20 overflow-hidden">
                    <div class="flex justify-between gap-2 bg-gray-100 dark:bg-gray-800  p-4">
                        <span>Courses</span>
                        <div class="flex gap-4">
                            <span>Enrolled</span>
                            <span>Status</span>
                        </div>
                    </div>
                    <div>
                        @forelse ($coursesInstructor->courses as $course)
                            <div
                                class="flex justify-between items-center gap-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-400  p-4 border-b border-b-gray-200 last-of-type:border-none only-of-type:border-none">
                                <a href="{{ route('course-details', $course->id) }}"
                                    class="flex gap-2 items-center text-lg hover:text-amber-600 duration-200">
                                    <img src="{{ getParameterFromJsonOrNull($course->mockup, 'url') }}"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                                        alt="Image courses" class="w-16 h-16 rounded-lg">
                                    <h3>
                                        {{ \Str::limit($course->title, 20) }}
                                    </h3>
                                </a>
                                <div class="flex gap-4">
                                    <span>{{ $course->enrolleds_count }}</span>
                                    <span>{{ $course->status }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center font-bold italic text-gray-500 py-4">No Courses Found</d>
                        @endforelse
                    </div>
                </div>
            </div>
        @endcan
        <hr class="my-4">
        <h2 class="font-bold text-gray-800 dark:text-gray-200 text-2xl my-4">Recently Enrolled Courses</h2>
        @if ($lastWatchedCourse)
            <a href="{{ route('dashboard.student.show', ['course' => $lastWatchedCourse->course_id]) }}"
                class="block cursor-pointer duration-200 hover:opacity-80 relative  w-full rounded-xl bg-white  shadow-sm border border-gray-200 p-3 overflow-hidden">
                <div class="bg-no-repeat bg-cover opacity-50 h-full w-full absolute inset-0"
                    style="background-image: url({{ asset('assets/images/banner-study.jpg') }})"></div>
                <div
                    class="relative w-full z-10  flex flex-col md:flex-row justify-between items-center p-4 bg-white/50 rounded-xl">
                    <img src="{{ getParameterFromJsonOrNull($lastWatchedCourse->mockup, 'url') }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';" alt="photo course"
                        class="w-full md:w-56 h-40 rounded-xl shadow">
                    <div class="w-full md:w-1/3 mt-4 md:mt-0">
                        <div>
                            <h2 class="text-2xl mb-2">{{ $lastWatchedCourse->title }}</h2>
                            <p class="text-gray-600 text-sm  break-words ">
                                {{ str($lastWatchedCourse->headline)->limit(30) }}</p>
                        </div>

                        <div class="w-full bg-gray-100 rounded-md overflow-hidden p-1 relative">
                            <span
                                class="block w-[{{ $lastWatchedCourse->progress_lectures }}%] bg-blue-600 absolute inset-0 z-10"></span>
                        </div>
                        <span class="text-xs text-right block">{{ $lastWatchedCourse->progress_lectures }}%</span>
                    </div>
                </div>
            </a>
        @endif

        <div class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-8 mt-4 text-gray-800 dark:text-gray-200">
            @foreach ($courses as $course)
                <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                    <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                        <img src="{{ getParameterFromJsonOrNull($course->mockup, 'url') }}"
                            onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                            class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                    </a>
                    <div class="py-2 flex justify-between gap-2 items-center">
                        <div class="flex gap-2">
                            <img src="{{ $course->user->photo ? asset('storage/' . $course->user->photo) : asset('assets/images/user-1.png') }}"
                                class="w-10 h-10 rounded-full" alt="photo Instructor">
                            <div>
                                <h3 class=" font-bold hover:text-amber-600 duration-200">
                                    <a href="{{ route('dashboard.profile', $course->user->username) }}">
                                        {{ $course->user->name }}
                                    </a>
                                </h3>
                                <span class="text-sm">{{ $course->user->headline }}</span>
                            </div>
                        </div>
                        <button type="button" data-id="{{ $course->id }}" class="wishlist" name="type">
                            <i @class([
                                'fa-solid fa-heart text-lg duration-200',
                                'text-amber-400 hover:text-gray-300' => $course->wishlistCount > 0,
                                'text-gray-300 hover:text-amber-400' => $course->wishlistCount == 0,
                            ])></i>
                        </button>
                    </div>
                    <a href="{{ route('course-details', $course->id) }}"
                        class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                        {{ \Str::limit($course->title, 20) }}
                    </a>
                    <hr>
                    <div class="text-sm py-2 flex justify-between gap-2">
                        <div>
                            @for ($i = 1; $i <= floor($course->average_rating); $i++)
                                <i class="fa-solid fa-star text-amber-400"></i>
                            @endfor

                            @if ($course->average_rating - floor($course->average_rating) >= 0.5)
                                <i class="fa-solid fa-star-half-stroke text-amber-400"></i>
                            @endif

                            @for ($i = 1; $i <= 5 - ceil($course->average_rating); $i++)
                                <i class="fa-solid fa-star text-gray-400"></i>
                            @endfor

                            <span>{{ $course->average_rating }} ({{ $course->reviewsCount }})</span>
                        </div>
                        <div class="font-bold">
                            {{ $course->price ? '$' . $course->price : 'Free' }}
                        </div>
                    </div>
                    <hr>
                    <div class="text-sm py-2 flex justify-between items-center gap-2">
                        <a href="{{ route('dashboard.student.show', $course->id) }}"
                            class="w-full rounded-lg py-2 px-4 text-white font-bold bg-amber-600 hover:bg-amber-800 duration-200">
                            Watch Course
                        </a>
                        <span class="font-bold text-md">
                            {{ $course->progress_lectures }}%
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-2">
            {{ $courses->links() }}
        </div>

        @if (sizeof($courses) === 0)
            <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                <div class="text-center font-bold italic text-gray-500 py-4">You have not any Courses..</div>
            </div>
        @endif
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $(".wishlist").on("click", function() {
                var course_id = $(this).attr("data-id");
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    method: "POST",
                    url: "{{ route('api.wishlist.controll') }}/",
                    data: {
                        _token: csrfToken,
                        course_id: course_id
                    }
                }).done(function(response) {
                    if (response.type == 'add') {
                        $(`.wishlist[data-id=${course_id}]`).html(`
                          <i class="fa-solid fa-heart text-lg duration-200 text-amber-400 hover:text-gray-300"></i>
                        `);
                    } else {
                        $(`.wishlist[data-id=${course_id}]`).html(`
                          <i class="fa-solid fa-heart text-lg duration-200 text-gray-300 hover:text-amber-400"></i>
                        `);
                    }
                    $('.notifications').append(`@include('components.notifications.success', [
                        'message' => 'We Will done as Well..',
                    ])`);
                })
            });
        });
    </script>
@endsection
