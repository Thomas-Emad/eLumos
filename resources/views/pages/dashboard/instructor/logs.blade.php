@extends('layouts.dashboard')
@section('title', 'Review Logs')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
        <h2 class="font-bold text-xl mb-2 border-b border-gray-200 pb-2">Last Reviews Log</h2>
        <div>
            @forelse ($logs as $log)
                <div class="flex gap-2 ">
                    <img src="{{ json_decode($log->course->mockup)->url }}" class="w-80  h-40 rounded-xl" alt="mockup course">
                    <div class="flex flex-col justify-between ">
                        <div>
                            <p>
                                This Course <b>{{ $log->course->title }}</b> is Changed his status to be
                                <b>{{ $log->status }}</b>
                            </p>
                            <small>{{ \Carbon\Carbon::parse($log->reviewed_at)->diffForHumans() }}</small>
                        </div>
                        <a href="{{ route('dashboard.instructor.courses.tracking', $log->course->id) }}"
                            class="text-sm text-white font-bold py-2 px-4 rounded-lg bg-green-500 hover:bg-green-700 duration-200">
                            Settings Course
                        </a>
                    </div>
                </div>
                <hr class="block w-2/3 mx-auto my-2">
            @empty
                <div class="flex justify-end">
                    {{ $logs->links() }}
                </div>
            @endforelse
        </div>
    </div>
@endsection
