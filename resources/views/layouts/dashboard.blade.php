@extends('layouts.app')

@section('content')
    <div class="min-h-60 bg-center bg-contain relative mt-16 flex items-center"
        style="background-image: url({{ asset('assets/images/dashboard.jpg') }})">
        <div class="absolute top-0 left-0 w-full h-full z-[1] bg-[#22222299] "></div>
        <div class="container mx-auto max-w-screen-xl px-4 py-8 relative z-[2] text-white text-center">
            <h1 class="text-6xl font-bold">@yield('title')</h1>
        </div>
    </div>

    <div class="container max-w-screen-xl mx-auto p-4 flex flex-col md:flex-row gap-4">
        <div class="w-full md:w-1/4">
            <div class="rounded-xl border border-gray-200 overflow-hidden bg-white dark:bg-gray-700">
                <div class="h-20 bg-amber-500 w-full"></div>
                <img src="{{ isset($user->photo) ? $user->photo : asset('assets/images/user-1.png') }}"
                    onerror="this.onerror=null;this.src='{{ asset('assets/images/user-1.png') }}';" alt="photo user"
                    class="w-24 h-24 rounded-full mx-auto border-2 border-solid border-white" style="margin-top:-3rem">
                <div class="p-3">
                    <div class="flex items-center gap-1 flex-col">
                        <h2 class="font-bold text-xl text-gray-900 dark:text-white hover:text-amber-600 duration-200">
                            <a href="{{ route('dashboard.profile') }}">{{ auth()->user()->name }}</a>
                        </h2>
                        <span class="text-gray-800 dark:text-gray-300">{{ auth()->user()->roles()->first()->name }}</span>
                    </div>
                    @haspermission('instructors-control-courses')
                        <a href="{{ route('dashboard.instructor.courses.create') }}"
                            class="block border border-amber-600 text-amber-600 font-bold hover:text-white hover:bg-amber-600 duration-300 text-center px-1 py-2 rounded-xl mt-2 text-sm">Add
                            New Course</a>
                    @endhaspermission
                </div>
            </div>
            <div class='rounded-xl border border-gray-200 overflow-hidden bg-white dark:bg-gray-700 p-3 mt-3'>
                <ul class="text-gray-800 dark:text-gray-300">
                    <div>
                        <h2 class="font-bold text-gray-900 text-lg dark:text-gray-50 mb-2">Dashboard</h2>
                        <li><a href="{{ route('dashboard.index') }}"
                                class="flex items-center gap-2 @if (Route::is('dashboard.index')) text-amber-600 @endif  hover:text-amber-600 duration-200">
                                <i class="fa-solid fa-chart-simple "></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li><a href="{{ route('dashboard.profile') }}"
                                class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.profile')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                <i class="fa-solid fa-user "></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li><a href="{{ route('dashboard.courses-list') }}"
                                class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.courses-list')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <span>Enrolled Courses</span>
                            </a>
                        </li>

                        <li><a href="{{ route('dashboard.student.exams.index') }}"
                                class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.student.exams.index')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                <i class="fa-solid fa-clipboard-question"></i>
                                <span>Previous Exams</span>
                            </a>
                        </li>
                    </div>

                    <div>
                        <hr class="mx-6 my-4">
                        <h2 class="font-bold text-gray-900 text-lg dark:text-gray-50">Blog</h2>
                        <li>
                            <a href="{{ route('dashboard.articles.index') }}"
                                class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.articles.index')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                <i class="fa-solid fa-heart"></i>
                                <span>Articles</span>
                            </a>
                        </li>
                    </div>
                    <div>
                        <hr class="mx-6 my-4">
                        <h2 class="font-bold text-gray-900 text-lg dark:text-gray-50">Others</h2>
                        <li>
                            <a href="{{ route('dashboard.wishlist') }}"
                                class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.wishlist')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                <i class="fa-solid fa-heart"></i>
                                <span>Wishlist</span>
                            </a>
                        </li>
                        <li><a href="{{ route('dashboard.reviews.index') }}"
                                class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.reviews.index')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                <i class="fa-solid fa-star"></i>
                                <span>Reviews</span>
                            </a>
                        </li>
                        <li><a href="{{ route('dashboard.orders.index') }}"
                                class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.orders.index')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span>Payments</span>
                            </a>
                        </li>
                        <li><a href="{{ route('notifications.index') }}"
                                class="mt-2 flex items-center gap-2 @if (Route::is('notifications.index')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                <i class="fa-solid fa-bell"></i>
                                <span>Notifications</span>
                            </a>
                        </li>
                    </div>
                    {{-- 
                    <li><a href="{{ route('dashboard.index') }}/messages"
                            class="mt-2 flex items-center gap-2 @if (request()->is('dashboard/messages')) @endif hover:text-amber-600 duration-200">
                            <i class="fa-solid fa-comment-dots"></i>
                            <span>Messages</span>
                        </a>
                    </li> --}}
                    <li><a href="{{ route('dashboard.tickets.index') }}"
                            class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.tickets.index'))  @endif hover:text-amber-600 duration-200">
                            <i class="fa-solid fa-ticket"></i>
                            <span>Support Tickets</span>
                        </a>
                    </li>
                    @haspermission('instructors-control-courses')
                        <div>
                            <hr class="mx-6 my-4">
                            <h2 class="font-bold text-gray-900 text-lg dark:text-gray-50">Instructor</h2>
                            <li><a href="{{ route('dashboard.instructor.courses.index') }}"
                                    class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.instructor.courses.index')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    <span>My Courses</span>
                                </a>
                            </li>
                            @haspermission('instructors-control-exams')
                                <li><a href="{{ route('dashboard.instructor.exams.index') }}"
                                        class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.instructor.exams.index')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                        <i class="fa-solid fa-clipboard-question"></i>
                                        <span>Exams</span>
                                    </a>
                                </li>
                            @endhaspermission
                            <li><a href="{{ route('dashboard.review.log.index') }}"
                                    class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.review.log.index')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                    <span>Review Logs</span>
                                </a>
                            </li>
                            <hr class="mx-6 my-4">
                        </div>
                    @endhaspermission
                    <div>
                        @canAny(['roles', 'admin-control-courses'])
                            <hr class="mx-6 my-4">
                            <h2 class="font-bold text-gray-900 text-lg dark:text-gray-50">Mangement</h2>
                            @haspermission('roles')
                                <li><a href="{{ route('roles.index') }}"
                                        class="mt-2 flex items-center gap-2 @if (Route::is('roles.index')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                        <i class="fa-solid fa-user-gear"></i>
                                        <span>Roles</span>
                                    </a>
                                </li>
                            @endhaspermission
                            @haspermission('admin-control-courses')
                                <li class="flex justify-between items-center gap-2">
                                    <a href="{{ route('dashboard.admin.courses') }}"
                                        class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.admin.courses')) text-amber-600 @endif hover:text-amber-600 duration-200">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        <span>Courses</span>
                                    </a>
                                    <span
                                        class="bg-gray-600/70 px-2 py-1 rounded-xl text-xs text-white">({{ \App\Models\Course::where('status', 'pending')->count() }})</span>
                                </li>
                            @endhaspermission
                        @endcanAny
                    </div>
                    <div>
                        @can(['support'])
                            <hr class="mx-6 my-4">
                            <h2 class="font-bold text-gray-900 text-lg dark:text-gray-50">Support</h2>
                        @endcan
                        @haspermission('admin-control-courses')
                            <li><a href="{{ route('dashboard.tickets.index') }}"
                                    class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.tickets.index'))  @endif hover:text-amber-600 duration-200">
                                    <i class="fa-solid fa-ticket"></i>
                                    <span>Support Tickets</span>
                                </a>
                            </li>
                        @endhaspermission

                        @can(['roles', 'admin-control-courses'])
                            <hr class="mx-6 my-4">
                        @endcan
                    </div>
                </ul>
                <h2 class="font-bold text-gray-900 text-lg dark:text-gray-50">Account Settings</h2>
                <ul class="mt-2 text-gray-800 dark:text-gray-300">
                    <li><a href="{{ route('dashboard.profile.settings') }}"
                            class="mt-2 flex items-center gap-2 @if (Route::is('dashboard.profile.settings')) text-amber-600 @endif hover:text-amber-600 duration-200">
                            <i class="fa-solid fa-sliders"></i> <span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="document.getElementById('form-logout').submit()"
                            class="mt-2 flex items-center gap-2 cursor-pointer hover:text-amber-600 duration-200">
                            <i class="fa-solid fa-right-from-bracket"></i> <span>logout</span>
                        </a>
                        <form action="{{ route('logout') }}" method="post" id='form-logout'>
                            @csrf
                            <button type="submit" class="hidden"></button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="w-full md:w-3/4">
            @yield('content-dashboard')
        </div>
    </div>
@endsection
