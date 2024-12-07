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
                    <div class="flex flex-row justify-between gap-4 items-center">
                        <div class="flex flex-row gap-4">
                            <img class="w-12 h-12 rounded-xl" src="{{ getImagePaymentByStatus($payment->status) }}"
                                alt="Icon Status Payment">
                            <div>
                                <h3 class="font-bold text-xl hover:text-amber-700 duration-200">
                                    <a href="{{ route('dashboard.orders.show', $payment->transaction_id) }}">
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
                                <a href="{{ route('dashboard.orders.show', $payment->transaction_id) }}"
                                    class="border border-gray-400 hover:border-gray-600 text-gray-400 hover:text-gray-600 py-1 px-2 rounded-full text-sm duration-200">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
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

@endsection
