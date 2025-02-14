<x-mail::message>
    <h1>Hello {{ $user->name }}, We are Miss you too. </h1>
    <p>There is more time we does not we you, So we Want Remember your to Countine Your Courses</p>

    <div>
        @foreach ($user->enrolled as $item)
            <div class=" flex flex-col md:flex-row justify-between items-center gap-4 p-4 bg-gray-100 rounded-sm">
                <img src="{{ getParameterFromJsonOrNull($item->course->mockup, 'url') }}"
                    onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';" alt="photo course"
                    class="w-full md:w-56 h-40 rounded-xl shadow">
                <div class="w-full md:w-1/3 mt-4 md:mt-0">
                    <div>
                        <h3 class="text-xl mb-2">{{ $item->course->title }}</h3>
                        <p class="text-gray-600 text-sm  break-words ">
                            {{ str($item->course->headline)->limit(30) }}</p>
                    </div>

                    <div class="w-full bg-gray-100 rounded-md overflow-hidden p-1 relative">
                        <span class="block w-[{{ $item->progress_lectures }}%] bg-blue-600 absolute inset-0 z-10"></span>
                    </div>
                    <span class="text-xs text-right block">{{ $item->progress_lectures }}%</span>
                </div>
            </div>
        @endforeach
    </div>

    <x-mail::button :url="{{ route('dashboard.index') }}">
        Back To Home
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
