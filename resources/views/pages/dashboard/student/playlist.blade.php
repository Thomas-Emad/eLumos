@extends('layouts.app')

@section('title', 'Watch Video')

@section('content')
    <div class="min-h-screen container mx-auto py-4 mt-16 flex flex-col-reverse md:flex-row">
        <div class="w-full md:w-2/3 ">
            <div>
                @if (!is_null($currentLecture->video))
                    <div class="w-full bg-gray-950 p-4 text-white">
                        <iframe class="rounded-xl w-full"
                            src="https://player.cloudinary.com/embed/?public_id={{ json_decode($currentLecture->video)->public_id }}&cloud_name=dtyvom84s&source[poster]={{ json_decode($courseStudent->course->mockup)->url }}&player[autoplay]=true&player[autoplayMode]=on-scroll&player[showJumpControls]=true&player[pictureInPictureToggle]=true&player[logoOnclickUrl]={{ route('dashboard.profile', $courseStudent->course->user->id) }}&player[logoImageUrl]={{ asset('storage/' . $courseStudent->course->user->photo) }}&player[aiHighlightsGraph]=true&source[info][title]={{ $currentLecture->title }}&source[info][subtitle]={{ \Str::limit($courseStudent->course->title, 20) }}"
                            height="360" allow="autoplay; fullscreen; encrypted-media; picture-in-picture" undefined
                            allowfullscreen frameborder="0"></iframe>
                    </div>
                @endif
                <hr class="mt-2 h-.5 block bg-gray-200">
                <div class="p-4">
                    <div class="flex justify-between items-center gap-2 ">
                        <div>
                            <h1 class="font-bold text-2xl m-0">{{ $currentLecture->title }}</h1>
                            <span class="text-sm">{{ $courseStudent->course->title }}</span>
                        </div>
                        @if (!is_null($nextLecture))
                            <a href="{{ route('dashboard.student.show', ['course' => $courseStudent->course_id, 'lecture' => $nextLecture->id]) }}"
                                class="rounded-lg py-2 px-4 text-white bg-amber-500 hover:bg-amber-600 duration-200">
                                Next Lecture
                            </a>
                        @endif
                    </div>
                    @if (!is_null($currentLecture->content))
                        <hr class="mb-2 h-.5 block bg-gray-200">
                        <div>
                            <h2 class="font-bold text-lg">
                                Content This Lecture
                            </h2>
                            <div class="text-gray-900 whitespace-pre-wrap break-words">
                                {{ $currentLecture->content }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if (!is_null($currentLecture->exam))
                <hr class="mt-2 h-.5 block bg-gray-200">
                <div class="p-4 flex justify-between items-center flex-col md:flex-row gap-4">
                    <img src="{{ asset('assets/images/icons/exam.png') }}" class="w-[200px]" alt="icon exam">
                    <div class="flex flex-col gap-4 items-center">
                        <p class='text-gray-800 text-center'>
                            @php
                                $examStuden = $currentLecture->examStudent->last();
                            @endphp
                            @if (is_null($examStuden) || $examStuden?->status == 'processing')
                                <span> It seems that there is an exam for this lesson</span>
                                <br>
                                <span class="text-xs"><b>Note: </b>You will not get the certificate without solving all the
                                    exams</span>
                            @elseif(!is_null($examStuden) && $examStuden?->status == 'sucess')
                                <span> <b>Congratulations</b>, you have successfully passed this exam, you can move
                                    on.</span>
                            @elseif(!is_null($examStuden) && $examStuden?->status == 'failed')
                                <b>You failed the exam,</b> <br> <span> But don't worry, you can try again anytime you
                                    want..</span>
                            @elseif(!is_null($examStuden) && $examStuden?->status == 'waiting')
                                <span> <b>Wait a minute, </b>, it seems that this exam contains questions that cannot be
                                    corrected automatically, so wait a little, you can proceed for now.</span>
                            @endif
                        </p>
                        <div class="flex gap-2 items-center">

                            @if (!is_null($examStuden) && $examStuden?->status !== 'processing')
                                <a href=""
                                    class="text-sm cursor-pointer py-2 px-4 font-bold text-white bg-amber-700 hover:bg-amber-900 duration-300 rounded-md">
                                    See Report
                                </a>
                            @endif

                            @if (is_null($examStuden) || in_array($examStuden?->status, ['processing', 'sucess', 'failed']))
                                <form action="{{ route('dashboard.student.exams.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type"
                                        value="{{ is_null($examStuden) ? 'join' : 'retest' }}">
                                    <input type="hidden" name="exam_id" value="{{ $currentLecture->exam->exam_id }}">
                                    <input type="hidden" name='lecture_id' value="{{ $currentLecture->id }}">
                                    <button type="submit"
                                        class="text-sm cursor-pointer py-2 px-4 font-bold text-white bg-green-700 hover:bg-green-900 duration-300 rounded-md">
                                        Open Exam
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="w-full md:w-1/3 relative mb-2 md:mb-0 ">
            <div class="sticky top-0 right-0 w-full bg-gray-900 text-white p-4 ">
                <div class="flex justify-between items-center gap-2">
                    <span></span>
                    <h1 class="text-2xl font-bold border-b-2 border-gray-200/20 pb-2 text-center">Your Playlist</h1>

                    <span data-modal-toggle='rating-modal' data-modal-target="rating-modal"
                        class="py-1 px-2 rounded-xl border-2 border-amber-500 hover:bg-amber-500 duration-200 cursor-pointer">
                        <i class="text-sm fa-solid fa-star text-white"></i>
                    </span>
                </div>
                <div class="overflow-y-auto md:h-96">
                    @php
                        $firstLectureOpen = true;
                        $allowForOneTimeAfterWatched = true;
                    @endphp
                    @foreach ($courseStudent->course->sections as $section)
                        <div class="p-2 border-b-2 border-white">
                            <h3 class="font-bold text-md mb-1">{{ $section->title }}</h3>
                            @foreach ($section->lectures as $lecture)
                                <a href='@if ($currentLecture->id !== $lecture->id) {{ route('dashboard.student.show', ['course' => $courseStudent->course_id, 'lecture' => $lecture->id]) }} @else # @endif'
                                    class="mb-1 flex gap-2 justify-between items-center p-2 hover:bg-gray-800 duration-200 cursor-pointer rounded-lg @if ($currentLecture->id === $lecture->id) bg-amber-700 @elseif(!is_null($lecture->watchedLecture)) bg-green-700 @else bg-gray-950 @endif">
                                    <div>
                                        <h4 class="font-bold text-sm">{{ $lecture->title }}</h4>
                                    </div>
                                    <div class='flex gap-2 items-center text-sm text-gray-100 dark:text-amber-500'>
                                        {!! getLectureIcons(
                                            text: !is_null($lecture->content),
                                            video: !is_null($lecture->video),
                                            exam: !is_null($lecture->exam),
                                        ) !!}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

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
            <div class="p-4 md:p-5 text-gray-700">
                <!-- Rating -->
                <h4 class="font-bold text-lg">Course Ratings by previous students:</h4>
                <div class="box flex flex-col gap-1 w-full text-sm rates"></div>
                <hr class="mt-2 h-.5 block bg-gray-200">
                <h4 class="font-bold text-lg">What is your Rating of this course?:</h4>
                <div>
                    <div class="flex gap-2 justify-between flex-col md:flex-row">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="w-full">
                                <input type="hidden" name="course_id" value="{{ $courseStudent->course->id }}">
                                <input type="radio" name="rate" id="rating-{{ $i }}-option"
                                    value="{{ $i }}" class="hidden peer" @checked($reviewStudent?->rate == $i || (is_null($reviewStudent) && $i == 1))>

                                <label for="rating-{{ $i }}-option"
                                    class="inline-flex flex-col items-center justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer  peer-checked:bg-amber-600 peer-checked:text-white  hover:bg-gray-50 ">
                                    <div class=" font-semibold">{{ $i }}</div>
                                    <i class="fa-regular fa-star "></i>
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
                <button type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Save
                </button>
                <button data-modal-hide="rating-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-whit rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </form>
    </x-modal>
@endsection

@section('js')
    <script>
        function markupLecture(timeout) {
            setTimeout(() => {
                $.ajax({
                    method: 'POST',
                    url: "{{ route('dashboard.student.lecture.watch') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        course_id: '{{ $currentLecture->course_id }}',
                        lecture_id: '{{ $currentLecture->id }}',
                    },
                }).always(function(response) {
                    console.log(response)
                })
            }, timeout * 1000);
        }

        // Display Rates Course
        $("[data-modal-toggle='rating-modal']").on('click', () => {
            $('#loader').removeClass('hidden');
            if ($(".rates").is(':empty')) {
                $.ajax({
                        method: 'POST',
                        url: "{{ route('dashboard.reviews.get-statistics') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            course_id: '{{ $currentLecture->course_id }}',
                        },
                    }).done((response) => {
                        let contentRatesArray = [];
                        Object.values(response).map((element) => {
                            contentRatesArray.push(`
                            <div class="flex items-center">
                                <p class="font-medium text-black mr-0.5">${element.rate}</p>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_12042_8589)">
                                        <path
                                            d="M9.10326 2.31699C9.47008 1.57374 10.5299 1.57374 10.8967 2.31699L12.7063 5.98347C12.8519 6.27862 13.1335 6.48319 13.4592 6.53051L17.5054 7.11846C18.3256 7.23765 18.6531 8.24562 18.0596 8.82416L15.1318 11.6781C14.8961 11.9079 14.7885 12.2389 14.8442 12.5632L15.5353 16.5931C15.6754 17.41 14.818 18.033 14.0844 17.6473L10.4653 15.7446C10.174 15.5915 9.82598 15.5915 9.53466 15.7446L5.91562 17.6473C5.18199 18.033 4.32456 17.41 4.46467 16.5931L5.15585 12.5632C5.21148 12.2389 5.10393 11.9079 4.86825 11.6781L1.94038 8.82416C1.34687 8.24562 1.67438 7.23765 2.4946 7.11846L6.54081 6.53051C6.86652 6.48319 7.14808 6.27862 7.29374 5.98347L9.10326 2.31699Z"
                                            fill="#FBBF24" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_12042_8589">
                                            <rect width="20" height="20" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <p class="h-2 w-full xl:min-w-[278px] rounded-3xl bg-amber-50 ml-5 mr-3">
                                    <span style='width:${element.progress}%;' class="h-full rounded-3xl bg-amber-400 flex"></span>
                                </p>
                                <p class="font-medium  py-[1px] text-black mr-0.5">${element.count}</p>
                            </div>
                        `);
                        });
                        $(".rates").html(contentRatesArray.join(''));
                    })
                    .always(() => {
                        $('#loader').addClass('hidden');
                    })
            } else {
                $('#loader').addClass('hidden');

            }
        });
    </script>

    @if (is_null($currentLecture->exam))
        <script>
            $(document).ready(function() {
                markupLecture("{{ $setTimeOutForWatchLecture }}");
            })
        </script>
    @endif
@endsection
