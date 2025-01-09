<div class="overflow-y-auto overflow-x-auto h-[400px]">

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-xl ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    User
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Priority
                </th>
                <th scope="col" class="px-6 py-3">
                    Reason
                </th>
                <th scope="col" class="px-6 py-3">
                    At
                </th>

            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 whitespace-nowrap">
                        {{ $log->user->name }}
                    </th>
                    <td class="px-6 py-4  whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-2.5 w-2.5 rounded-full {{ $log->status->bgColor() }} me-2"></div>
                            {{ $log->status->label() }}
                        </div>
                    </td>
                    <td class="px-6 py-4  whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-2.5 w-2.5 rounded-full {{ $log->priority->bgColor() }} me-2"></div>
                            {{ $log->priority->label() }}
                        </div>
                    </td>
                    <td class="px-6 py-4  whitespace-nowrap" title="{{ $log->reason }}">
                        {{ str($log->reason)->limit(20) }}
                    </td>
                    <td class="px-6 py-4  whitespace-nowrap">
                        {{ $log->created_at->diffForHumans() }}
                    </td>
                </tr>
            @empty
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 text-center font-bold italic text-gray-600" colspan="5">
                        No Update Here.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
