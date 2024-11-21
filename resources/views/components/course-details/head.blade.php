@props(['course', 'averageRating'])
{{-- Head Course --}}
<div class=" bg-center bg-cover bg-no-repear relative "
    style="background-image:url('{{ asset('assets/images/education.png') }}')">
    <div class="absolute top-0 left-0 w-full h-full z-[1] bg-[#22222299] "></div>
    <div class="container mx-auto max-w-screen-xl px-4 py-12 relative z-[2]">
        <div class="text-white w-full md:w-[65%]">
            <div class="flex justify-between gap-4 items-center flex-col-reverse md:flex-row">
                <div class="flex gap-4 items-center w-full">
                    <img src="{{ asset('storage/' . $course->user->photo) }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/user-1.png') }}';" alt="user photo"
                        class="rounded-full w-12 h-12">
                    <div>
                        <a href="{{ route('dashboard.profile', $course->user->id) }}"
                            class="block transition duration-300 hover:text-amber-600 font-bold">
                            {{ $course->user->name }}
                        </a>
                        <p>{{ $course->user->headline }}</p>
                    </div>
                </div>
                <div class="flex flex-row  md:flex-col items-center gap-2 ">
                    <div title="{{ $course->category->name }}"
                        class="inline-block py-2 px-3 text-white text-xs font-bold bg-amber-600 rounded-full mt-1 uppercase whitespace-nowrap">
                        {{ Str::limit($course->category->name, 30) }}
                    </div>
                    <div class="flex gap-1 text-sm">
                        @for ($i = 1; $i <= floor($averageRating); $i++)
                            <i class="fa-solid fa-star text-amber-500"></i>
                        @endfor

                        @if ($averageRating - floor($averageRating) >= 0.5)
                            <i class="fa-solid fa-star-half-stroke text-amber-500"></i>
                        @endif

                        @for ($i = 1; $i <= 5 - ceil($averageRating); $i++)
                            <i class="fa-solid fa-star text-white"></i>
                        @endfor

                        <div class="text-sm"><span class="text-gray-200">{{ $averageRating }}</span>
                            <span>({{ $course->reviews->count() }})</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="mt-4">
                <h1 class="font-bold text-2xl">{{ $course->name }}</h1>
                <p class="text-sm break-words">{{ $course->headline }}</p>
            </div>
            <div class="mt-4 flex gap-4 text-sm">
                <div class="flex gap-2 items-center">
                    <img src="{{ asset('assets/images/icons/lesson.png') }}" alt="icon lesson count" class="w-5 h-5">
                    <span>{{ $course->totalLectures }}+ Lesson</span>
                </div>
                <div class="flex gap-2 items-center">
                    <img src="{{ asset('assets/images/icons/time.png') }}" alt="icon time count" class="w-5 h-5">
                    <span>{{ explainSecondsToHumans($course->totalLecturesTime) }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <img src="{{ asset('assets/images/icons/students.png') }}" alt="icon students count"
                        class="w-5 h-5">
                    <span>{{ $course->enrolleds->count() }} students enrolled</span>
                </div>
            </div>
        </div>
    </div>
</div>
