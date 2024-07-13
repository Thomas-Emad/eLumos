<header>
    <nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between container mx-auto p-4">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.png') }}" class="h-8" alt="eLumos Logo">
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <div class="flex items-center space-x-2">
                    <i
                        class="fa-solid fa-magnifying-glass px-3 py-1 text-sm border-2 border-amber-500 rounded-full text-gray-600 hover:bg-amber-500 hover:text-white cursor-pointer transition-all "></i>
                    <i data-drawer-target="sidebar-cart" data-drawer-show="sidebar-cart" aria-controls="sidebar-cart"
                        class="fa-solid fa-basket-shopping px-3 py-1 text-sm  border-2 border-amber-500 rounded-full text-gray-600 hover:bg-amber-500 hover:text-white cursor-pointer transition-all "></i>
                    <a href="{{ route('join') }}"
                        class=" py-2 px-3 rounded hidden md:block @if (Route::is('join')) text-white bg-amber-500 @else text-gray-900 hover:bg-gray-100 @endif">Login
                        / Register</a>
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
                            class="block py-2 px-3  @if (Route::is('home')) text-white bg-amber-500 @else text-gray-900 hover:bg-gray-100 @endif rounded  "
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('courses') }}"
                            class="block py-2 px-3 rounded @if (Route::is('courses')) text-white bg-amber-500 @else text-gray-900 hover:bg-gray-100 @endif">
                            Courese</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 ">
                            Blog</a>
                    </li>
                    <li>
                        <a href="{{ route('join') }}"
                            class="block py-2 px-3 rounded @if (Route::is('join')) text-white bg-amber-500 @else text-gray-900 hover:bg-gray-100 @endif md:hidden">
                            Login / Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Sidebare Cart -->
<div id="sidebar-cart"
    class="fixed top-0 left-0 z-40 w-full md:w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
    tabindex="-1" aria-labelledby="sidebar-cart-label">
    <h5 id="sidebar-cart-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">SHOPPING LIST
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
