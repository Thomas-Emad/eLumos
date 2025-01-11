<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                ID
            </th>
            <th scope="col" class="px-6 py-3">
                Subject
            </th>
            <th scope="col" class="px-6 py-3">
                Priority
            </th>
            <th scope="col" class="px-6 py-3">
                Created
            </th>
            <th scope="col" class="px-6 py-3">
                Last Activity
            </th>
            <th scope="col" class="px-6 py-3">
                Status
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($tickets as $ticket)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4">
                    <a href="{{ route('dashboard.tickets.show', ['ticket' => $ticket->request_id]) }}"
                        class="text-blue-600 hover:text-blue-800 duration-200">
                        {{ $ticket->request_id }}
                    </a>
                </th>
                <td class="px-6 py-4">
                    {{ Str::limit($ticket->subject, 20) }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-2.5 w-2.5 rounded-full {{ $ticket->priority->bgColor() }} me-2"></div>
                        {{ $ticket->priority->label() }}
                    </div>
                </td>
                <td class="px-6 py-4">
                    {{ $ticket->created_at->diffForHumans() }}
                </td>
                <td class="px-6 py-4">
                    {{ $ticket->messages()->latest()->first()?->created_at->diffForHumans() ?? 'N/A' }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-2.5 w-2.5 rounded-full {{ $ticket->status->bgColor() }} me-2"></div>
                        {{ $ticket->status->label() }}
                    </div>
                </td>
            </tr>
        @empty
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 text-center font-bold italic text-gray-600" colspan="6">
                    No requests found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
