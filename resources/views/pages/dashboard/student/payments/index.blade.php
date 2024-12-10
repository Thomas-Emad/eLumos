@extends('layouts.dashboard')

@section('title', 'Your Payments')

@section('content-dashboard')
    <div class="min-h-screen container mx-auto py-4">
        <div class="p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
            <h2 class="font-bold text-xl mb-2 border-b border-gray-200 pb-2 flex justify-between items-center">
                Payments
            </h2>

            <div>
                @forelse ($payments as $payment)
                    <div class="flex flex-col md:flex-row justify-between gap-4 items-center">
                        <div class="flex flex-row  gap-4">
                            <img class="w-12 h-12 rounded-xl" src="{{ getImagePaymentByStatus($payment->status) }}"
                                alt="Icon Status Payment">
                            <div>
                                <h3 class="font-bold text-xl hover:text-amber-700 duration-200">
                                    <a href="{{ route('dashboard.orders.show.api', $payment->transaction_id) }}">
                                        {{ getMessagePaymentByStatus($payment->status) }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-100">
                                    Count Courses: {{ $payment->items_count }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-100">
                                    {{ $payment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <button type='button' data-id="{{ $payment->transaction_id }}"
                                    data-drawer-target="sidebar-payment" data-drawer-show="sidebar-payment"
                                    aria-controls="sidebar-payment"
                                    class="payment-order border border-gray-400 hover:border-gray-600 text-gray-400 hover:text-gray-600 py-1 px-2 rounded-full text-sm duration-200">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button
                                    class="border border-gray-400 hover:border-gray-600 text-gray-400 hover:text-gray-600 py-1 px-2 rounded-full text-sm duration-200"
                                    data-popover-target="info-{{ $payment->id }}" type="button">
                                    <i class="fa-regular fa-circle-question"></i>
                                </button>
                            </div>

                            <div data-popover id="info-{{ $payment->id }}" role="tooltip"
                                class="absolute z-10 invisible inline-block w-128 text-sm text-white transition-opacity duration-300 bg-gray-900/90 rounded-lg shadow-sm opacity-0 p-2">
                                <div class="whitespace-nowrap">
                                    <p>Total Courses: {{ $payment->items_count }}</p>
                                    <p>Total Amount: {{ $payment->amount . ' ' . \Str::ucfirst($payment->currency) }}</p>
                                    <p>Status Payment: {{ \Str::ucfirst($payment->status) }}</p>
                                    <p>Transaction Id: {{ $payment->transaction_id }}</p>
                                    <p>Payment Date: {{ $payment->payment_date ?? 'N/A' }}</p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>

                        </div>

                    </div>
                    <hr class="mx-6 my-4">
                @empty
                    <p class="text-center italic text-gray-600">It looks like you haven't added any reviews yet.</p>
                @endforelse
                @if (sizeof($payments) > 0)
                    {{ $payments->links('pagination::tailwind') }}
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebare Show Payment -->
    <div id="sidebar-payment"
        class="fixed top-0 left-0 z-40 w-full md:w-full h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-gray-50 dark:bg-gray-800"
        tabindex="-1" aria-labelledby="sidebar-payment-label">
        <h5 id="sidebar-payment-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">
            Show Payment
        </h5>
        <button type="button" data-drawer-hide="sidebar-payment" aria-controls="sidebar-payment"
            class="hidden-sidebar text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <div class="py-4 overflow-y-auto h-full">
            {{-- Loader --}}
            <div class="loader flex justify-center" role="status">
                <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-400"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
            <div class="content"></div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(() => {
            // Show Sidebar Payment
            $(".payment-order").on('click', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('dashboard.orders.show.api') }}/" + $(this).attr('data-id'),
                    contentType: 'application/json',
                    data: {
                        _token: "{{ csrf_token() }}",
                    }
                }).done((response) => {
                    $(".loader").addClass('hidden');
                    $("#sidebar-payment .content").html(response.html);
                })
            });

            // Hidden Sidebar, Show Loader
            $(".hidden-sidebar").on('click', function() {
                $(".loader").removeClass('hidden');
                $("#sidebar-payment .content").empty();
            });
        });
    </script>
@endsection
