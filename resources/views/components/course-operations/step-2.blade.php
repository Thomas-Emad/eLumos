<form action='{{ route('dashboard.instructor.courses.update', ['course' => $course->id]) }}' method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <h2 class="font-bold text-xl mb-1">- Course background</h2>
    <div class="flex items-center justify-center w-full">
        <label for="bg-course"
            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-100 " aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-100 ">
                    <span class="font-semibold">
                        Click to upload (Background)
                    </span>
                    or drag and drop
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-100 ">PNG or JPG (MAX.
                    800x400px, 2MB)
                </p>
            </div>
            <input id="bg-course" type="file" name="mockup" accept="image/png, image/jpeg" class='hidden' />
        </label>
    </div>
    @error('mockup')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
    <input type="hidden" name="step" value="{{ request()->input('step') }}">
    <hr class="my-2">

    <h2 class="font-bold text-xl mb-1">- Video presentation</h2>
    <div class="flex items-center justify-center w-full">
        <label for="video-course"
            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-100 " aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-100 "><span class="font-semibold">Click
                        to upload (Video presentation)</span> or drag and drop</p>
                <p class="text-xs text-gray-500 dark:text-gray-100 ">Video (MAX.
                    800x400px, 10MB)
                </p>
            </div>
            <input id="video-course" type="file" name="video-persentation" class="hidden"
                accept="video/mp4, video/webm" />
        </label>
    </div>
    @error('video-persentation')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
    <button type="submit"
        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
        Changes</button>
</form>
