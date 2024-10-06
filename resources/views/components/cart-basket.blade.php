@props(['course'])
<div class="flex flex-col md:flex-row justify-between gap-4 bg-white p-4 rounded-xl w-full shadow-sm">
    <div class="flex gap-2">
        <a href="{{ route('course-details', $course->id) }}">
            <img src="{{ !is_null($course->mockup) ? json_decode($course->mockup)->url : asset('assets/images/course.png') }}"
                onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';" alt="Image of course"
                class="w-[140px] h-[90px] rounded-xl border border-gray-200">
        </a>
        <div class="flex flex-col gap-2">
            <a href="{{ route('course-details', $course->id) }}" class="font-bold text-xl">
                {{ $course->title }}
            </a>
            <a href="{{ route('dashboard.profile', $course->user->id) }}" class="text-xs">By
                <span class="underline">{{ $course->user->name }}</span></a>
            <div class="text-xs flex gap-1 items-center">
                <span class="font-bold text-sm text-amber-700">4.6</span>
                <i class="fa-solid fa-star text-amber-600"></i>
                <i class="fa-solid fa-star text-amber-600"></i>
                <i class="fa-solid fa-star text-amber-600"></i>
                <i class="fa-solid fa-star text-amber-600"></i>
                <i class="fa-solid fa-star text-gray-600"></i>
                <span class="font-bold text-gray-700">(160 ratings)</span>
            </div>
            <div class="flex flex-wrap gap-1 items-center text-gray-700 text-xs">
                <span>- {{ round($course->lectures->sum('video_duartion') / 60) }} total Hours</span>
                <span>- {{ $course->lectures->count() }} Lectures</span>
                <span>- {{ $course->level }}</span>
            </div>

            <div class="flex flex-wrap gap-2 items-center text-amber-700 text-xs">
                <form action="{{ route('basket.destory', $course->id) }}" method='POST'>
                    @csrf
                    @method('DELETE')
                    <button type='submit' class="hover:text-amber-600 duration-300">
                        Remove
                    </button>
                </form>
                <form action="{{ route('wishlist.controll', $course->id) }}" method='POST'>
                    @csrf
                    @if (Auth::check() &&
                            $course->wishlist()->where('user_id', auth()->user()->id)->whereNull('deleted_at')->exists())
                        <button type="submit" name="type" value="remove" class="hover:text-amber-600 duration-300">
                            Remove from Wishlist
                        </button>
                    @else
                        <button type="submit" name="type" value="add" class="hover:text-amber-600 duration-300">
                            Add to Wishlist
                        </button>
                    @endif
                </form>
            </div>

        </div>
    </div>
    <div class="text-amber-800 font-bold text-lg">
        <span class="mr-1">{{ $course->price }}$</span>
        <i class="fa-solid fa-square-poll-horizontal"></i>
    </div>
</div>
