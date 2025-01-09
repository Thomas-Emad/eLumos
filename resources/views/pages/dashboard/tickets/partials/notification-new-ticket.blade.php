@if (auth()->user()->hasPermissionTo('support'))
    <script>
        $(document).ready(() => {
            var channel = pusher.subscribe('ticket-notification');
            channel.bind('notification', function(data) {
                var ticketLink = "{{ route('dashboard.tickets.show', ['ticket' => '__TICKET_ID__']) }}";
                ticketLink = ticketLink.replace('__TICKET_ID__', data.requestId);

                var notificationHTML = `@php
                    echo view('components.notifications.success', [
                        'message' => 'There is a new ticket here, click on it.',
                        'link' => '__TICKET_LINK__',
                    ])->render();
                @endphp`;
                notificationHTML = notificationHTML.replace('__TICKET_LINK__', ticketLink)
                $('.notifications').append(notificationHTML);
            });
        });
    </script>
@endif
