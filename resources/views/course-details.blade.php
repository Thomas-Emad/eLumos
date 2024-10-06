@extends('layouts.app')
@section('title', 'course details')


@section('content')
    <div class="min-h-60 mt-16">
        @if ($course->status != 'active')
            <p class="bg-gray-900/70 text-white py-2 px-4 rounded-xl text-center my-4 mt-24 mx-auto w-96">
                This Course his status is: {{ $course->status }}
            </p>
        @endif
        <x-course-details.head :course="$course"></x-course-details.head>
        <x-course-details.content :course="$course"></x-course-details.content>

        <x-course-details.modals :course="$course"></x-course-details.modals>
    </div>

@endsection

@section('js')
@endsection
