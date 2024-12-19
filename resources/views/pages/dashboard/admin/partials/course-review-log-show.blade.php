@foreach ($logs as $key => $items)
    <div class="p-5 mb-4 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <time
            class="text-lg font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($key)->isoFormat('MMMM Do YYYY') }}</time>
        <ol class="mt-3 divide-y divider-gray-200 dark:divide-gray-700">
            @foreach ($items as $item)
                <li>
                    <a class="items-center block p-3 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">

                        <img class="w-12 h-12 mb-3 me-3 rounded-full sm:mb-0"
                            src="{{ asset('assets/images/icons/' . $item->status . '.png') }}" alt="icon Status Course">
                        <div class="text-gray-600 dark:text-gray-400">
                            <div class="text-base font-normal">
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $item->reviewer->name }}</span>
                                Change Status Course To <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $item->status }}</span>
                            </div>
                            <div class="text-sm font-normal">The Reason is: "{{ $item->reason }}"</div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ol>
    </div>
@endforeach



@if (sizeof($logs) == 0)
    <p class="text-center italic text-gray-800">No review logs found.</p>
@endif
