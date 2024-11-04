@props(['course'])
{{-- modals --}}
<!-- video-preview modal -->
<div id="video-preview" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
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
                <iframe class="w-full rounded-xl"
                    src="https://player.cloudinary.com/embed/?public_id={{ json_decode($course->preview_video)->public_id }}&cloud_name=dtyvom84s&player[autoplay]=true&player[autoplayMode]=on-scroll&player[aiHighlightsGraph]=true"
                    height="360" allow="autoplay; fullscreen; encrypted-media; picture-in-picture" undefined
                    allowfullscreen frameborder="0"></iframe>

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
        <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow">
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
                <label for="course-url" class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2 block">Share
                    the
                    course link below with your friends:</label>
                <div class="relative mb-4">
                    <input id="course-url" type="text"
                        class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ route('course-details', $course->id) }}" disabled readonly>
                    <button data-copy-to-clipboard-target="course-url" data-tooltip-target="tooltip-course-url"
                        class="absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2 inline-flex items-center justify-center">
                        <span id="default-icon-course-url">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 18 20">
                                <path
                                    d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                            </svg>
                        </span>
                        <span id="success-icon-course-url" class="hidden  items-center">
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
                    class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
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
                        <p class="ms-auto text-xs text-gray-500 dark:text-gray-100">Remember, contributions to
                            this
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
