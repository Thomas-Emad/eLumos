@extends('layouts.app')

@section('title', 'This Exam is Expired Before')

@section('content')
    <div class="min-h-screen container mx-auto px-4 flex flex-col justify-center items-center gap-4">
        <img class="w-[250px]" src="{{ asset('assets/images/icons/expired.png') }}" alt="icon expried exam">
        <p class="text-gray-700 text-center font-bold">
            Umm, it seems that you are looking for this exam, but I am sorry that it has already ended. <br>
            You can see the result or report..
        </p>
        <a href="{{ route('dashboard.student.exams.report', $session) }}"
            class="text-white font-bold py-2 px-4 rounded-lg bg-green-700 hover:bg-green-900 duration-300 shadow-md">
            Report Exam
        </a>
    </div>
@endsection
