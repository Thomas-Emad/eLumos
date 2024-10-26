@extends('layouts.app')

@section('title', 'This Exam is..')

@section('content')
    <div class="min-h-screen container mx-auto px-4 flex flex-col justify-center items-center gap-4">
        @if ($session->status === 'processing')
            <img class="w-[250px]" src="{{ asset('assets/images/icons/open.png') }}" alt="icon done exam">
            <p class="text-gray-700 text-center font-bold  w-full md:w-2/3">
                Umm, for some reason it seems that this exam is still open and waiting for you, <br>
                now go and finish it quickly before it disappears..
            </p>
            <a href="{{ route('dashboard.student.exams.test', $session->id) }}"
                class="text-white font-bold py-2 px-4 rounded-lg bg-green-700 hover:bg-green-900 duration-300 shadow-md">
                Open Exam
            </a>
        @elseif ($session->status === 'sucess')
            <img class="w-[250px]" src="{{ asset('assets/images/icons/done.png') }}" alt="icon done exam">
            <p class="text-gray-700 text-center font-bold  w-full md:w-2/3">
                <b>Congratulations</b> you've done it all, keep going! <br>
                You can see the result or report..
            </p>
            <a href="{{ route('dashboard.student.exams.report', $session->id) }}"
                class="text-white font-bold py-2 px-4 rounded-lg bg-green-700 hover:bg-green-900 duration-300 shadow-md">
                Report Exam
            </a>
        @elseif ($session->status === 'waiting')
            <img class="w-[250px]" src="{{ asset('assets/images/icons/wait.png') }}" alt="icon wait exam">
            <p class="text-gray-700 text-center font-bold w-full md:w-2/3">
                <span>
                    It seems that this exam included essay questions or some kind of file, which we could not correct
                    ourselves,
                    it must be reviewed by the publisher.
                </span>
                <br>
                <span class="mt-2"> I do not like waiting either, so you can look at the preliminary report</span>
            </p>
            <a href="{{ route('dashboard.student.exams.report', $session->id) }}"
                class="text-white font-bold py-2 px-4 rounded-lg bg-green-700 hover:bg-green-900 duration-300 shadow-md">
                Report Exam
            </a>
        @elseif ($session->status === 'failed')
            <img class="w-[250px]" src="{{ asset('assets/images/icons/exam-failed.png') }}" alt="icon failed exam">
            <p class="text-gray-700 text-center font-bold  w-full md:w-2/3">
                Don't worry, you did everything you could, maybe it wasn't enough but your experiences don't worry, go and
                look at the report and retake the previous lectures, <br>
                and I am sure that you will be able to pass this test next time
            </p>
            <a href="{{ route('dashboard.student.exams.report', $session->id) }}"
                class="text-white font-bold py-2 px-4 rounded-lg bg-green-700 hover:bg-green-900 duration-300 shadow-md">
                Report Exam
            </a>
        @endif
    </div>
@endsection
