@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl">
        <div class="grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-4">
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Enrolled Courses</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">13</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Active Courses</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">13</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Completed Courses</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">13</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Total Students</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">13</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Total Courses</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">13</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Total Earnings</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">$13</p>
            </div>
        </div>
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
                    <div
                        class="flex justify-between items-center gap-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-400  p-4 border-b border-b-gray-200 last-of-type:border-none only-of-type:border-none">
                        <a href="{{ route('course-details') }}"
                            class="flex gap-2 items-center text-lg hover:text-amber-600 duration-200">
                            <img src="{{ asset('assets/images/course-1.png') }}" alt="Image courses"
                                class="w-16 h-16 roundex-xl">
                            <h3>The
                                Complete Web
                                Developer Course 2.0</h3>
                        </a>
                        <div class="flex gap-4">
                            <span>10</span>
                            <span>Published</span>
                        </div>
                    </div>
                    <div
                        class="flex justify-between items-center gap-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-400  p-4 border-b border-b-gray-200 last-of-type:border-none only-of-type:border-none">
                        <a href="{{ route('course-details') }}"
                            class="flex gap-2 items-center text-lg hover:text-amber-600 duration-200">
                            <img src="{{ asset('assets/images/course-1.png') }}" alt="Image courses"
                                class="w-16 h-16 roundex-xl">
                            <h3>The
                                Complete Web
                                Developer Course 2.0</h3>
                        </a>
                        <div class="flex gap-4">
                            <span>10</span>
                            <span>Published</span>
                        </div>
                    </div>
                    <div
                        class="flex justify-between items-center gap-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-400  p-4 border-b border-b-gray-200 last-of-type:border-none only-of-type:border-none">
                        <a href="{{ route('course-details') }}"
                            class="flex gap-2 items-center text-lg hover:text-amber-600 duration-200">
                            <img src="{{ asset('assets/images/course-1.png') }}" alt="Image courses"
                                class="w-16 h-16 roundex-xl">
                            <h3>The
                                Complete Web
                                Developer Course 2.0</h3>
                        </a>
                        <div class="flex gap-4">
                            <span>10</span>
                            <span>Published</span>
                        </div>
                    </div>
                    <div
                        class="flex justify-between items-center gap-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-400  p-4 border-b border-b-gray-200 last-of-type:border-none only-of-type:border-none">
                        <a href="{{ route('course-details') }}"
                            class="flex gap-2 items-center text-lg hover:text-amber-600 duration-200">
                            <img src="{{ asset('assets/images/course-1.png') }}" alt="Image courses"
                                class="w-16 h-16 roundex-xl">
                            <h3>The
                                Complete Web
                                Developer Course 2.0</h3>
                        </a>
                        <div class="flex gap-4">
                            <span>10</span>
                            <span>Published</span>
                        </div>
                    </div>
                    <div
                        class="flex justify-between items-center gap-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-400  p-4 border-b border-b-gray-200 last-of-type:border-none only-of-type:border-none">
                        <a href="{{ route('course-details') }}"
                            class="flex gap-2 items-center text-lg hover:text-amber-600 duration-200">
                            <img src="{{ asset('assets/images/course-1.png') }}" alt="Image courses"
                                class="w-16 h-16 roundex-xl">
                            <h3>The
                                Complete Web
                                Developer Course 2.0</h3>
                        </a>
                        <div class="flex gap-4">
                            <span>10</span>
                            <span>Published</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <hr class="my-4">
        <h2 class="font-bold text-gray-800 dark:text-gray-200 text-2xl my-4">Recently Enrolled Courses</h2>
        <div class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-8 mt-4 text-gray-800 dark:text-gray-200">
            <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                    <img src="{{ asset('assets/images/article.png') }}"
                        class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                </a>
                <div class="py-2 flex justify-between gap-2 items-center">
                    <div class="flex gap-2">
                        <img src="{{ asset('assets/images/user-1.png') }}" class="w-10 h-10 rounded-full"
                            alt="photo Instructor">
                        <div>
                            <h3 class=" font-bold hover:text-amber-600 duration-200"><a
                                    href="{{ route('dashboard.profile') }}">Thomas
                                    E.</a></h3>
                            <span class="text-sm">Software developer</span>
                        </div>
                    </div>
                    <a href="#"><i
                            class="fa-solid fa-heart text-lg text-gray-300 hover:text-amber-400 duration-200"></i></a>
                </div>
                <a href="{{ route('course-details') }}"
                    class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                    Learn Angular Fundamentals From...
                </a>
                <hr>
                <div class="text-sm py-2 flex justify-between gap-2">
                    <div>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-gray-400"></i>
                        <span>4.0 (15)</span>
                    </div>
                    <div class="font-bold">
                        50$
                    </div>
                </div>
            </div>
            <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                    <img src="{{ asset('assets/images/article.png') }}"
                        class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                </a>
                <div class="py-2 flex justify-between gap-2 items-center">
                    <div class="flex gap-2">
                        <img src="{{ asset('assets/images/user-1.png') }}" class="w-10 h-10 rounded-full"
                            alt="photo Instructor">
                        <div>
                            <h3 class=" font-bold hover:text-amber-600 duration-200"><a
                                    href="{{ route('dashboard.profile') }}">Thomas
                                    E.</a></h3>
                            <span class="text-sm">Software developer</span>
                        </div>
                    </div>
                    <a href="#"><i
                            class="fa-solid fa-heart text-lg text-gray-300 hover:text-amber-400 duration-200"></i></a>
                </div>
                <a href="{{ route('course-details') }}"
                    class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                    Learn Angular Fundamentals From...
                </a>
                <hr>
                <div class="text-sm py-2 flex justify-between gap-2">
                    <div>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-gray-400"></i>
                        <span>4.0 (15)</span>
                    </div>
                    <div class="font-bold">
                        50$
                    </div>
                </div>
            </div>
            <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                    <img src="{{ asset('assets/images/article.png') }}"
                        class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                </a>
                <div class="py-2 flex justify-between gap-2 items-center">
                    <div class="flex gap-2">
                        <img src="{{ asset('assets/images/user-1.png') }}" class="w-10 h-10 rounded-full"
                            alt="photo Instructor">
                        <div>
                            <h3 class=" font-bold hover:text-amber-600 duration-200"><a
                                    href="{{ route('dashboard.profile') }}">Thomas
                                    E.</a></h3>
                            <span class="text-sm">Software developer</span>
                        </div>
                    </div>
                    <a href="#"><i
                            class="fa-solid fa-heart text-lg text-gray-300 hover:text-amber-400 duration-200"></i></a>
                </div>
                <a href="{{ route('course-details') }}"
                    class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                    Learn Angular Fundamentals From...
                </a>
                <hr>
                <div class="text-sm py-2 flex justify-between gap-2">
                    <div>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-gray-400"></i>
                        <span>4.0 (15)</span>
                    </div>
                    <div class="font-bold">
                        50$
                    </div>
                </div>
            </div>
            <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                    <img src="{{ asset('assets/images/article.png') }}"
                        class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                </a>
                <div class="py-2 flex justify-between gap-2 items-center">
                    <div class="flex gap-2">
                        <img src="{{ asset('assets/images/user-1.png') }}" class="w-10 h-10 rounded-full"
                            alt="photo Instructor">
                        <div>
                            <h3 class=" font-bold hover:text-amber-600 duration-200"><a
                                    href="{{ route('dashboard.profile') }}">Thomas
                                    E.</a></h3>
                            <span class="text-sm">Software developer</span>
                        </div>
                    </div>
                    <a href="#"><i
                            class="fa-solid fa-heart text-lg text-gray-300 hover:text-amber-400 duration-200"></i></a>
                </div>
                <a href="{{ route('course-details') }}"
                    class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                    Learn Angular Fundamentals From...
                </a>
                <hr>
                <div class="text-sm py-2 flex justify-between gap-2">
                    <div>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-gray-400"></i>
                        <span>4.0 (15)</span>
                    </div>
                    <div class="font-bold">
                        50$
                    </div>
                </div>
            </div>
            <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                    <img src="{{ asset('assets/images/article.png') }}"
                        class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                </a>
                <div class="py-2 flex justify-between gap-2 items-center">
                    <div class="flex gap-2">
                        <img src="{{ asset('assets/images/user-1.png') }}" class="w-10 h-10 rounded-full"
                            alt="photo Instructor">
                        <div>
                            <h3 class=" font-bold hover:text-amber-600 duration-200"><a
                                    href="{{ route('dashboard.profile') }}">Thomas
                                    E.</a></h3>
                            <span class="text-sm">Software developer</span>
                        </div>
                    </div>
                    <a href="#"><i
                            class="fa-solid fa-heart text-lg text-gray-300 hover:text-amber-400 duration-200"></i></a>
                </div>
                <a href="{{ route('course-details') }}"
                    class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                    Learn Angular Fundamentals From...
                </a>
                <hr>
                <div class="text-sm py-2 flex justify-between gap-2">
                    <div>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-gray-400"></i>
                        <span>4.0 (15)</span>
                    </div>
                    <div class="font-bold">
                        50$
                    </div>
                </div>
            </div>
            <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                    <img src="{{ asset('assets/images/article.png') }}"
                        class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                </a>
                <div class="py-2 flex justify-between gap-2 items-center">
                    <div class="flex gap-2">
                        <img src="{{ asset('assets/images/user-1.png') }}" class="w-10 h-10 rounded-full"
                            alt="photo Instructor">
                        <div>
                            <h3 class=" font-bold hover:text-amber-600 duration-200"><a
                                    href="{{ route('dashboard.profile') }}">Thomas
                                    E.</a></h3>
                            <span class="text-sm">Software developer</span>
                        </div>
                    </div>
                    <a href="#"><i
                            class="fa-solid fa-heart text-lg text-gray-300 hover:text-amber-400 duration-200"></i></a>
                </div>
                <a href="{{ route('course-details') }}"
                    class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                    Learn Angular Fundamentals From...
                </a>
                <hr>
                <div class="text-sm py-2 flex justify-between gap-2">
                    <div>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-amber-400"></i>
                        <i class="fa-solid fa-star text-gray-400"></i>
                        <span>4.0 (15)</span>
                    </div>
                    <div class="font-bold">
                        50$
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
