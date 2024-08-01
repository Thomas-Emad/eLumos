@extends('layouts.app')
@section('title', 'Forgot Your Password')

@section('css')
@endsection

@section('content')
    <div class="p-4 w-11/12 md:w-2/3  rounded-xl border border-gray-200 my-20 mt-28 mx-auto ">
        @session('status')
            <p class="text-center font-bold text-green-600 text-xl">
                Messages have been sent to your email to set your password!..
            </p>
        @else
            <div class=" p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="login" role="tabpanel" aria-labelledby="login-tab">
                <h1 class="font-bold text-3xl mb-4">Reset The Password </h1>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <i class="fa-solid fa-envelope text-gray-500"></i>
                            </div>
                            <input type="email" id="email-login" name="email" value="{{ old('email') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full ps-10 p-2.5  dark:bg-amber-700 dark:border-amber-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500"
                                placeholder="your.mail@gmail.com">
                        </div>
                        @error('email')
                            <span class="block text-red-700 text-sm font-bold mb-1">- {{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full rounded-full p-2 text-white bg-amber-500 hover:bg-amber-700 transition ">
                        Email Password Reset Link
                    </button>
                </form>
            </div>
        @endsession

    </div>
@endsection

@section('js')
@endsection
