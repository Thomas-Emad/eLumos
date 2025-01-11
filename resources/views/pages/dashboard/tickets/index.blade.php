@extends('layouts.app')
@section('title', 'Support')

@section('content')
    <div class="min-h-40 bg-center bg-contain relative mt-16 flex items-center"
        style="background-image: url({{ asset('assets/images/dashboard.jpg') }})">
        <div class="absolute top-0 left-0 w-full h-full z-[1] bg-[#22222299] "></div>
        <div class="container mx-auto max-w-screen-xl px-4 py-8 relative z-[2] text-white text-center">
            <h1 class="text-6xl font-bold">@yield('title')</h1>
        </div>
    </div>
    <div class="container mx-auto min-h-auto-xl mt-4 p-2">
        <div class="p-4 rounded-xl border border-gray-200 bg-white flex justify-between items-center">
            <h2 class="font-bold texp-2t-2xl">
                Support Requests
            </h2>
            <a href='{{ route('dashboard.tickets.create') }}'
                class='text-sm cursor-pointer py-2 px-4 rounded-xl text-white font-bold bg-gray-700 hover:bg-gray-900 duration-200'>
                new Request
            </a>
        </div>
        <div
            class='mt-2 p-4 rounded-xl border min-h-screen border-gray-200 bg-white relative overflow-x-auto shadow-md sm:rounded-lg'>
            <div
                class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                <div>
                    <select id="table-status-ticket"
                        class="block w-44 p-2 bg-white border border-gray-300 rounded-lg shadow dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-200">
                        <option value="all" @selected(request()->input('status', 'all') == 'all')>All</option>
                        <option value="pending" @selected(request()->input('status', 'all') == 'pending')>Pending</option>
                        <option value="wait_support" @selected(request()->input('status', 'all') == 'wait_support')>Wait Support</option>
                        <option value="wait_user" @selected(request()->input('status', 'all') == 'wait_user')>Wait User</option>
                        <option value="closed_support" @selected(request()->input('status', 'all') == 'closed_support')>Closed By Support</option>
                        <option value="closed_user" @selected(request()->input('status', 'all') == 'closed_user')>Closed By User</option>
                        <option value="solved" @selected(request()->input('status', 'all') == 'solved')>Solved</option>
                    </select>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search-ticket"
                        class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for ticket">
                </div>
            </div>
            <div id="table-tickets">
                @include('pages.dashboard.tickets.partials.table', ['tickets' => $tickets])
                <!-- Pagination -->
            </div>
            <div id="pagination" class="flex justify-center mt-4">
                {{ $tickets->links('pages.dashboard.tickets.partials.pagination', ['tickets' => $tickets]) }} </div>
        </div>
    </div>
@endsection

@section('js')
    @include('pages.dashboard.tickets.pusher-js')
    @include('pages.dashboard.tickets.partials.notification-new-ticket')

    <script>
        $(document).ready(function() {
            $("#table-search-ticket").on('change', function() {
                getNewTable();
            });
            $("#table-status-ticket").on('change', function() {
                getNewTable();
            });

            function getNewTable() {
                // Get values of the input fields
                const subject = $("#table-search-ticket").val();
                const status = $("#table-status-ticket").val();

                // Update the URL in the browser's address bar
                updateUrlPage(subject, status);

                // Make the AJAX request
                $.ajax({
                    url: "{{ route('dashboard.tickets.table') }}",
                    method: "GET",
                    data: {
                        subject: subject,
                        status: status
                    },
                    success: function(data) {
                        $('#table-tickets').html(data.content);
                        $('#pagination').html(data.pagination);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: ", error);
                    }
                });
            }

            function updateUrlPage(subject, status) {
                const params = new URLSearchParams({
                    subject: subject,
                    status: status,
                }).toString();
                const newUrl = `${window.location.origin}${window.location.pathname}?${params}`;
                history.replaceState(null, '', newUrl);
            }
        });
    </script>
@endsection
