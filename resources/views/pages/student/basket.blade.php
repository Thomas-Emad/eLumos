@extends('layouts.app')
@section('title', 'Your Cart')

@section('css')
@endsection

@section('content')

    <div class="container mx-auto p-4 mt-16 max-w-screen-xl -translate-x-full an-section an-right text-gray-900">
        <h1 class="font-bold text-3xl my-2">Shopping Cart</h1>
        <div class="flex flex-col md:flex-row justify-between gap-4 ">
            <div class="w-full md:w-[70%]">
                <p class="text-gray-700 text-sm font-bold border-b-2 border-gray-100 pb-2 mb-2 ">{{ $courses->count() }}
                    Course in Cart</p>
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
                <div class="bg-white p-4 rounded-xl shadow-sm">
                    <p class="font-bold">Total</p>
                    <p class="text-amber-800 font-bold text-2xl my-2">{{ $courses->sum('price') }}$</p>
                    <form action="{{ route('checkout.viewPayment') }}" method='GET'>
                        <button type="submit" @disabled($courses->count() == 0)
                            class="block w-full bg-amber-600 text-center text-white font-bold p-2 rounded-xl hover:bg-amber-800 duration-300 @if ($courses->count() == 0) bg-gray-600 @endif">
                            Checkout
                        </button>
                        <ul class="flex flex-col gap-2 mt-4">
                            <li>
                                <input type="radio" id="stripe-option" value="stripe" name="gateway" class="hidden peer"
                                    checked>
                                <label for="stripe-option"
                                    class="inline-flex justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <img class="h-8 w-auto dark:hidden"
                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/stripe.svg"
                                        alt="" />
                                    <img class="hidden h-8 w-auto dark:flex"
                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/stripe-dark.svg"
                                        alt="" />
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="paypal-option" value="paypal" name="gateway" class="hidden peer">
                                <label for="paypal-option"
                                    class="inline-flex justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <img class="h-8 w-auto dark:hidden"
                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/paypal.svg"
                                        alt="" />
                                    <img class="hidden h-8 w-auto dark:flex"
                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/paypal-dark.svg"
                                        alt="" />
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="payoneer-option" value="payoneer" name="gateway"
                                    class="hidden peer">
                                <label for="payoneer-option"
                                    class="inline-flex justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <img class="h-8 w-auto dark:hidden"
                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/payoneer.svg"
                                        alt="" />
                                    <img class="hidden h-8 w-auto dark:flex"
                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/payoneer-dark.svg"
                                        alt="" />
                                </label>
                            </li>

                        </ul>

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
@endsection
