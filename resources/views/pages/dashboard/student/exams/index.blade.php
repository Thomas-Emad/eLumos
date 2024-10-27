@extends('layouts.dashboard')
@section('title', 'Previous Exams')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
        <div class="mb-2 border-b border-gray-200 pb-2 flex justify-between items-center gap-2">
            <h2 class="font-bold text-xl ">Previous Exams You Join in:</h2>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg min-h-[350px]">
            <form action="{{ route('dashboard.student.exams.index') }}" method="GET"
                class="flex flex-row sm:flex-column gap-2 items-center justify-between pb-4">
                <x-select name='filterByDate' placeholder="Select Filter Exams By Date">
                    <option value="today" @selected(request()->get('filterByDate') === 'today')>Today</option>
                    <option value="yesterday" @selected(request()->get('filterByDate') === 'yesterday')>Yesterday</option>
                    <option value="last_week" @selected(request()->get('filterByDate') === 'last_week')>Last 7 Days</option>
                    <option value="last_month" @selected(request()->get('filterByDate') === 'last_month')>Last 30 Days</option>
                    <option value="this_year" @selected(request()->get('filterByDate', 'this_year') === 'this_year')>This Year</option>
                    <option value="last_year" @selected(request()->get('filterByDate') === 'last_year')>Last Year</option>
                </x-select>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <button type='submit'
                        class="absolute cursor-pointer inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 z-[10]">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <input type="text" id="table-search" name="title" value="{{ request()->get('title') }}"
                        class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for items">
                </div>
            </form>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Degree
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created
                        </th>
                        <th scope="col" class="px-6 py-3">
                            More
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sessions as $key => $session)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                {{ $sessions->firstItem() + $key }}
                            </td>
                            <th scope="row"
                                class=" px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ \Str::limit($session->exam->title, 10, '...') }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $session->degree . '/' . $session->exam->questions->count() }}
                            </td>
                            <td class="px-6 py-4">
                                {{ round($session->created_at->diffInMinutes($session->updated_at), 2) . '/' . $session->exam->duration }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $session->status }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $session->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('dashboard.student.exams.report', $session->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Preview</a>
                            </td>
                        </tr>
                    @empty
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4" colspan="7">
                                <p class="font-bold text-center italic text-gray-600">
                                    it Look you not Have Any Exam?! Let's Solve one Now..
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4 flex gap-4 justify-end items-center">
                {{ $sessions->links() }}
            </div>
        </div>

    </div>
@endsection
