@extends('layouts.app')

@section('title', 'Watch Video')

@section('content')
    <div class="min-h-screen container mx-auto py-4 mt-16 flex flex-col-reverse md:flex-row">
        <div class="w-full md:w-2/3 ">
            <div>
                @if (!is_null($currentLecture->video))
                    <div class="w-full bg-gray-950 p-4 text-white">
                        <iframe class="rounded-xl" allow="autoplay"
                            src="https://player.cloudinary.com/embed/?public_id={{ json_decode($currentLecture->video)->public_id }}&cloud_name=dtyvom84s&player[showLogo]=false&source[poster]={{ json_decode($courseStudent->course->mockup)->url }}"
                            width="100%" height="360" allow="autoplay; fullscreen; encrypted-media; picture-in-picture"
                            undefined allowfullscreen frameborder="0"></iframe>
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
                            <div class="text-gray-900 whitespace-pre-wrap">
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
                <div>
                    <h1 class="text-2xl font-bold border-b-2 border-gray-200/20 pb-2 text-center">Your Playlist</h1>
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
    </script>

    @if (is_null($currentLecture->exam))
        <script>
            $(document).ready(function() {
                markupLecture("{{ $setTimeOutForWatchLecture }}");
            })
        </script>
    @endif
@endsection
