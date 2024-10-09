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
                    <form action="{{route('checkout.saveCourses')}}" method='POST'>
                      @csrf
                      <button type="submit" @disabled($courses->count() == 0)
                      class="block w-full bg-amber-600 text-center text-white font-bold p-2 rounded-xl hover:bg-amber-800 duration-300 @if ($courses->count() == 0) bg-gray-600 @endif">
                        Checkout
                      </button>
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
