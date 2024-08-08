@extends('layouts.dashboard')
@section('title', 'My Courses')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
        <h2 class="font-bold text-xl mb-2 border-b border-gray-200 pb-2">Enrolled Courses</h2>
        <nav class="flex gap-x-2" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
            <button type="button" class="py-2 px-4 rounded-xl text-white bg-amber-500 hs-tab-active:bg-amber-700 active"
                id="basic-tabs-item-1" aria-selected="true" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                role="tab">
                Published (06)
            </button>
            <button type="button" class="py-2 px-4 rounded-xl text-white bg-amber-500 hs-tab-active:bg-amber-700"
                id="basic-tabs-item-2" aria-selected="false" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                role="tab">
                Pending (03)
            </button>
            <button type="button" class="py-2 px-4 rounded-xl text-white bg-amber-500 hs-tab-active:bg-amber-700"
                id="basic-tabs-item-3" aria-selected="false" data-hs-tab="#basic-tabs-3" aria-controls="basic-tabs-3"
                role="tab">
                Draft (01)
            </button>
        </nav>

        <div class="mt-3 p-4">
            <div id="basic-tabs-1" role="tabpanel" aria-labelledby="basic-tabs-item-1">
                <div
                    class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4 mt-2 text-gray-800 dark:text-gray-100">
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>

                </div>
            </div>
            <div id="basic-tabs-2" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-2">
                <div
                    class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4 mt-4 text-gray-800 dark:text-gray-100">
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="basic-tabs-3" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-3">
                <div
                    class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4 mt-4 text-gray-800 dark:text-gray-100">
                    <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
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
                                            href="{{ route('profile') }}">Thomas
                                            E.</a></h3>
                                    <span class="text-sm">Software developer</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('course-details') }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            Learn Angular Fundamentals From...
                        </a>
                        <hr>
                        <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
                            <a href="#" class="flex gap-2 hover:text-amber-600 duration-300">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span></a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
