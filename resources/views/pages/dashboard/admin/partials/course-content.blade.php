<div class="flex gap-2 flex-col md:flex-row items-center justify-between">
    <div class="w-full md:w-2/3 inline-flex flex-col md:flex-row  gap-2 justify-between">
        <a href="{{ route('course-details', $course->id) }}" target="__blank">
            <img src="{{ json_decode($course->mockup)->url }}" alt="mockup" class="w-full md:w-64 h-44 rounded-lg"
                onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';">
        </a>
        <div class="text-sm text-gray-600 flex flex-col gap-1">
            <a href="{{ route('course-details', $course->id) }}" target="__blank">
                <h1 class="text-xl font-bold hover:text -amber-600 duration-200">{{ $course->title }}</h1>
            </a>
            <p title="{{ $course->headline }}" class="text-sm text-gray-500">
                {{ \Str::limit($course->headline, 100, '...') }}
            </p>
            <p><b>Published At:</b> {{ $course->created_at }}</p>
            <p><b>Lectures:</b> {{ $course->lectures_count }}</p>
            <p><b>Status:</b> <span @class([
                'text-red-600' => in_array($course->status, ['removed', 'rejected']),
                'text-green-600' => $course->status === 'active',
                'text-gray-600' => in_array($course->status, [
                    'draft',
                    'pending',
                    'inactive',
                ]),
            ])>{{ $course->status }}</span></p>
            <p>
                <b>Price:</b>
                <span @class([
                    'text-green-600' => $course->price == 0,
                    'text-amber-600' => $course->price > 0,
                ])>
                    {{ $course->price }}$
                </span>
            </p>

        </div>
    </div>
    <div class="w-full md:w-1/3 inline-flex flex-col gap-2 items-center justify-center">
        <img src="{{ asset('storage/' . $course->user->photo) }}"
            onerror="this.onerror=null;this.src='{{ asset('assets/images/user-1.png') }}';" alt="icon user"
            class="w-16 h-16 rounded-full">
        <p class="text-sm text-gray-600">{{ $course->user->name }}</p>
        <a href="{{ route('dashboard.profile', $course->user_id) }}" target="__blank"
            class="text-sm py-2 px-4 text-white font-bold bg-green-400 hover:bg-green-700 duration-200 rounded-lg shadow-md">
            Profile
        </a>
    </div>
</div>
<hr class="block my-4 w-2/3 mx-auto border border-gray-100">
<div class="bg-gray-100 p-4 rounded-lg">
    <h1 class="text-xl font-bold text-amber-600">Overview</h1>

    <h2 class="text-md font-bold text-gray-600">- Course Description</h2>
    <p class="text-sm text-gray-500">{{ $course->description }}</p>
    <h2 class="text-md font-bold text-gray-600">- What you'll learn</h2>
    <p class="text-sm text-gray-500">{{ $course->learn }}</p>
    <h2 class="text-md font-bold text-gray-600">- Requirements</h2>
    <p class="text-sm text-gray-500">{{ $course->requirements }}</p>
</div>

<hr class="block my-4 w-2/3 mx-auto border border-gray-100">
<div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
    <h1 class="text-xl font-bold text-amber-600">Course Content</h1>
    <a href="{{ route('course-details', $course->id) }}" target="__blank"
        class="inline-block py-2 px-4 bg-green-400 hover:bg-green-700 duration-200 text-white font-bold rounded-lg shadow-md">
        Watch Playlist
    </a>
</div>


<hr class="block my-4 w-2/3 mx-auto border border-gray-100">
<div class="bg-gray-100 p-4 rounded-lg flex flex-col gap-4">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-amber-600">Settings</h1>
        <button type="button"
            class="settings-course inline-block py-2 px-4 bg-green-400 hover:bg-green-700 duration-200 text-white font-bold rounded-lg shadow-md">
            Change Settings
        </button>
    </div>
    <div class="show-settings hidden">
        <form action="{{ route('dashboard.review.log.update') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <h2 class="font-bold text-lg mb-2">Change Status Course</h2>
            <ul class="flex justify-center gap-4 ">
                <li class="w-full md:w-1/2">
                    <input type="radio" id="active-option" name="status" value="active" class="hidden peer"
                        required="">
                    <label for="active-option"
                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-green-50">
                        <div class="block">
                            <img class="w-12 h-12" src="{{ asset('assets/images/icons/active.png') }}"
                                alt="icon student">
                            <div class="w-full text-lg font-semibold">Accept</div>
                        </div>
                    </label>
                </li>
                <li class="w-full md:w-1/2">
                    <input type="radio" id="rejected-option" name="status" value="rejected" class="hidden peer">
                    <label for="rejected-option"
                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-red-50">
                        <div class="block">
                            <img class="w-12 h-12" src="{{ asset('assets/images/icons/rejected.png') }}"
                                alt="icon student">
                            <div class="w-full text-lg font-semibold">Reject</div>
                        </div>
                    </label>
                </li>
                @if ($course->status !== 'pending')
                    @if ($course->status == 'active')
                        <li class="w-full md:w-1/2">
                            <input type="radio" id="inactive-option" name="status" value="inactive"
                                class="hidden peer">
                            <label for="inactive-option"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-red-50">
                                <div class="block">
                                    <img class="w-12 h-12" src="{{ asset('assets/images/icons/inactive.png') }}"
                                        alt="icon student">
                                    <div class="w-full text-lg font-semibold">InActive</div>
                                </div>
                            </label>
                        </li>
                    @endif
                    <li class="w-full md:w-1/2">
                        <input type="radio" id="removed-option" name="status" value="removed" class="hidden peer">
                        <label for="removed-option"
                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-red-50">
                            <div class="block">
                                <img class="w-12 h-12" src="{{ asset('assets/images/icons/removed.png') }}"
                                    alt="icon student">
                                <div class="w-full text-lg font-semibold">Remove</div>
                            </div>
                        </label>
                    </li>
                    <li class="w-full md:w-1/2">
                        <input type="radio" id="blocked-option" name="status" value="blocked"
                            class="hidden peer">
                        <label for="blocked-option"
                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-red-50">
                            <div class="block">
                                <img class="w-12 h-12" src="{{ asset('assets/images/icons/blocked.png') }}"
                                    alt="icon student">
                                <div class="w-full text-lg font-semibold">Blocked</div>
                            </div>
                        </label>
                    </li>
                @endif
            </ul>

            <div class="submit hidden">
                <x-textarea name="reason" label="Reason" placeholder="Reason" required />
                <button type="submit"
                    class="mt-2 bg-green-400 hover:bg-green-700 duration-200 text-white font-bold rounded-lg shadow-md py-2 px-4">
                    <span>Submit</span>
                </button>
            </div>
        </form>
    </div>
</div>

<hr class="block my-4 w-2/3 mx-auto border border-gray-100">
<div class="bg-gray-100 p-4 rounded-lg flex flex-col gap-4">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-amber-600">Course Review Logs</h1>
        <button type="button"
            class="logs-course inline-block py-2 px-4 bg-green-400 hover:bg-green-700 duration-200 text-white font-bold rounded-lg shadow-md">
            See More
        </button>
    </div>
    <div class="see-logs hidden">
        <div class="content"></div>
        <x-loader classCall='loader-log' />
    </div>
</div>

<script>
    $('.settings-course').on('click', function() {
        $(".show-settings").toggleClass('hidden');
    });
    $("input[name=status]").on('change', function() {
        if ($(this).val() != null) {
            $(".submit").removeClass('hidden');
        }
    });

    /* Get logs Changes on this Course */
    $('.logs-course').on('click', function() {
        $('.loader-log').removeClass('hidden');
        $(".see-logs").toggleClass('hidden');
        $.ajax({
            url: "{{ route('dashboard.review.log.show') }}",
            type: "GET",
            data: {
                course_id: "{{ $course->id }}"
            },
            success: function(response) {
                $(".see-logs .content").html(response.content);
                $('.loader-log').addClass('hidden');

            }
        });
    });
</script>
