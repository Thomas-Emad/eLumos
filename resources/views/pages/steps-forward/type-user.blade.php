<form action="{{ route('steps-forward.save') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="step" value="type-user">

    <ul class="flex justify-center gap-4 ">
        <li class="w-full md:w-1/2">
            <input type="radio" id="instructor-option" name="type-user" value="instructor" class="hidden peer"
                required="">
            <label for="instructor-option"
                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                <div class="block">
                    <img class="w-12 h-12" src="{{ asset('assets/images/icons/instructor.png') }}" alt="icon student">

                    <div class="w-full text-lg font-semibold">Instructor</div>
                    <div class="w-full text-sm">This is a great opportunity to spread your knowledge and make money
                        selling your courses..</div>
                </div>
            </label>
        </li>
        <li class="w-full md:w-1/2">
            <input type="radio" id="student-option" name="type-user" value="student" class="hidden peer">
            <label for="student-option"
                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                <div class="block">
                    <img class="w-12 h-12" src="{{ asset('assets/images/icons/students.png') }}" alt="icon student">
                    <div class="w-full text-lg font-semibold">Student</div>
                    <div class="w-full text-sm">
                        What are you waiting for to achieve knowledge, here is the right way..
                    </div>
                </div>
            </label>
        </li>
    </ul>



    <button type="submit" class="mt-4 w-full rounded-full p-2 text-white bg-amber-500 hover:bg-amber-700 transition">
        Next
    </button>
</form>
