@extends('layouts.dashboard')
@section('title', 'Your Notifications')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl ">
        <div class="p-4 rounded-xl border border-gray-200 bg-white">
            <h2 class="font-bold text-xl text-center">
                <span>Notifications</span>
            </h2>
        </div>

        @if (!empty($notifications))
            <hr class="block my-4 mx-auto w-2/3">
            <div class="gap-8 mt-4 text-gray-800 dark:text-gray-200">
                <ol class="relative border-s border-gray-200 dark:border-gray-700">
                    @foreach ($notifications as $notify)
                        <li class="mb-10 ms-2">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-2 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                <img class="w-6 h-6  rounded-full shadow-lg" src="{{ asset('assets/images/favicon.png') }}"
                                    alt="System Logo" />
                            </span>
                            <div
                                class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                <time
                                    class="block mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0 text-right">{{ $notify->created_at->diffForHumans() }}</time>
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                    <b class='uppercase'>{{ $notify->data['sender'] }}</b> {{ $notify->data['message'] }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
                {{ $notifications->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection
