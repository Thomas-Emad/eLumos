@extends('layouts.app')
@section('title', 'Courses')

@section('content')
    <div class="container mx-auto max-w-screen-xl p-4 flex flex-col-reverse md:flex-row gap-4 mt-20">
        <div class="w-full md:w-2/3">
            <form class="flex gap-3 w-full">
                <div class="w-full">
                    <label for="search" class="mb-2 text-sm font-sm text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="search"
                            class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-amber-500 focus:border-amber-500 "
                            placeholder="Search Mockups, Logos..." required />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-amber-700 hover:bg-amber-800 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-2 py-1">Search</button>
                    </div>
                </div>
                <select id="countries"
                    class="w-fit bg-white dark:bg-gray-700 border border-gray-300 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 p-2.5">
                    <option value="0" selected>Highest Rated</option>
                    <option value="0">Newly published</option>
                    <option value="0">Low Price</option>
                    <option value="0">Free</option>
                </select>
            </form>
            <div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4 mt-4 text-gray-800 dark:text-gray-100">
                @foreach ($courses as $course)
                    <div class="p-2 bg-white dark:bg-gray-700  border border-gray-200 rounded-xl">
                        <a href="{{ route('course-details', $course->id) }}" class="block rounded-xl overflow-hidden">
                            <img src="{{ asset('assets/images/article.png') }}"
                                class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                        </a>
                        <div class="py-2 flex justify-between gap-2 items-center">
                            <div class="flex gap-2">
                                <img src="{{ $course->user->photo ? asset('storage/' . $course->user->photo) : asset('assets/images/user-1.png') }}"
                                    class="w-10 h-10 rounded-full" alt="photo Instructor">
                                <div>
                                    <h3 class=" font-bold hover:text-amber-600 duration-200">
                                        <a href="{{ route('dashboard.profile', $course->user->id) }}">
                                            {{ $course->user->name }}
                                        </a>
                                    </h3>
                                    <span class="text-sm">{{ $course->user->headline }}</span>
                                </div>
                            </div>

                            <form action="{{ route('wishlist.controll', $course->id) }}" method='POST'>
                                @csrf
                                @if (Auth::check() &&
                                        $course->wishlist()->where('user_id', auth()->user()->id)->whereNull('deleted_at')->exists())
                                    <button type="submit" name="type" value="remove">
                                        <i
                                            class="fa-solid fa-heart text-lg  text-amber-400 hover:text-gray-300 duration-200"></i>
                                    </button>
                                @else
                                    <button type="submit" name="type" value="add">
                                        <i
                                            class="fa-solid fa-heart text-lg  text-gray-300 hover:text-amber-400 duration-200"></i>
                                    </button>
                                @endif
                            </form>
                        </div>
                        <a href="{{ route('course-details', $course->id) }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            {{ Str::limit($course->title, 20) }}
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
                                {{ $course->price }}$
                            </div>
                        </div>

                        @php
                            $isInCart = Auth::check()
                                ? $course->basket->exsits()
                                : in_array($course->id, unserialize(request()->cookie('baskets')));
                            $textButton = $isInCart ? 'Remove Cart' : 'Add To Cart';
                        @endphp
                        <button type="button" data-id="{{ $course->id }}" data-type='add'
                            class="add-to-cart block w-full font-bold text-sm text-center py-1 px-2  rounded-full border border-amber-600 text-amber-600 hover:bg-amber-600 hover:text-white duration-300">
                            {{ $textButton }}
                        </button>
                    </div>
                @endforeach
                {{ $courses->links() }}
            </div>
            @if ($courses->count() === 0)
                <p class="text-center italic my-8">Sorry, it look we Don't have any course, back later Please.</p>
            @endif
        </div>
        <div class="w-full md:w-1/3 flex gap-4 flex-col">
            <div
                class="text-gray-700 dark:text-gray-100 flex justify-between gap-3 text-lg p-2 border-b bg-white dark:bg-gray-700 rounded-xl border-gray-200">
                <span>
                    <i class="fa-solid fa-filter"></i>
                    <span>Filters</span>
                </span>
                <a href="#" class="hover:text-amber-700 duration-200">CLEAR</a>
            </div>
            <div id="ratings" data-accordion="open"
                class=" text-gray-700 flex flex-col gap-3 text-lg p-3 border bg-white dark:bg-gray-700 rounded-xl border-gray-200">
                <h2 id="ratings-heading-1">
                    <button type="button" data-accordion-target="#ratings-body-1"
                        class="flex justify-between items-center gap-2 w-full  bg-transparent px-2 rounded-xl"
                        aria-expanded="true" aria-controls="ratings-body-1">
                        <span>Ratings</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="ratings-body-1" class="hidden" aria-labelledby="ratings-heading-1">
                    <label for="five-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 dark:text-gray-100 p-1 rounded-xl duration-150 hover:bg-gray-50">
                        <div class="flex items-center gap-2">
                            <input checked id="five-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <div>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <span>5.0 (15)</span>
                            </div>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                    <label for="four-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="four-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <div>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-gray-400"></i>
                                <span>4.0 (15)</span>
                            </div>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                    <label for="three-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="three-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <div>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <i class="fa-solid fa-star text-gray-400"></i>
                                <i class="fa-solid fa-star text-gray-400"></i>
                                <span>3.0 (15)</span>
                            </div>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                </div>
            </div>
            <div id="price" data-accordion="open"
                class=" text-gray-700 flex flex-col gap-3 text-lg p-3 border bg-white dark:bg-gray-700 rounded-xl border-gray-200">
                <h2 id="price-heading-1">
                    <button type="button" data-accordion-target="#price-body-1"
                        class="flex justify-between items-center gap-2 w-full bg-transparent px-2 rounded-xl"
                        aria-expanded="true" aria-controls="price-body-1">
                        <span>Price</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="price-body-1" class="hidden" aria-labelledby="price-heading-1">
                    <label for="free-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="free-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>free</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>

                    <label for="paid-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="paid-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>paid</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>

                </div>

            </div>
            <div id="category" data-accordion="open"
                class=" text-gray-700 flex flex-col gap-3 text-lg p-3 border bg-white dark:bg-gray-700 rounded-xl border-gray-200">
                <h2 id="category-heading-1">
                    <button type="button" data-accordion-target="#category-body-1"
                        class="flex justify-between items-center gap-2 w-full bg-transparent px-2 rounded-xl"
                        aria-expanded="true" aria-controls="category-body-1">
                        <span>Course categories</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="category-body-1" class="hidden" aria-labelledby="category-heading-1">
                    <label for="php-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="php-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>php</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                    <label for="laravel-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="laravel-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>laravel</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                    <label for="vue-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="vue-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>vue</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                    <label for="mysql-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="mysql-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>MySQL</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                </div>

            </div>
            <div id="level" data-accordion="open"
                class=" text-gray-700 flex flex-col gap-3 text-lg p-3 border bg-white dark:bg-gray-700 rounded-xl border-gray-200">
                <h2 id="level-heading-1">
                    <button type="button" data-accordion-target="#level-body-1"
                        class="flex justify-between items-center gap-2 w-full bg-transparent px-2 rounded-xl"
                        aria-expanded="true" aria-controls="level-body-1">
                        <span>Level</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="level-body-1" class="hidden" aria-labelledby="level-heading-1">
                    <label for="all-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="all-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>All Of Levels</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                    <label for="beginner-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="beginner-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>Beginner</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                    <label for="intermediate-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="intermediate-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>Intermediate</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                    <label for="expert-checkbox"
                        class="flex justify-between items-center cursor-pointer gap-2 w-full ms-2 text-sm font-medium text-gray-900 p-1 rounded-xl duration-150 hover:bg-gray-50 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <input checked id="expert-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span>Expert</span>
                        </div>
                        <span class="text-gray-600 dark:text-gray-100">(30)</span>
                    </label>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
