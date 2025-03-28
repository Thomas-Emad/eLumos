<div class="flex items-center justify-between gap-2">
    <h2 class="font-bold text-xl">Curriculum</h2>
    <button type="button"
        class="block text-sm font-bold px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 duration-300 rounded-xl"
        data-modal-target="add-section-modal" data-modal-toggle="add-section-modal">
        Add Section
    </button>
</div>
<div class="mt-2 sections">
    <!-- Sections sit here -->
    <p class="text-gray-500 text-center italic">Hmm, it looks like there are no sections. Add one!</p>
</div>


<div>

    <x-modal id="add-section-modal">
        <form id='add-section'>
            <!-- Modal header -->
            <div class="flex  items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <span>Do you want to add a new section?!</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="add-section-modal">
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
                <p class=" text-sm text-gray-500 dark:text-gray-100 ">What is the name of this new section?!..</p>
                <input type="text" name="title"
                    class="bg-gray-50 border border-gray-300 text-gray-900 dark:text-gray-50 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"
                    placeholder="Title of this section.." required />
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="add-section-modal" type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Add
                </button>
                <button data-modal-hide="add-section-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white  rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </form>
    </x-modal>
    <x-modal id="edit-section-modal">
        <form id="edit-section">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <span>Edit in This Section</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="edit-section-modal">
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
                <p class="text-sm text-gray-500 dark:text-gray-100 ">Do you want to change the name of this section?!..
                </p>
                <input type="text" name="title"
                    class="bg-gray-50 border border-gray-300 text-gray-900 dark:text-gray-50 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"
                    placeholder="Title of this section.." required />
                <input type="hidden" name="id">
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="edit-section-modal" type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Save Changes
                </button>
                <button data-modal-hide="edit-section-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-whit rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </form>
    </x-modal>
    <x-modal-info id="delete-section-modal">
        <form id="delete-section">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-100 ">
                Are you sure you want to delete this Lecture?
            </h3>
            <input type="hidden" name="id">
            <button data-modal-hide="delete-section-modal" type="submit"
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Yes, I'm sure
            </button>
            <button data-modal-hide="delete-section-modal" type="button"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                cancel</button>
        </form>
    </x-modal-info>
    <x-modal id="add-lecture-modal">
        <form id="add-lecture" enctype="multipart/form-data">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <i class="fa-solid fa-laptop-file mr-2"></i>
                    <span>Do you want to add a new lecture?!</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="add-lecture-modal">
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
                <x-input type="text" name='title' label="Title lecture" placeholder="Title of this lecture.."
                    value='' required />
                <input type="hidden" name="id">
                <hr>
                <div>
                    <div id="lecture" data-tabs-toggle="#lecture-content" role="tablist">
                        <button class="inline-block py-2 px-4  rounded-xl bg-gray-100" id="video-tab"
                            data-tabs-target="#video" type="button" role="tab" aria-controls="video"
                            aria-selected="false">Video</button>
                        <button class="inline-block py-2 px-4 rounded-xl border border-gray-50 hover:bg-gray-50"
                            id="text-tab" data-tabs-target="#text" type="button" role="tab"
                            aria-controls="text" aria-selected="false">Text</button>
                        <button class="inline-block py-2 px-4 rounded-xl border border-gray-50 hover:bg-gray-50"
                            id="exam-tab" data-tabs-target="#exam" type="button" role="tab"
                            aria-controls="exam" aria-selected="false">exam</button>
                    </div>
                    <div id="lecture-content" class="mt-2">
                        <div class="hidden " id="video" role="tabpanel" aria-labelledby="video-tab">
                            <div class="flex items-center justify-center w-full my-2">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-100 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-100 "><span
                                                class="font-semibold">Click to
                                                upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-100 ">Video (MAX.
                                            40MB)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" name="video" accept="video/mp4"
                                        class="hidden" />
                                </label>
                            </div>
                        </div>
                        <div class="my-2" id="text" role="tabpanel" aria-labelledby="text-tab">

                            <textarea id="message" rows="4" name="content" max='5000'
                                class="block p-2.5 w-full text-sm text-gray-900 dark:text-gray-50 bg-gray-50 rounded-lg border border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="Write your thoughts here..."></textarea>

                        </div>
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="exam" role="tabpanel"
                            aria-labelledby="exam-tab">

                            <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Choose Exam:</h3>
                            <ul class="w-full flex gap-4 flex-col overflow-x-auto pr-2 h-[250px]">
                                <li class="w-full">
                                    <input type="radio" name='exam' id="add-empty-option" value=""
                                        class="hidden peer" checked>
                                    <label for="add-empty-option"
                                        class="flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <p>- Not Need for Exam In this Lecture</p>
                                    </label>
                                </li>
                                @foreach ($exams as $exam)
                                    <li class="w-full">
                                        <input type="radio" name='exam' id="add-{{ $exam->id }}-option"
                                            value="{{ $exam->id }}" class="hidden peer">
                                        <label for="add-{{ $exam->id }}-option"
                                            class="flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <p>* {{ $exam->title }}
                                                <span
                                                    class="text-sm text-gray-400">({{ $exam->questions->count() }})</span>
                                            </p>
                                            <a href="{{ route('dashboard.instructor.exams.show', $exam->id) }}"
                                                target="__blank" class="text-blue-600 hover:underline">Preview</a>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex py-2 items-center border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="add-lecture-modal" type="submit"
                        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        Add
                    </button>
                    <button data-modal-hide="add-lecture-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </div>
        </form>
    </x-modal>
    <x-modal id="edit-lecture-modal">
        <form id="edit-lecture" enctype="multipart/form-data">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <i class="fa-solid fa-laptop-file mr-2"></i>
                    <span>How You need To edit in This lecture?!</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="edit-lecture-modal">
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
                <x-input type="text" name='title' label="Title lecture" placeholder="Title of this lecture.."
                    value='' required />
                <input type="hidden" name="id">
                <hr>
                <div>
                    <div data-tabs-toggle="#edit-lecture-content" role="tablist">
                        <button class="inline-block py-2 px-4  rounded-xl bg-gray-100" id="edit-video-tab"
                            data-tabs-target="#edit-video" type="button" role="tab" aria-controls="edit-video"
                            aria-selected="false">Video</button>
                        <button class="inline-block py-2 px-4 rounded-xl border border-gray-50 hover:bg-gray-50"
                            id="text-tab" data-tabs-target="#edit-text" type="button" role="tab"
                            aria-controls="edit-text" aria-selected="false">Text</button>
                        <button class="inline-block py-2 px-4 rounded-xl border border-gray-50 hover:bg-gray-50"
                            id="exam-tab" data-tabs-target="#edit-exam" type="button" role="tab"
                            aria-controls="edit-exam" aria-selected="false">exam</button>
                    </div>
                    <div id="edit-lecture-content" class="mt-2">
                        <div class="hidden " id="edit-video" role="tabpanel" aria-labelledby="video-tab">
                            <div class="flex items-center justify-center w-full my-2">
                                <label for="change-video"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-100 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-100 "><span
                                                class="font-semibold">Click to
                                                upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-100 ">Video (MAX.
                                            40MB)</p>
                                    </div>
                                    <input id="change-video" type="file" name="video" accept="video/mp4"
                                        class="hidden" />
                                </label>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-100 ">- if you upload new video it will
                                replace the old one</p>
                        </div>
                        <div class="my-2" id="edit-text" role="tabpanel" aria-labelledby="text-tab">

                            <textarea id="message" rows="4" name="content" max='5000'
                                class="block p-2.5 w-full text-sm text-gray-900 dark:text-gray-50 bg-gray-50 rounded-lg border border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="Write your thoughts here..."></textarea>

                        </div>
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="edit-exam" role="tabpanel"
                            aria-labelledby="exam-tab">

                            <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Choose Exam:</h3>
                            <ul class="w-full flex gap-4 flex-col overflow-x-auto pr-2 h-[250px]">
                                <li class="w-full">
                                    <input type="radio" name='exam' id="edit-empty-option" value=""
                                        class="hidden peer" checked>
                                    <label for="edit-empty-option"
                                        class="flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <p>- Not Need for Exam In this Lecture</p>
                                    </label>
                                </li>
                                @foreach ($exams as $exam)
                                    <li class="w-full">
                                        <input type="radio" name='exam' id="edit-{{ $exam->id }}-option"
                                            value="{{ $exam->id }}" class="hidden peer">
                                        <label for="edit-{{ $exam->id }}-option"
                                            class="flex items-center justify-between w-full p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <p>* {{ $exam->title }}
                                                <span
                                                    class="text-sm text-gray-400">({{ $exam->questions->count() }})</span>
                                            </p>
                                            <a href="{{ route('dashboard.instructor.exams.show', $exam->id) }}"
                                                target="__blank" class="text-blue-600 hover:underline">Preview</a>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex py-2 items-center border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="edit-lecture-modal" type="submit"
                        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        Update
                    </button>
                    <button data-modal-hide="edit-lecture-modal" type="button"
                        class="close py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </div>
        </form>
    </x-modal>
    <x-modal-info id="delete-lecture-modal">
        <form id="delete-lecture">
            <input type="hidden" name="id">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-100 ">Are you sure you want
                to delete
                this Lecture?</h3>
            <button data-modal-hide="delete-lecture-modal" type="submit"
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Yes, I'm sure
            </button>
            <button data-modal-hide="delete-lecture-modal" type="button"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                cancel</button>
        </form>
    </x-modal-info>
</div>
