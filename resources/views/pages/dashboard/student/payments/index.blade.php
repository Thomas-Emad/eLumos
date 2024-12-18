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
            <x-loader classCall="loader" />

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
