@extends('layouts.dashboard')
@section('title', 'Previous Exams')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
        <div class="mb-2 border-b border-gray-200 pb-2 flex justify-between items-center gap-2">
            <h2 class="font-bold text-xl ">Previous Exams You Join in:</h2>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg min-h-[350px]">
            <form action="{{ route('dashboard.instructor.exams.index') }}" method="GET"
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
                                {{ $session->degree }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $session->created_at->diffInMinutes($session->updated_at) . '/' . $session->exam->duration }}
                            </td>
                            <td class="px-6 py-4">
                              {{ $session->status }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $session->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('dashboard.instructor.exams.show', $session->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Preview</a>
                            </td>
                        </tr>
                    @empty
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4" colspan="7">
                                <p class="font-bold text-center italic text-gray-600">
                                    it Look you not Have Any Exam?! Let's Add one for your Lectures..
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

    {{-- Exams Modals  --}}
    <x-modal id="add-exam-modal">
        <form action="{{ route('dashboard.instructor.exams.store') }}" method="POST">
            @csrf
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <span>Add New Exam..</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="add-exam-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-sm text-gray-500 dark:text-gray-100 mb-0">
                    It is preferable to write a title that expresses the purpose of the test..
                </p>
                <div class="flex gap-2">
                    <input type="text" name="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 dark:text-gray-50 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"
                        placeholder="Title of this Exam.." required />
                    <x-select name='with_time' placeholder="Allow to Add Duration for Exam">
                        <option value="no">Not need Time</option>
                        <option value="allow">Put your Duration Exam</option>
                    </x-select>
                </div>
                <div class="duration">
                    <input type="number" min='10' max="240" name="duration"
                        class='hidden outline-none border-1 border-gray-400 focus:border-gray-600 duration-300 rounded-lg w-full'>
                    <p class="text-sm text-gray-700">- For minute</p>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="add-exam-modal" type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Save
                </button>
                <button data-modal-hide="add-exam-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-whit rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </form>
    </x-modal>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Allow Add Duration for Exam
            $('select[name=with_time]').on('change', function() {
                let durationDiv = $('.duration');
                let inputTime = $('.duration input[name=duration]');
                if (this.value == 'no') {
                    durationDiv.addClass('hidden');
                } else {
                    durationDiv.removeClass('hidden');
                }
                inputTime.val('');
            });
        })
    </script>
@endsection
