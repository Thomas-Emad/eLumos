@if ($tickets->hasPages())
    <div class="pagination mt-2 flex justify-center space-x-2">
        @if ($tickets->onFirstPage())
            <span class="px-4 py-1 text-gray-500 cursor-not-allowed">← Previous</span>
        @else
            <a href="{{ $tickets->previousPageUrl() }}&status={{ request('status', 'all') }}&subject={{ request('subject', '') }}"
                class="px-4 py-1 bg-amber-700 text-white rounded hover:bg-amber-900">← Previous</a>
        @endif

        @foreach ($tickets->getUrlRange(1, $tickets->lastPage()) as $page => $url)
            <a href="{{ $url }}&status={{ request('status', 'all') }}&subject={{ request('subject', '') }}"
                class="px-4 py-1 rounded {{ $page == $tickets->currentPage() ? 'bg-amber-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                {{ $page }}
            </a>
        @endforeach

        @if ($tickets->hasMorePages())
            <a href="{{ $tickets->nextPageUrl() }}&status={{ request('status', 'all') }}&subject={{ request('subject', '') }}"
                class="px-4 py-1 bg-amber-700 text-white rounded hover:bg-amber-900">Next →</a>
        @else
            <span class="px-4 py-1 text-gray-500 cursor-not-allowed">Next →</span>
        @endif
    </div>
@endif
