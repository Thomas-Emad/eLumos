<header>
    <nav
        class="bg-white fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:bg-gray-900 dark:text-gray-200 dark:border-amber-700">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between container mx-auto p-4">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.png') }}" class="h-8" alt="eLumos Logo">
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <div class="flex items-center space-x-2">
                    <i
                        class="fa-solid fa-magnifying-glass px-3 py-1 text-sm border-2 border-amber-500 rounded-full text-gray-600 hover:bg-amber-500 hover:text-white cursor-pointer transition-all dark:text-gray-200"></i>
                    <i data-drawer-target="sidebar-cart" data-drawer-show="sidebar-cart" aria-controls="sidebar-cart"
                        class="fa-solid fa-basket-shopping px-3 py-1 text-sm  border-2 border-amber-500 rounded-full text-gray-600 hover:bg-amber-500 hover:text-white cursor-pointer transition-all dark:text-gray-200"></i>
                    <button id="theme-toggle" type="button"
                        class=" px-3 py-1 text-sm border-2 border-amber-500 rounded-full text-gray-600 hover:bg-amber-500 hover:text-white cursor-pointer transition-all dark:text-gray-200">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    @guest
                        <a href="{{ route('join') }}"
                            class="block py-2 px-3  @if (Route::is('join')) text-white bg-amber-500 @else text-gray-900 hover:bg-gray-100 @endif rounded dark:text-gray-200 dark:hover:bg-amber-600">Login
                            / Register</a>
                    @endguest
                    @auth
                        <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown"
                            data-dropdown-placement="bottom-start" class="w-10 h-10 rounded-full cursor-pointer"
                            src="{{ asset('assets/images/user-1.png') }}" alt="User dropdown">

                        <!-- Dropdown menu -->
                        <div id="userDropdown"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <div class="px-4 py-3 text-sm text-gray-900 dark:text-gray-200">
                                <div>{{ auth()->user()->name }}</div>
                                <div class="font-medium truncate">{{ auth()->user()->email }}</div>
                            </div>
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
                                <li>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-200">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard') }}/profile"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-200">Settings</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-200">Earnings</a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <a onclick="document.getElementById('form-logout').submit()"
                                    class="cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                                    out</a>
                                <form action="{{ route('logout') }}" method="post" id='form-logout'>
                                    @csrf
                                    <button type="submit" class="hidden"></button>
                                </form>
                            </div>
                        </div>

                    @endauth
                </div>
                <button data-collapse-toggle="navbar-sticky" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-sticky" aria-expanded="false">
                    <i
                        class="fa-solid fa-bars  px-2 text-lg border-2 border-amber-500 rounded text-gray-600 hover:bg-amber-500 hover:text-white cursor-pointer transition-all"></i>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul
                    class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="{{ route('home') }}"
                            class="block py-2 px-3  @if (Route::is('home')) text-white bg-amber-500 @else text-gray-900 hover:bg-gray-100 @endif rounded  dark:text-gray-200  dark:hover:bg-amber-600"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('courses') }}"
                            class="block py-2 px-3  @if (Route::is('courses')) text-white bg-amber-500 @else text-gray-900 hover:bg-gray-100 @endif rounded dark:text-gray-200 dark:hover:bg-amber-600">
                            Courese</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 dark:text-gray-200  dark:hover:bg-amber-600">
                            Blog</a>
                    </li>
                    <ul id="mega-menu-full">
                        <button id="mega-menu-full-dropdown-button" data-collapse-toggle="mega-menu-full-dropdown"
                            class="flex items-center py-2 px-3 text-gray-900 rounded hover:bg-gray-100 dark:text-gray-200  dark:hover:bg-amber-600">Pages
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        </li>
                    </ul>
                    @guest
                        <li>
                            <a href="{{ route('join') }}"
                                class="block py-2 px-3  @if (Route::is('courses')) text-white bg-amber-500 @else text-gray-900 hover:bg-gray-100 @endif rounded dark:text-gray-200 dark:hover:bg-amber-600 md:hidden">
                                Login / Register</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>


{{-- Dropdown Menu  --}}
<div id="mega-menu-full-dropdown"
    class="fixed hidden top-0 left-0 z-[4] mt-20 w-full bg-white rounded-lg border border-gray-100 shadow dark:bg-gray-900 dark:text-gray-200">
    <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-gray-900 dark:text-gray-200 sm:grid-cols-2 md:px-6">
        <ul>
            <li>
                <a href="{{ route('courses') }}" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="font-semibold">Courses</div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that
                        you're already using.</span>
                </a>
            </li>
            <li>
                <a href="{{ route('course-details') }}"
                    class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="font-semibold">Course Details</div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that
                        you're already using.</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}/add-course"
                    class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="font-semibold">Add New Course</div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that
                        you're already using.</span>
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}"
                    class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="font-semibold">Dashboard</div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that
                        you're already using.</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile') }}"
                    class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="font-semibold">Profile</div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that
                        you're already using.</span>
                </a>
            </li>
            <li>
                <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="font-semibold">Login / Register</div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that
                        you're already using.</span>
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="{{ route('privacy') }}"
                    class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="font-semibold">Privacy Policy</div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that
                        you're already using.</span>
                </a>
            </li>
            <li>
                <a href="{{ route('terms') }}" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="font-semibold">Terms & Conditions</div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that
                        you're already using.</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Sidebare Cart -->
<div id="sidebar-cart"
    class="fixed top-0 left-0 z-40 w-full md:w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
    tabindex="-1" aria-labelledby="sidebar-cart-label">
    <h5 id="sidebar-cart-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">SHOPPING
        LIST
    </h5>
    <button type="button" data-drawer-hide="sidebar-cart" aria-controls="sidebar-cart"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <div class="py-4 overflow-y-auto">
        <div class="flex flex-col gap-4 ">
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>
            <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <img src="{{ asset('assets/images/course-1.png') }}" class="w-16 h-16 rounded-xl" alt="photo cart">
                <div class="w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name One</span>
                        <span class="text-green-700">50$</span>
                    </div>
                    <a href="#"
                        class="inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300">remove</a>
                </div>
            </div>

            <a href="#" class="inline-block   text-sm p-2 w-full bg-gray-50">
                <span
                    class="inline-block w-full  p-2  text-green-600 border border-green-600 hover:text-white hover:bg-green-600 transition duration-300 rounded-xl ">
                    Open Cart
                </span>
            </a>
        </div>
    </div>
</div>
