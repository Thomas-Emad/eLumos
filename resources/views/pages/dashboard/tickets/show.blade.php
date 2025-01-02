@extends('layouts.app')
@section('title', 'New Request | Support')

@section('content')
    <div class="container mx-auto min-h-screen mt-20 p-2">
        <div class="p-4 rounded-xl border border-gray-200 bg-white flex gap-2 items-center">
            <a href="{{ route('dashboard.tickets.index') }}"
                class="text-gray-700 py-1 px-3 rounded-lg bg-slate-100/70 hover:bg-gray-400/50 border border-gray-500/20 duration-200">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl">
                #{{ $ticket->request_id }} ({{ Str::limit($ticket->subject, 20) }})
            </h2>
        </div>
        <div class="mt-4 flex flex-col md:flex-row gap-4 justify-between">
            <div class="w-full md:w-1/3 p-4 rounded-xl border border-gray-200 bg-white h-[500px] overflow-x-auto">
                <div>
                    <h3 class="font-bold border-b border-gray-100 text-xl mb-2">Information</h3>
                    <div class="text-sm">
                        <p><b>Ticket ID: </b>{{ $ticket->request_id }}</p>
                        <p><b>User Name: </b>{{ $ticket->user->name }}</p>
                        <p><b>Role User: </b>{{ implode(', ', $ticket->user->roles->pluck('name')->toArray()) }}</p>
                        <p><b>Status Account: </b>{{ $ticket->user->status }}</p>
                        <p><b>Status Request: </b>
                            <span @class([
                                'text-white py-1 px-2 rounded-lg text-xs',
                                'bg-amber-600' => $ticket->status == 'pending',
                                'bg-gray-600' => $ticket->status == 'wait_support',
                                'bg-gray-600' => $ticket->status == 'wait_user',
                                'bg-green-600' => $ticket->status == 'solved',
                            ])>{{ $ticket->status }}</span>
                        </p>
                        <p><b>Priority Request: </b>
                            <span @class([
                                'text-green-600' => $ticket->priority == 'low',
                                'text-amber-600' => $ticket->priority == 'medium',
                                'text-red-600' => $ticket->priority == 'high',
                            ])>{{ $ticket->priority }}</span>
                        </p>
                    </div>
                </div>
                @if (!is_null($ticket->rate))
                    <hr class="block w-2/3 mx-auto my-2">
                    <div>
                        <h3 class="font-bold border-b border-gray-100 text-xl mb-2">Feedback</h3>
                        <div class="text-sm">
                            <p><b>Complete At: </b>{{ Carbon\Carbon::parse($ticket->completed_at)?->diffForHumans() }}</p>
                            <div class="flex gap-1 text-sm my-2 bg-gray-200 py-2 px-4 rounded-sm w-fit">
                                @for ($i = 1; $i <= floor($ticket->rate); $i++)
                                    <i class="fa-solid fa-star text-amber-500"></i>
                                @endfor

                                @for ($i = 1; $i <= 5 - ceil($ticket->rate); $i++)
                                    <i class="fa-solid fa-star text-white"></i>
                                @endfor
                            </div>
                            <x-textarea class="mt-2" label='feedback' disabled="true">
                                {{ $ticket->feedback }}
                            </x-textarea>
                        </div>
                    </div>
                @endif
                <hr class="block w-2/3 mx-auto my-2">
                <div>
                    <h3 class="font-bold border-b border-gray-100 text-xl mb-2">Ticket</h3>
                    <div class="text-sm">
                        <x-input label='Type Request' disabled="true" value="{{ $ticket->type }}" />

                        <x-textarea class="mt-2" label='subject' disabled="true">
                            {{ $ticket->subject }}
                        </x-textarea>

                        <x-textarea class="min-h-40 mt-2" label='Description' disabled="true">
                            {{ $ticket->description }}{{ old('description') }}
                        </x-textarea>
                    </div>
                </div>
                <hr class="block w-2/3 mx-auto my-2">
                <button type="button"
                    class="close-request block text-white font-bold bg-red-700 hover:bg-red-800 duration-200 py-2 px-6 rounded-lg mx-auto">
                    Close Request
                </button>

            </div>
            <div class="w-full md:w-2/3 rounded-xl border border-gray-200 bg-white  overflow-x-auto relative">
                <div
                    class="flex items-center gap-4 text-gray-700 border-b border-gray-100 pb-2 sticky -top-2 left-0 w-full z-10 bg-white p-5">
                    <img src="{{ isset(auth()->user()->photo) ? asset('storage/' . auth()->user()->photo) : asset('assets/images/user-1.png') }}"
                        class="w-12 h-12 rounded-full" alt="photo user">
                    <div>
                        <h1 class="font-bold text-md">{{ $ticket->user->name }}</h1>
                        <p class="text-sm">
                            Last Actively ({{ $ticket->messages()->latest()->first()?->created_at }})
                        </p>
                    </div>
                </div>
                <div class="p-4 ">
                    <div class="flex-2 overflow-y-auto h-[300px] p-4 bg-gray-50">
                        <div class="space-y-4 messages">
                            @foreach ($ticket->messages as $message)
                                @if ($message->user_id == Auth::id())
                                    @include('pages.dashboard.tickets.partials.right-message', [
                                        'message' => $message,
                                    ])
                                @else
                                    @include('pages.dashboard.tickets.partials.left-message', [
                                        'message' => $message,
                                    ])
                                @endif
                            @endforeach


                            <!-- Add more messages -->
                        </div>
                    </div>
                    <div class="p-4 bg-white border-t border-gray-300">
                        <form id="send-message" class="flex items-center space-x-2">
                            <input type="text" placeholder="Type a message..."
                                class="flex-1 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-300">
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        $(document).ready(() => {
            const PUSHER_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
            const PUSHER_KEY = "{{ config('broadcasting.connections.pusher.key') }}";

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = false;

            var pusher = new Pusher(PUSHER_KEY, {
                cluster: PUSHER_CLUSTER,
                encrypted: true,
            });

            var channel = pusher.subscribe('ticket.{{ $ticket->id }}');
            channel.bind('chat', function(data) {
                $.ajax({
                    url: '{{ route('dashboard.tickets.receiver') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        _token: "{{ csrf_token() }}",
                        ticket_id: "{{ $ticket->id }}",
                        message_ticket_id: data.message_id,
                    }),
                    success: function(response) {
                        $(".messages")
                            .append(response.view)
                            .scrollTop($(".messages")[0].scrollHeight);
                    },
                });
            });

            $("#send-message button[type=submit]").on('click', function(event) {
                const mesasge = $("#send-message input[type=text]").val();
                $("#send-message input[type=text]").val('');
                event.preventDefault();

                $.ajax({
                    url: '{{ route('dashboard.tickets.send') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        _token: "{{ csrf_token() }}",
                        ticket_id: "{{ $ticket->id }}",
                        user_id: "{{ Auth::id() }}",
                        message: mesasge,
                    }),
                    success: function(response) {
                        $(".messages").append(response.view);
                    },
                });
            });

        });
    </script>
@endsection
