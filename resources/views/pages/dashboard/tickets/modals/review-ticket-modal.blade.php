@props(['id' => ''])
<x-modal id="review-ticket-modal">
    <form action="{{ route('dashboard.tickets.review') }}" method="POST">
        @csrf
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                <span>Yes, Sure Tell us About Your Review?</span>
            </h3>
            <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="review-ticket-modal">
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
            <!-- Rating -->

            <h4 class="font-bold text-lg">What is your Rating of this Support?:</h4>
            <div>
                <div class="flex gap-2 justify-between flex-col md:flex-row">
                    <input type="hidden" name="ticket_id" value="{{ $id }}">
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="w-full">
                            <input type="radio" name="rate" id="rating-{{ $i }}-option"
                                value="{{ $i }}" class="hidden peer">

                            <label for="rating-{{ $i }}-option"
                                class="inline-flex flex-col items-center justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer  peer-checked:bg-amber-600 peer-checked:text-white  hover:bg-gray-50 ">
                                <div class=" font-semibold">{{ $i }}</div>
                                <i class="fa-regular fa-star "></i>
                            </label>
                        </div>
                    @endfor
                </div>
                <x-textarea label='You can Leave Your Feedback' name='content' class="mt-2"></x-textarea>
            </div>

            <!-- End Rating -->
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button type="submit"
                class="text-white bg-amber-700 hover:bg-amber-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800">
                Save My Review
            </button>
            <button data-modal-hide="review-ticket-modal" type="button"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-whit rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                No, Back
            </button>
        </div>
    </form>
</x-modal>
