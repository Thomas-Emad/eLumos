@props(['course', 'reviewStudent', 'hasThisCourse'])
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
                    src="https://player.cloudinary.com/embed/?public_id={{ getParameterFromJsonOrNull($course->preview_video, 'public_id') }}&cloud_name=dtyvom84s&player[autoplay]=true&player[autoplayMode]=on-scroll&player[aiHighlightsGraph]=true"
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
                <div class='mb-2'>
                    <x-input-copy id="copy-link-search-course" value="{{ route('course-details', $course->id) }}" />

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
            <div class="p-4 pb-0 md:p-5 space-y-4">
                <div class="reviewsModal relative">
                    <div class="loader-courses flex justify-center items-center absolute w-full h-full bg-white z-10 inset-0 hidden"
                        role="status">
                        <svg aria-hidden="true"
                            class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-400"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <h3 class="font-bold text-xl pb-1 inline-block border-b-2 border-gray-400 mb-2">
                        Reviews
                    </h3>
                    <div class="content h-[250px] overflow-y-auto flex flex-col gap-4 ">Loading...</div>
                    <div class="pagination my-2 flex justify-end"></div>
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
{{-- Modal View Lecturs --}}
<x-modal id="view-lecture">
    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
            Trailer Course
        </h3>
        <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-100 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="view-lecture">
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
        <iframe class="w-full rounded-xl player" src="" height="360"
            allow="autoplay; fullscreen; encrypted-media; picture-in-picture" undefined allowfullscreen
            frameborder="0"></iframe>

    </div>
    <!-- Modal footer -->
    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
        <button data-modal-hide="view-lecture" type="button"
            class="w-full text-gray-800 dark:text-gray-200 border border-gray-800  hover:bg-gray-800 hover:text-white duration-300 focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
            Close
        </button>
    </div>
</x-modal>
@if ($hasThisCourse)
    <x-modal id="rating-modal">
        <form
            action="{{ is_null($reviewStudent) ? route('dashboard.reviews.store') : route('dashboard.reviews.update', $reviewStudent?->id) }}"
            method="POST">
            @csrf
            @if (!is_null($reviewStudent))
                @method('PATCH')
            @endif
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <span>What's Your Rating For This Course?</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="rating-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 text-gray-700">
                <!-- Rating -->
                <h4 class="font-bold text-lg">What is your Rating of this course?:</h4>
                <div>
                    <div class="flex gap-2 justify-between flex-col md:flex-row">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="w-full">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="radio" name="rate" id="rating-{{ $i }}-option"
                                    value="{{ $i }}" class="hidden peer" @checked($reviewStudent?->rate == $i || (is_null($reviewStudent) && $i == 1))>

                                <label for="rating-{{ $i }}-option"
                                    class="inline-flex flex-col items-center justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer  peer-checked:bg-amber-600 peer-checked:text-white  hover:bg-gray-50 ">
                                    <div class=" font-semibold">{{ $i }}</div>
                                    <i class="fa-regular fa-star"></i>
                                </label>
                            </div>
                        @endfor
                    </div>
                    <x-textarea label='You can Leave Your Feedback' name='content'>
                        {{ $reviewStudent?->content }}
                    </x-textarea>
                </div>

                <!-- End Rating -->
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit" data-modal-hide="rating-modal"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Save
                </button>
                <button data-modal-hide="rating-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-whit rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </form>
    </x-modal>
@endif
