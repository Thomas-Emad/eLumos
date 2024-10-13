@extends('layouts.app')

@section('title', 'Watch Video')

@section('content')
    <div class="min-h-screen container mx-auto py-4 mt-16 flex ">
        <div class="w-2/3">
            @if (!is_null($contentLecture->video))
                <div class="w-full bg-gray-950 p-4 text-white">
                    <iframe class="rounded-xl" allow="autoplay"
                        src="https://player.cloudinary.com/embed/?public_id={{ json_decode($contentLecture->video)->public_id }}&cloud_name=dtyvom84s&player[showLogo]=false&source[poster]={{ json_decode($courseStudent->course->mockup)->url }}"
                        width="100%" height="360" allow="autoplay; fullscreen; encrypted-media; picture-in-picture"
                        undefined allowfullscreen frameborder="0"></iframe>
                </div>
            @endif
            <div class="p-4">
                <hr class="mt-2 h-.5 block bg-gray-200">
                <div class="py-1 flex justify-between items-center gap-2 flex-col md:flex-row">
                    <div>
                        <h1 class="font-bold text-2xl m-0">{{ $contentLecture->title }}</h1>
                        <span class="text-sm">{{ $courseStudent->course->title }}</span>
                    </div>
                    @if (!is_null($nextLecture))
                        <a href="{{ route('dashboard.student.show', ['course' => $courseStudent->course_id, 'lecture' => $nextLecture->id]) }}"
                            class="rounded-lg py-2 px-4 text-white bg-amber-500 hover:bg-amber-600 duration-200">
                            Next Lecture
                        </a>
                    @endif
                </div>
                <hr class="mb-2 h-.5 block bg-gray-200">
                <div>
                    <h2 class="font-bold text-lg">
                        Content This Lecture
                    </h2>
                    <div class="text-gray-900 whitespace-pre-wrap">
                        {{ $contentLecture->content }}
                    </div>
                </div>
            </div>
        </div>
        <div class="w-1/3 relative">
            <div class="sticky top-0 right-0 w-full bg-gray-900 text-white p-4 ">
                <div>
                    <h1 class="text-2xl font-bold border-b-2 border-gray-200/20 pb-2 text-center">Your Playlist</h1>
                </div>
                <div class="overflow-y-auto h-96">
                    @foreach ($courseStudent->course->sections as $section)
                        <div class="p-2 border-b-2 border-white">
                            <h3 class="font-bold text-md mb-1">{{ $section->title }}</h3>
                            @foreach ($section->lectures as $lecture)
                                @php
                                    $isLocked = true;
                                    if (
                                        $contentLecture->id === $lecture->id ||
                                        $contentLecture->order_sort + 1 >= $lecture->order_sort
                                    ) {
                                        $isLocked = false;
                                    }
                                @endphp
                                @if ($isLocked == true)
                                    <button type="button"
                                        class="w-full mb-1 flex gap-2 justify-between p-2 bg-gray-400 opacity-25 hover:bg-gray-800 duration-200 cursor-pointer rounded-lg ">
                                        <h4 class="font-bold text-sm">{{ $lecture->title }}</h4>
                                        <span class="text-sm">{{ $lecture->video_duration }}</span>
                                    </button>
                                @else
                                    <a href='@if ($contentLecture->id !== $lecture->id) {{ route('dashboard.student.show', ['course' => $courseStudent->course_id, 'lecture' => $lecture->id]) }} @else # @endif'
                                        class="mb-1 flex gap-2 justify-between p-2 hover:bg-gray-800 duration-200 cursor-pointer rounded-lg @if ($contentLecture->id === $lecture->id) bg-amber-700 @else bg-gray-950 @endif">
                                        <h4 class="font-bold text-sm">{{ $lecture->title }}</h4>
                                        <span class="text-sm">{{ $lecture->video_duration }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
