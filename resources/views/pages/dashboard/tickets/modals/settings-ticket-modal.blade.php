@props(['id' => '', 'status' => '', 'priority' => ''])
<x-modal id="settings-ticket-modal">
    <div>
        @csrf
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                <span>You Are Sure want Close This Ticket?!</span>
            </h3>
            <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="settings-ticket-modal">
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
            @if (in_array($status->value, ['pending', 'solved', 'wait_user', 'wait_support']))
                <div class="bg-gray-100 p-4 rounded-lg flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <h1 class="text-xl font-bold text-amber-600">Change Status Ticket</h1>
                        <button type="button"
                            class="status-ticket inline-block py-2 px-4 bg-green-400 hover:bg-green-700 duration-200 text-white font-bold rounded-lg shadow-md">
                            Settings
                        </button>
                    </div>
                    <div class="show-status-ticket hidden">
                        <form action="{{ route('dashboard.tickets.changeStatus') }}" method="POST">
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $id }}">

                            <h2 class="font-bold text-lg mb-2">Change Status Ticket</h2>
                            <ul class="flex justify-center gap-4 ">
                                <li class="w-full md:w-1/2">
                                    <input type="radio" id="solved-option" name="status" value="solved"
                                        class="hidden peer" required="">
                                    <label for="solved-option"
                                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-green-50">
                                        <div class="block">
                                            <img class="w-12 h-12" src="{{ asset('assets/images/icons/active.png') }}"
                                                alt="icon student">
                                            <div class="w-full text-lg font-semibold">Solved</div>
                                        </div>
                                    </label>
                                </li>
                                <li class="w-full md:w-1/2">
                                    <input type="radio" id="close_support-option" name="status" value="close_support"
                                        class="hidden peer">
                                    <label for="close_support-option"
                                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-red-50">
                                        <div class="block">
                                            <img class="w-12 h-12" src="{{ asset('assets/images/icons/rejected.png') }}"
                                                alt="icon student">
                                            <div class="w-full text-lg font-semibold">Closed</div>
                                        </div>
                                    </label>
                                </li>
                            </ul>

                            <div class="submit-status hidden mt-2">
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
                        <h1 class="text-xl font-bold text-amber-600">Change Priority</h1>
                        <button type="button"
                            class="priority-ticket inline-block py-2 px-4 bg-green-400 hover:bg-green-700 duration-200 text-white font-bold rounded-lg shadow-md">
                            Settings
                        </button>
                    </div>
                    <div class="show-priority-ticket hidden">
                        <form action="{{ route('dashboard.tickets.changePriority') }}" method="POST">
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $id }}">

                            <h2 class="font-bold text-lg mb-2">Change Priority Ticket</h2>
                            <x-select name='priority'>
                                <option value="low" @selected($priority->value == 'low')>Low</option>
                                <option value="medium" @selected($priority->value == 'medium')>Medium</option>
                                <option value="high" @selected($priority->value == 'high')>High</option>
                            </x-select>


                            <div class="submit-priority hidden mt-2">
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
            @endif

            <div class="bg-gray-100 p-4 rounded-lg flex flex-col gap-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-bold text-amber-600">Log This Ticket</h1>
                    <button type="button"
                        class="logs-ticket inline-block py-2 px-4 bg-green-400 hover:bg-green-700 duration-200 text-white font-bold rounded-lg shadow-md">
                        Show
                    </button>
                </div>
                <div class="show-logs-ticket hidden">
                    <x-loader classCall="loader-log hidden" />
                    <div class="content"></div>
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button data-modal-hide="settings-ticket-modal" type="button"
                class="w-full py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-whit rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Close
            </button>
        </div>
    </div>
</x-modal>

@section('js')
    <script>
        $('.status-ticket').on('click', function() {
            $(".show-status-ticket").toggleClass('hidden');
        });
        $("input[name=status]").on('change', function() {
            if ($(this).val() != null) {
                $(".submit-status").removeClass('hidden');
            }
        });
        $('.priority-ticket').on('click', function() {
            $(".show-priority-ticket").toggleClass('hidden');
        });
        $("select[name=priority]").on('change', function() {
            if ($(this).val() != null) {
                $(".submit-priority").removeClass('hidden');
            }
        });

        /* Get logs Changes on this Course */
        $('.logs-ticket').on('click', function() {
            const logsContainer = $(".show-logs-ticket");
            const contentContainer = $(".show-logs-ticket .content");
            const loader = $('.loader-log');

            if (logsContainer.hasClass('hidden')) {
                // Show the logs container and loader
                logsContainer.removeClass('hidden');
                loader.removeClass('hidden');
                contentContainer.empty();

                // Make the AJAX request to fetch logs
                $.ajax({
                    url: "{{ route('dashboard.tickets.logs') }}",
                    type: "GET",
                    data: {
                        ticket_id: "{{ $ticket->id }}"
                    },
                    success: function(response) {
                        contentContainer.html(response.content);
                        loader.addClass('hidden');
                    },
                    error: function() {
                        loader.addClass('hidden');
                        contentContainer.html(
                            '<p class="text-red-500">Failed to load logs. Please try again.</p>');
                    }
                });
            } else {
                // Hide the logs container and clear the content
                logsContainer.addClass('hidden');
                contentContainer.empty();
            }
        });
    </script>
@endsection
