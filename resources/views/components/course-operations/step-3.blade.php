<form action="{{ route('dashboard.instructor.courses.update', ['course' => $course->id]) }}" method="POST">
    @csrf
    @method('PATCH')

    <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Choose Level Course Target:</h3>
    <ul class="grid w-full gap-6 md:grid-cols-3">
        <li>
            <input type="radio" id="beginner-option" name='level' value="beginner" class="hidden peer" required=""
                @checked(old('level', $course->level ?? '') == 'beginner')>
            <label for="beginner-option"
                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                <div class="flex gap-4 items-center">
                    <img src="{{ asset('assets/images/icons/beginner-student.png') }}" alt="beginner student"
                        class="w-14">
                    <div>
                        <div class="w-full text-lg font-semibold">Beginner</div>
                        <div class="w-full text-sm">Beginner level or who has no knowledge of this
                            specialty.
                        </div>
                    </div>
                </div>
            </label>
        </li>
        <li>
            <input type="radio" id="intermediate-option" name='level' value="intermediate" class="hidden peer"
                @checked(old('level', $course->level ?? '') == 'intermediate')>
            <label for="intermediate-option"
                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                <div class="flex gap-4 items-center">
                    <img src="{{ asset('assets/images/icons/intermediate-student.png') }}" alt="Intermediate student"
                        class="w-14">
                    <div>
                        <div class="w-full text-lg font-semibold">Intermediate</div>
                        <div class="w-full text-sm">Post-beginner who aims to improve his knowledge.
                        </div>
                    </div>
                </div>
            </label>
        </li>
        <li>
            <input type="radio" id="advanced-option" name='level' value="advanced" @checked(old('level', $course->level ?? '') == 'advanced')
                class="hidden peer">
            <label for="advanced-option"
                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                <div class="flex gap-4 items-center">
                    <img src="{{ asset('assets/images/icons/advanced-student.png') }}" alt="Advanced student"
                        class="w-14">
                    <div>
                        <div class="w-full text-lg font-semibold">Advanced</div>
                        <div class="w-full text-sm">Professionals and great presenters, we can say whales..
                        </div>
                    </div>
                </div>
            </label>
        </li>
    </ul>
    <hr class="my-4">
    <div class="mb-2">
        <input type="hidden" name="step" value="{{ request()->input('step') }}">
        <p class="text-sm text-gray-500 dark:text-gray-100 ">Let's find out what people learn from this
            course?!..</p>

        <x-textarea name='learn'
            label='What do the students learn?'>{{ old('learn', $course->learn ?? '') }}</x-textarea>
    </div>
    <div class="mb-1">
        <p class="text-sm text-gray-500 dark:text-gray-100 ">Are there any requirements to attend this
            course?!..</p>
        <x-textarea name='requirements'
            label='What are the requirements?!..'>{{ old('requirements', $course->requirements ?? '') }}</x-textarea>
    </div>
    <button type="submit"
        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
        Changes</button>
</form>
