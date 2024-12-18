@extends('layouts.app')
@section('title', 'Your Cart')

@section('css')
@endsection

@section('content')

    <div class="container mx-auto p-4 mt-16 max-w-screen-xl -translate-x-full an-section an-right text-gray-900">
        <h1 class="font-bold text-3xl my-2">Shopping Cart</h1>
        <div class="flex flex-col md:flex-row justify-between gap-4 ">
            <div class="w-full md:w-[70%]">
                <p class="text-gray-700 text-sm font-bold border-b-2 border-gray-100 pb-2 mb-2 ">
                    {{ $courses->count() }} Course in Cart
                </p>
                <div class="flex flex-col gap-4">
                    @foreach ($courses as $course)
                        <x-cart-basket :course="$course"></x-cart-basket>
                    @endforeach
                    @if ($courses->count() == 0)
                        <div class="bg-white p-4 rounded-xl w-full shadow-sm text-center italic text-gray-700">
                            Hmm, it looks like there are no courses in your cart.
                        </div>
                    @endif
                </div>
            </div>
            <div class="w-full md:w-[30%] p-2">
                @php
                    $totalPriceCourses = $courses->sum('price');
                    $totalCountCourses = $courses->count();
                @endphp
                <div class="bg-white p-4 rounded-xl shadow-sm">
                    <p class="font-bold">Total</p>
                    <p
                        class="text-amber-800 font-bold text-2xl my-2 totalPrice @if ($totalPriceCourses == 0 && $totalCountCourses > 0) text-green-600 text-3xl @endif">
                        @if ($totalPriceCourses == 0 && $totalCountCourses > 0)
                            Free
                        @else
                            {{ $totalPriceCourses . "$" }}
                        @endif
                    </p>
                    <form action="{{ route('checkout.viewPayment') }}" method='POST'>
                        @csrf
                        <button type="submit" @disabled($totalCountCourses == 0)
                            class="block w-full bg-amber-600 text-center text-white font-bold p-2 rounded-xl hover:bg-amber-800 duration-300 @if ($courses->count() == 0) bg-gray-600 @endif">
                            @if ($totalPriceCourses > 0 || $totalCountCourses == 0)
                                Checkout
                            @elseif ($totalPriceCourses == 0 && $totalCountCourses > 0)
                                Get For Free
                            @endif
                        </button>
                        @php
                            $wallet = Auth::user()?->wallet;
                        @endphp
                        @if ($totalPriceCourses != 0)
                            <div id="toggle-chechout" data-accordion="collapse" class="mt-4"
                                data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                                data-inactive-classes="text-gray-500 dark:text-gray-400">
                                <div>
                                    <h2 id="toggle-chechout-heading-1">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-2 text-sm text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-2"
                                            data-accordion-target="#toggle-chechout-body-1" aria-expanded="false"
                                            aria-controls="toggle-chechout-body-1">
                                            <span>Choose Your Payment Method?</span>
                                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="false"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M9 5 5 1 1 5" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="toggle-chechout-body-1" class="hidden"
                                        aria-labelledby="toggle-chechout-heading-1">
                                        <ul class="flex flex-col gap-2">
                                            <li>
                                                <input type="radio" id="stripe-option" value="stripe" name="gateway"
                                                    class="hidden peer" checked>
                                                <label for="stripe-option"
                                                    class="inline-flex justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                    <img class="h-6 w-auto dark:hidden"
                                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/stripe.svg"
                                                        alt="" />
                                                    <img class="hidden h-6 w-auto dark:flex"
                                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/stripe-dark.svg"
                                                        alt="" />
                                                </label>
                                            </li>
                                            <li>
                                                <input type="radio" id="paypal-option" value="paypal" name="gateway"
                                                    class="hidden peer">
                                                <label for="paypal-option"
                                                    class="inline-flex justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                    <img class="h-6 w-auto dark:hidden"
                                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/paypal.svg"
                                                        alt="" />
                                                    <img class="hidden h-6 w-auto dark:flex"
                                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/paypal-dark.svg"
                                                        alt="" />
                                                </label>
                                            </li>
                                            <li>
                                                <input type="radio" id="payoneer-option" value="payoneer" name="gateway"
                                                    class="hidden peer">
                                                <label for="payoneer-option"
                                                    class="inline-flex justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                    <img class="h-6 w-auto dark:hidden"
                                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/payoneer.svg"
                                                        alt="" />
                                                    <img class="hidden h-6 w-auto dark:flex"
                                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/payoneer-dark.svg"
                                                        alt="" />
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <h2 id="toggle-chechout-heading-2">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-2 text-sm text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-2"
                                            data-accordion-target="#toggle-chechout-body-2" aria-expanded="false"
                                            aria-controls="toggle-chechout-body-2">
                                            <span>Use your Wallat to Paid</span>
                                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M9 5 5 1 1 5" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="toggle-chechout-body-2" class="hidden py-2"
                                        aria-labelledby="toggle-chechout-heading-2">
                                        @if ($wallet > 0)
                                            <p class="text-sm text-gray-700 mb-2">- You Have in Your Wallet:
                                                <span class="wallet-now">{{ $wallet }}</span>$
                                            </p>
                                            <div class="flex flex-row text-sm">
                                                <input type="number" name="amountUseWallet" min="0"
                                                    value="0" step="0.01" max="{{ $wallet }}"
                                                    class="w-full p-2 border border-gray-200 rounded-l-lg"
                                                    placeholder="Amount Want To Use">
                                                <button type="button" id="apply-wallet" disabled
                                                    class="bg-gray-600 text-center text-white font-bold p-2 rounded-r-lg hover:bg-amber-800 duration-300">Apply</button>
                                            </div>
                                            <p class="text-red-600 text-xs hidden message-wallet mt-2"></p>
                                        @else
                                            <p class="text-center text-xs text-gray-400 italic mb-2">
                                                Sorry, but it seem your wallet is empty!!
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                    <hr class="my-4">
                    <p class="font-bold">Promotions</p>
                    <div class="flex flex-row  text-sm">
                        <input type="text" class="w-full p-2 border border-gray-200 rounded-l-lg"
                            placeholder="Promotion code">
                        <button
                            class="bg-amber-600 text-center text-white  font-bold p-2 rounded-r-lg hover:bg-amber-800 duration-300">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Check if the total price is greater than or equal to 5
            $("form button[type=submit]").on('click', function(e) {
                if ($(".totalPrice").html().trim() === "Free" || parseFloat($(".totalPrice").html()) > 5) {
                    return true;
                } else {
                    e.preventDefault();
                    $('.notifications').append(`@include('components.notifications.fail', [
                        'message' => 'Sorry, to complete the order it should be more than 5$ or Free',
                    ])`);
                }
            });

            const TotalOrder = parseFloat("{{ $totalPriceCourses }}");
            const UserWallet = parseFloat("{{ $wallet }}");

            // Cache DOM elements
            const $messageWallet = $('.message-wallet');
            const $applyWallet = $('#apply-wallet');
            const $walletNow = $('.wallet-now');
            const $totalPrice = $(".totalPrice");
            const $amountInput = $('input[name=amountUseWallet]');

            // Function to update wallet status and total price
            function updateWalletStatus(WalletUsed) {
                if (WalletUsed > UserWallet) {
                    $messageWallet.removeClass('hidden').html("- Sorry You Put More Than your had..");
                    $applyWallet.removeClass('bg-amber-600').addClass('bg-gray-600').prop('disabled', true);
                } else {
                    $messageWallet.addClass('hidden');
                    $applyWallet.removeClass('bg-gray-600').addClass('bg-amber-600').prop('disabled', false);
                }
            }

            // Function to update the total price after applying the wallet amount
            function updateTotalPrice(WalletUsed) {
                let totalNewPriceOrder = TotalOrder - WalletUsed;
                $walletNow.html((UserWallet - WalletUsed).toFixed(2));

                if (totalNewPriceOrder <= 0) {
                    $totalPrice.html("Free").addClass('text-green-500');
                } else {
                    $totalPrice.removeClass('text-green-500').html(totalNewPriceOrder.toFixed(2));
                }
            }

            // Event listener for amount input change
            $amountInput.on('change', function() {
                const WalletUsed = parseFloat($amountInput.val());
                updateWalletStatus(WalletUsed);
            });

            // Event listener for applying the wallet
            $applyWallet.on('click', function() {
                const WalletUsed = parseFloat($amountInput.val());
                updateWalletStatus(WalletUsed);

                if ($applyWallet.prop('disabled') === false && WalletUsed >= 0 &&
                    WalletUsed <= UserWallet) {
                    updateTotalPrice(WalletUsed);
                }
            });
        });
    </script>
@endsection
