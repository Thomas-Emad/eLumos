@extends('layouts.dashboard')
@section('title', 'Profile')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl ">
        <div class="p-4 rounded-xl border border-gray-200 bg-white">
            <h2 class="font-bold text-xl mb-2 border-b border-gray-200 pb-2 flex justify-between items-center">
                <span>My Profile</span>
                <div class="flex justify-between items-center">
                    <div>
                        @for ($i = 1; $i <= floor($user->rateInstructor); $i++)
                            <i class="fa-solid fa-star text-amber-500"></i>
                        @endfor
                        @if ($user->rateInstructor - floor($user->rateInstructor) >= 0.5)
                            <i class="fa-solid fa-star-half-stroke text-amber-500"></i>
                        @endif
                        @for ($i = 1; $i <= 5 - ceil($user->rateInstructor); $i++)
                            <i class="fa-solid fa-star text-gray-300"></i>
                        @endfor
                    </div>
                    @if (Auth::user()->id === $user->id)
                        <a href="{{ route('dashboard.profile.settings') }}"
                            class="ms-2 py-2 px-3 hover:bg-gray-200 duration-200 cursor-pointer rounded-xl text-gray-600">
                            <i class="fa-solid fa-sliders"></i>
                        </a>
                    @endif
                </div>
            </h2>
            <div class="flex flex-col md:flex-row gap-4 text-gray-800 dark:text-gray-100">
                <div class="flex flex-col gap-2 w-ful md:w-1/2 ">
                    <div>
                        <h3 class="font-bold">First Name</h3>
                        <p class="text-gray-700 dark:text-gray-200">{{ $user->name }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold">Registerion Date</h3>
                        <p class="text-gray-700 dark:text-gray-200">{{ $user->created_at->format('l jS \\of F Y') }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold">Email</h3>
                        <p class="text-gray-700 dark:text-gray-200 flex items-center space-between gap-2">
                            <span>{{ $user->email }}</span>
                            @if ($user->email_verified_at)
                                <img class="w-4 h-4" src="{{ asset('assets/images/icons/active.png') }}"
                                    alt="icon this account is Verfied">
                            @else
                                <img class="w-4 h-4" src="{{ asset('assets/images/icons/inactive.png') }}"
                                    alt="icon this account is Not Verfied">
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-ful md:w-1/2 ">
                    <div>
                        <h3 class="font-bold">User Name</h3>
                        <p class="text-gray-700 dark:text-gray-200">{{ $user->username }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold">Headline</h3>
                        <p class="text-gray-700 dark:text-gray-200">{{ $user->headline }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold">Tags</h3>
                        <p class="text-gray-700 dark:text-gray-200" title='{{ $tags }}'>
                            {{ \Str::limit($tags, 40) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="font-bold text-gray-800 dark:text-gray-100">Bio</h3>
                <p class="text-sm text-gray-700 dark:text-gray-200 break-words">
                    {{ $user->description }}
                </p>
            </div>
        </div>

        @if (!empty($courses))
            <hr class="block my-4 mx-auto w-2/3">
            <div
                class="p-4  rounded-xl border border-gray-200 bg-white flex gap-4 items-center flex-col md:flex-row justify-between">
                <h2 class="font-bold text-gray-800 dark:text-gray-200 text-2xl">Instructor Courses</h2>

                <div class="flex gap-4 font-bold text-gray-700 dark:text-gray-200 text-sm">
                    <div class="cursor-pointer" title="Courses">
                        <i class="fa-solid fa-play text-amber-700"></i>
                        <span>{{ $user->countCourses }}</span>
                    </div>
                    <div class="cursor-pointer" title="Time Lectures">
                        <i class="fa-solid fa-calendar-check text-amber-700"></i>
                        <span>{{ $user->timeLectures }}</span>
                    </div>
                    <div class="cursor-pointer" title="Lesson">
                        <i class="fa-solid fa-book-open-reader text-amber-700"></i>
                        <span>{{ $user->countLectures }}+</span>
                    </div>
                    <div class="cursor-pointer" title="students enrolled">
                        <i class="fa-solid fa-users-rectangle text-amber-700"></i>
                        <span>{{ $user->totalStudents }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-8 mt-4 text-gray-800 dark:text-gray-200">
                @foreach ($courses as $course)
                    <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                        <a href="{{ route('course-details', $course->id) }}" class="block rounded-xl overflow-hidden">
                            <img src="{{ json_decode($course->mockup)->url }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                                class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                        </a>
                        <div class="py-2 flex justify-between gap-2 items-center">
                            <div class="flex gap-2">
                                <img src="{{ isset($user->photo) ? $user->photo : asset('assets/images/user-1.png') }}"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/user-1.png') }}';"
                                    class="w-10 h-10 rounded-full" alt="photo Instructor">
                                <div>
                                    <h3 class=" font-bold hover:text-amber-600 duration-200">
                                        <a class="cursor-pointer">
                                            {{ $user->name }}
                                        </a>
                                    </h3>
                                    <span class="text-sm">{{ $user->headline }}</span>
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

                                <span>{{ $course->average_rating }} ({{ $course->totalReviews }})</span>
                            </div>
                            <div class="font-bold">
                                {{ $course->price ? '$' . $course->price : 'Free' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
