@extends('layouts.app')
@section('title', 'course details')


@section('content')
    <div class="min-h-60 bg-center bg-cover bg-no-repear relative mt-16"
        style="background-image:url('{{ asset('assets/images/education.png') }}')">
        <div class="absolute top-0 left-0 w-full h-full z-[1] bg-[#22222299] "></div>
        <div class="container mx-auto max-w-screen-xl px-4 py-8 relative z-[2]">
            <div class="text-white w-full md:w-[65%]">
                <div class="flex justify-between items-start md:items-center flex-col md:flex-row gap-2">
                    <div class="flex gap-4 items-center">
                        <div class="flex gap-4 items-center">
                            <img src="{{ asset('assets/images/user-1.png') }}" alt="user photo"
                                class="rounded-full w-12 h-12">
                            <div>
                                <a href="#" class="block transition duration-300 hover:text-amber-600 font-bold">
                                    Thomas Emad
                                </a>
                                <p>UX/UI Designer</p>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <i class="fa-solid fa-star text-sm text-amber-500"></i>
                            <i class="fa-solid fa-star text-sm text-amber-500"></i>
                            <i class="fa-solid fa-star text-sm text-amber-500"></i>
                            <i class="fa-solid fa-star text-sm text-amber-500"></i>
                            <i class="fa-solid fa-star text-sm text-white"></i>
                            <div class="text-sm"><span class="text-gray-200">4.4</span> <span>(200)</span></div>
                        </div>
                    </div>
                    <div class="inline-block py-2 px-3 text-white text-sm font-bold bg-amber-600 rounded-full mt-1">WEB
                        DEVELPMENT</div>
                </div>
                <div class="mt-4">
                    <h1 class="font-bold text-2xl">The Complete Web Developer Course 2.0</h1>
                    <p class="text-sm">Learn Web Development by building 25 websites and mobile apps using HTML, CSS,
                        Javascript, PHP, Python, MySQL & more!</p>
                </div>
                <div class="mt-4 flex gap-4 text-sm">
                    <div class="flex gap-2 items-center">
                        <img src="{{ asset('assets/images/icons/lesson.png') }}" alt="icon lesson count" class="w-5 h-5">
                        <span>12+ Lesson</span>
                    </div>
                    <div class="flex gap-2 items-center">
                        <img src="{{ asset('assets/images/icons/time.png') }}" alt="icon time count" class="w-5 h-5">
                        <span>9hr 30min</span>
                    </div>
                    <div class="flex gap-2 items-center">
                        <img src="{{ asset('assets/images/icons/students.png') }}" alt="icon students count"
                            class="w-5 h-5">
                        <span>32 students enrolled</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-screen-xl p-4 flex flex-col md:flex-row gap-4">
        <div class="w-full md:w-2/3 ">
            <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200">
                <h2 class="font-bold text-xl text-amber-700 mb-3">Overview</h2>
                <div class="text-sm">
                    <h3 class="font-bold">Course Description</h3>
                    <p class="text-gray-600 dark:text-gray-100">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap into electronic typesetting, remaining essentially unchanged.
                        <br>
                        <br>
                        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                        and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem
                        Ipsum.
                    </p>
                </div>
                <div class="text-sm mt-2">
                    <h3 class="font-bold">What you'll learn</h3>
                    <div class="text-gray-600 dark:text-gray-100 ps-2">
                        <p>test one</p>
                        <p>test one</p>
                        <p>test one</p>
                        <p>test one</p>
                        <p>test one</p>
                    </div>
                </div>
                <div class="text-sm mt-2">
                    <h3 class="font-bold">Requirements</h3>
                    <div class="text-gray-600 dark:text-gray-100 ps-2">
                        <p>test one</p>
                        <p>test one</p>
                        <p>test one</p>
                        <p>test one</p>
                        <p>test one</p>
                    </div>
                </div>

            </div>
            <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 mt-4">
                <div class="flex justify-between gap-2 items-center font-bold">
                    <h2 class=" text-xl text-amber-700 mb-3">Course Content</h2>
                    <div>
                        92 Lectures 10:56:11
                    </div>
                </div>

                <div id="accordion-collapse" data-accordion="collapse">
                    <div
                        class="border first:border-b-0 only-of-type:border even:border-b-0   border-gray-200 first-of-type:rounded-t-xl last-of-type:rounded-b-xl only-of-type:rounded-xl  overflow-hidden">
                        <h2 id="accordion-collapse-heading-1">
                            <button type="button"
                                class="flex items-center justify-between w-full px-4 py-2 font-sm rtl:text-right text-gray-500   hover:bg-gray-100 gap-3 "
                                data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                                aria-controls="accordion-collapse-body-1">
                                <span>The first parts</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                            <div class="p-2 border border-b-0 border-gray-200 text-gray-600 dark:text-gray-100 text-sm">
                                <div
                                    class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                    <div>
                                        <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                        <span>Lecture1.1 Introduction to the User Experience Course</span>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="underline hover:text-amber-600 duration-300 mr-1">Preview</a>
                                        <span>03:00</span>
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                    <div>
                                        <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                        <span>Lecture1.1 Introduction to the User Experience Course</span>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="underline hover:text-amber-600 duration-300 mr-1">Preview</a>
                                        <span>03:00</span>
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                    <div>
                                        <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                        <span>Lecture1.1 Introduction to the User Experience Course</span>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="underline hover:text-amber-600 duration-300 mr-1">Preview</a>
                                        <span>03:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="border first:border-b-0 only-of-type:border even:border-b-0  border-gray-200 first-of-type:rounded-t-xl last-of-type:rounded-b-xl only-of-type:rounded-xl  overflow-hidden">
                        <h2 id="accordion-collapse-heading-2">
                            <button type="button"
                                class="flex items-center justify-between w-full px-4 py-2 font-sm rtl:text-right text-gray-500   hover:bg-gray-100 gap-3 "
                                data-accordion-target="#accordion-collapse-body-2" aria-expanded="true"
                                aria-controls="accordion-collapse-body-2">
                                <span>The Second parts</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-2" class="hidden"
                            aria-labelledby="accordion-collapse-heading-2">
                            <div class="p-2 border border-b-0 border-gray-200 text-gray-600 dark:text-gray-100 text-sm">
                                <div
                                    class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                    <div>
                                        <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                        <span>Lecture1.1 Introduction to the User Experience Course</span>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="underline hover:text-amber-600 duration-300 mr-1">Preview</a>
                                        <span>03:00</span>
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                    <div>
                                        <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                        <span>Lecture1.1 Introduction to the User Experience Course</span>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="underline hover:text-amber-600 duration-300 mr-1">Preview</a>
                                        <span>03:00</span>
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                    <div>
                                        <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                        <span>Lecture1.1 Introduction to the User Experience Course</span>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="underline hover:text-amber-600 duration-300 mr-1">Preview</a>
                                        <span>03:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="border first:border-b-0 only-of-type:border even:border-b-0   border-gray-200 first-of-type:rounded-t-xl last-of-type:rounded-b-xl only-of-type:rounded-xl  overflow-hidden">
                        <h2 id="accordion-collapse-heading-3">
                            <button type="button"
                                class="flex items-center justify-between w-full px-4 py-2 font-sm rtl:text-right text-gray-500   hover:bg-gray-100 gap-3 "
                                data-accordion-target="#accordion-collapse-body-3" aria-expanded="true"
                                aria-controls="accordion-collapse-body-3">
                                <span>The There parts</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-3" class="hidden"
                            aria-labelledby="accordion-collapse-heading-3">
                            <div class="p-2 border border-b-0 border-gray-200 text-gray-600 dark:text-gray-100 text-sm">
                                <div
                                    class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                    <div>
                                        <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                        <span>Lecture1.1 Introduction to the User Experience Course</span>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="underline hover:text-amber-600 duration-300 mr-1">Preview</a>
                                        <span>03:00</span>
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                    <div>
                                        <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                        <span>Lecture1.1 Introduction to the User Experience Course</span>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="underline hover:text-amber-600 duration-300 mr-1">Preview</a>
                                        <span>03:00</span>
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between gap-2 border-b-2 border-gray-100 last-of-type:border-none p-2">
                                    <div>
                                        <i class="fa-solid fa-play text-amber-600 mr-1"></i>
                                        <span>Lecture1.1 Introduction to the User Experience Course</span>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="underline hover:text-amber-600 duration-300 mr-1">Preview</a>
                                        <span>03:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 mt-4">
                <h3 class="font-bold text-xl pb-2">About the instructor</h3>
                <div class="flex justify-between items-center gap-2 border-b border-gray-200 py-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user-1.png') }}" class="w-12 h-12 rounded-full"
                            alt="user photo">
                        <div>
                            <h4 class="font-bold text-xl hover:text-amber-500 duration-300">
                                <a href="#">Nicole Brown</a>
                            </h4>
                            <p class="text-sm ">UX/UI Designer</p>
                        </div>
                    </div>
                    <div class="text-sm">
                        <i class="fa-solid fa-star  text-amber-400"></i>
                        <i class="fa-solid fa-star  text-amber-400"></i>
                        <i class="fa-solid fa-star  text-amber-400"></i>
                        <i class="fa-solid fa-star  text-amber-400"></i>
                        <i class="fa-solid fa-star  text-gray-400"></i>
                        <span>4.5 Instructor Rating</span>
                    </div>
                </div>
                <div
                    class="flex gap-4 border-b border-gray-200 py-4 font-bold text-gray-700 dark:text-gray-200 text-sm mb-1">
                    <div>
                        <i class="fa-solid fa-play text-amber-700"></i>
                        <span>5 Courses</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-calendar-check text-amber-700"></i>
                        <span>9hr 30min</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-book-open-reader text-amber-700"></i>
                        <span>12+ Lesson</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-users-rectangle text-amber-700"></i>
                        <span>270,866 students enrolled</span>
                    </div>
                </div>
                <div class="text-gray-800 dark:text-gray-200 text-sm whitespace-pre-line">
                    UI/UX Designer, with 7+ Years Experience. Guarantee of High Quality Work.

                    Skills: Web Design, UI Design, UX/UI Design, Mobile Design, User Interface Design, Sketch, Photoshop,
                    GUI, Html, Css, Grid Systems, Typography, Minimal, Template, English, Bootstrap, Responsive Web Design,
                    Pixel Perfect, Graphic Design, Corporate, Creative, Flat, Luxury and much more.

                    Available for:

                    1. Full Time Office Work
                    2. Remote Work
                    3. Freelance
                    4. Contract
                    5. Worldwide
                </div>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 mt-4">
                <h3 class="font-bold text-xl pb-2">Reviews</h3>
                <div class="flex justify-between items-center gap-2 border-b border-gray-200 py-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user-1.png') }}" class="w-12 h-12 rounded-full"
                            alt="user photo">
                        <div>
                            <h4 class="font-bold text-xl hover:text-amber-500 duration-300">
                                <a href="#">Nicole Brown</a>
                            </h4>
                            <p class="text-sm ">UX/UI Designer</p>
                        </div>
                    </div>
                    <div class="text-sm">
                        <i class="fa-solid fa-star  text-amber-400"></i>
                        <i class="fa-solid fa-star  text-amber-400"></i>
                        <i class="fa-solid fa-star  text-amber-400"></i>
                        <i class="fa-solid fa-star  text-amber-400"></i>
                        <i class="fa-solid fa-star  text-gray-400"></i>
                        <span>4.5 Instructor Rating</span>
                    </div>
                </div>
                <p>
                    <q class="text-gray-800 dark:text-gray-200 text-sm  italic">Lorem, ipsum dolor sit amet consectetur
                        adipisicing
                        elit. Nemo, atque soluta suscipit nobis reiciendis
                        odio velit? At quasi ab distinctio, quo pariatur velit nulla quod praesentium eveniet, non vitae.
                        Ducimus?</q>
                </p>
                <button data-modal-target="reviews-modal" data-modal-toggle="reviews-modal"
                    class="w-full mt-2 px-4 py-2 text-sm font-bold text-center text-amber-600 border border-amber-600 hover:text-white hover:bg-amber-600 duration-300 rounded-full">See
                    All Reviews</button>
            </div>
        </div>
        <div class="w-full md:w-1/3 h-fit -translate-y-0 md:-translate-y-52 z-[2] flex flex-col gap-4">
            <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 ">
                <div class="relative cursor-pointer rounded-xl overflow-hidden" data-modal-target="video-preview"
                    data-modal-toggle="video-preview">
                    <img src="{{ asset('assets/images/courses.png') }}" class="w-full h-full " alt="view course">
                    <div
                        class="px-4 py-2 rounded-full bg-gray-300/75 w-fit absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transition duration-300 hover:bg-gray-300 z-[2]">
                        <i class="fa-solid fa-play text-white text-xl"></i>
                    </div>
                    <div class="absolute top-0 left-0 w-full h-full bg-gray-800/50 z-[1]"></div>
                </div>
                <div class="flex justify-between items-center gap-2 py-4">
                    <span class="text-bold text-2xl text-green-500">50$</span>
                    <div class="text-gray-600 dark:text-gray-100 text-sm">
                        <span class="line-through">100$</span>
                        <span>50% off</span>
                    </div>
                </div>
                <div class="text-sm text-amber-700 flex justify-between items-center gap-2">
                    <a href="#"
                        class="whitespace-nowrap w-full transition duration-300 px-4 py-2 border border-amber-700 rounded-full   hover:bg-amber-700 hover:text-white">
                        <i class="fa-regular fa-heart mr-1"></i>
                        <span>Add To Wishlist</span>
                    </a>
                    <div data-popover-target="share-course-tooltipe" data-modal-target="course-modal"
                        data-modal-toggle="course-modal"
                        class="cursor-pointer whitespace-nowrap w-full transition duration-300 px-4 py-2 border border-amber-700 rounded-full   hover:bg-amber-700 hover:text-white">
                        <i class="fa-regular fa-share-from-square"></i>
                        <span>Share</span>
                    </div>

                    <div data-popover id="share-course-tooltipe" role="tooltip"
                        class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white dark:bg-gray-700 border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                        <div class="px-3 py-2 text-center">
                            <p>Want Share This Course?!</p>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                </div>
                <div class="mt-2">
                    <a href="#"
                        class="block rounded-full py-2 px-4 bg-green-500 text-sm text-center font-bold text-white hover:bg-green-700 transition duration-300">Enroll
                        Now</a>
                </div>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200">
                <h3 class="font-bold text-xl pb-2">Includes</h3>
                <div class="flex flex-col gap-2 text-sm text-gray-600 dark:text-gray-100">
                    <div class="p-2 border-b border-gray-200 last-of-type:border-none">
                        <i class="fa-solid fa-users text-amber-700 mr-2"></i>
                        <span>
                            <span>Enrolled:</span>
                            <span class="font-bold"> 32 students</span>
                        </span>
                    </div>
                    <div class="p-2 border-b border-gray-200 last-of-type:border-none">
                        <i class="fa-solid fa-hourglass-half text-amber-700 mr-2"></i>
                        <span>
                            <span>Duration:</span>
                            <span class="font-bold"> 20 hours</span>
                        </span>
                    </div>
                    <div class="p-2 border-b border-gray-200 last-of-type:border-none">
                        <i class="fa-solid fa-layer-group text-amber-700 mr-2"></i>
                        <span>
                            <span>Level:</span>
                            <span class="font-bold"> Beginner</span>
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

    {{-- modals --}}
    <!-- video-preview modal -->
    <div id="video-preview" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 dark:text-white">
                        Trailer Course
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-100 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="video-preview">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">

                    <video class="w-full rounded-xl" controls>
                        <source src="https://flowbite.com/docs/videos/flowbite.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="video-preview" type="button"
                        class="w-full text-gray-800 dark:text-gray-200 border border-gray-800  hover:bg-gray-800 hover:text-white duration-300 focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Share course modal -->
    <div id="course-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5">
                    <h3 class="text-lg text-gray-500 dark:text-gray-400">
                        Share course
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-100 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white"
                        data-modal-toggle="course-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-4 pb-4 md:px-5 md:pb-5">
                    <label for="course-url"
                        class="text-sm font-medium text-gray-900 dark:text-gray-100 dark:text-white mb-2 block">Share the
                        course link below with your friends:</label>
                    <div class="relative mb-4">
                        <input id="course-url" type="text"
                            class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="https://flowbite.com/docs/components/alerts/" disabled readonly>
                        <button data-copy-to-clipboard-target="course-url" data-tooltip-target="tooltip-course-url"
                            class="absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2 inline-flex items-center justify-center">
                            <span id="default-icon-course-url">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 18 20">
                                    <path
                                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                </svg>
                            </span>
                            <span id="success-icon-course-url" class="hidden inline-flex items-center">
                                <svg class="w-3.5 h-3.5 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                </svg>
                            </span>
                        </button>
                        <div id="tooltip-course-url" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            <span id="default-tooltip-message-course-url">Copy to clipboard</span>
                            <span id="success-tooltip-message-course-url" class="hidden">Copied!</span>
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                    <button type="button" data-modal-hide="course-modal"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 dark:text-gray-100 focus:outline-none bg-white dark:bg-gray-700 rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Reviews --}}
    <div id="reviews-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 ">
                        Reviews Students
                    </h3>
                    <button type="button"
                        class=" bg-transparent hover:bg-gray-200 text-gray-400 hover:text-gray-900  dark:text-gray-100 dark:hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 "
                        data-modal-hide="reviews-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4 ">
                    <div div id="accordion-flush" data-accordion="collapse" class="border-b border-gray-100 mb-2 py-2">
                        <div class="flex justify-between items-center gap-2 ">
                            <h4 class="font-bold mb-0">Want Add Your Feedback?!</h4>
                            <button id="add_feedback-heading-1" data-accordion-target="#add_feedback-body-1"
                                aria-expanded="false" aria-controls="add_feedback-body-1"
                                class="inline-block text-sm py-2 px-12 text-amber-700 rounded-full border  border-amber-700 hover:text-white hover:bg-amber-700 duration-300">Add</button>
                        </div>
                        <div id="add_feedback-body-1" class="hidden" aria-labelledby="add_feedback-heading-1">
                            <form class="mt-2">
                                <div class="w-full mb-4 border border-gray-200 dark:bg-gray-600 rounded-lg bg-gray-50 ">
                                    <div class="px-4 py-2 bg-white dark:bg-gray-700 rounded-t-lg ">
                                        <textarea id="comment" rows="4"
                                            class="w-full px-0 text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 border-0 focus:ring-0 "
                                            placeholder="Write Your Feedback..." required></textarea>
                                    </div>
                                    <div class="flex items-center justify-between px-3 py-2 border-t">
                                        <button type="submit"
                                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200  hover:bg-blue-800">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <p class="ms-auto text-xs text-gray-500 dark:text-gray-100">Remember, contributions to this
                                topic should follow our <a href="#" class="text-blue-600  hover:underline">Community
                                    Guidelines</a>.</p>

                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="bg-gray-50 dark:bg-gray-600 border border-gray-100 rounded-xl p-2">
                            <div class="flex justify-between items-center gap-2 border-b border-gray-200 py-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user-1.png') }}" class="w-12 h-12 rounded-full"
                                        alt="user photo">
                                    <div>
                                        <h4 class="font-bold text-xl hover:text-amber-500 duration-300">
                                            <a href="#">Nicole Brown</a>
                                        </h4>
                                        <p class="text-sm ">UX/UI Designer</p>
                                    </div>
                                </div>
                                <div class="text-sm">
                                    <i class="fa-solid fa-star  text-amber-400"></i>
                                    <i class="fa-solid fa-star  text-amber-400"></i>
                                    <i class="fa-solid fa-star  text-amber-400"></i>
                                    <i class="fa-solid fa-star  text-amber-400"></i>
                                    <i class="fa-solid fa-star  text-gray-400"></i>
                                    <span>4.5 Instructor Rating</span>
                                </div>
                            </div>
                            <p class="text-sm whitespace-pre-line py-3">Lorem, ipsum dolor sit amet consectetur
                                adipisicing
                                elit.
                                Molestias, id doloremque laudantium hic a corrupti repellendus itaque aliquid, odio
                                pariatur
                                quaerat ad cumque delectus nisi ipsa, blanditiis officiis quis deserunt?</p>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="reviews-modal" type="button"
                        class="w-full text-gray-800 dark:text-gray-200 border border-gray-800  hover:bg-gray-800 hover:text-white duration-300 focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
@endsection
