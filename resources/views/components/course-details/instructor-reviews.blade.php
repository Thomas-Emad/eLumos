@props(['course'])

<div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 mt-4">
    <h3 class="font-bold text-xl pb-2">About the instructor</h3>
    <div class="flex justify-between items-center gap-2 border-b border-gray-200 py-4">
        <div class="flex items-center gap-2">
            <img src="{{ Storage::url($course->user->photo) }}"
                onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                class="w-12 h-12 rounded-full" alt="user photo">
            <div>
                <h4 class="font-bold text-xl hover:text-amber-500 duration-300">
                    <a href="{{ route('dashboard.profile', $course->user->id) }}">{{ $course->user->name }}</a>
                </h4>
                <p class="text-sm ">{{ $course->user->headline }}</p>
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
    <div class="flex gap-4 border-b border-gray-200 py-4 font-bold text-gray-700 dark:text-gray-200 text-sm mb-1">
        <div>
            <i class="fa-solid fa-play text-amber-700"></i>
            <span>{{ $course->user->courses->count() }} Courses</span>
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
        {{ $course->user->description }}
    </div>
</div>
<div class="p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 mt-4">
    <h3 class="font-bold text-xl pb-2">Reviews</h3>
    <div class="flex justify-between items-center gap-2 border-b border-gray-200 py-4">
        <div class="flex items-center gap-2">
            <img src="{{ asset('assets/images/user-1.png') }}" class="w-12 h-12 rounded-full" alt="user photo">
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
            odio velit? At quasi ab distinctio, quo pariatur velit nulla quod praesentium eveniet, non
            vitae.
            Ducimus?</q>
    </p>
    <button data-modal-target="reviews-modal" data-modal-toggle="reviews-modal"
        class="w-full mt-2 px-4 py-2 text-sm font-bold text-center text-amber-600 border border-amber-600 hover:text-white hover:bg-amber-600 duration-300 rounded-full">See
        All Reviews</button>
</div>


@section('js')
    <script>
        $(document).ready(() => {
            setTimeout(() => {

            }, timeout);
        })
    </script>
@endsection
