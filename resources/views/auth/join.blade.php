@extends('layouts.app')
@section('title', 'Joing')

@section('css')
@endsection

@section('content')
    <div class="p-4 w-11/12 md:w-2/3  rounded-xl border border-gray-200 dark:bg-gray-900 my-20 mt-28 mx-auto ">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="logs" data-tabs-toggle="#logs"
            role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2  rounded-t-lg " id="login-tab" data-tabs-target="#login"
                    type="button" role="tab" aria-controls="login"
                    aria-selected="{{ old('tab') == 'login' ? 'true' : 'false' }}">Login</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="register-tab" data-tabs-target="#register" type="button" role="tab" aria-controls="register"
                    aria-selected="{{ old('tab') == 'register' ? 'true' : 'false' }}">Register</button>
            </li>

        </ul>
        <div id="logs">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="login" role="tabpanel"
                aria-labelledby="login-tab">
                <h1 class="font-bold text-2xl mb-2">Login</h1>
                <form action='{{ route('login') }}' method='post'>
                    @csrf
                    <input type="hidden" name="tab" value="login">
                    <x-input-icon name='email' title="Your Email" typeInput='email' class=""
                        defValue='elumos@gmail.com' id="email-login" placeholder="name@gmail.com">
                        <i class="fa-solid fa-envelope text-gray-500"></i>
                    </x-input-icon>

                    <x-input-icon name='password' title="Your Password" typeInput='password' class=""
                        defValue='123456' id="password-login" placeholder="********">
                        <i class="fa-solid fa-lock text-gray-500"></i>
                    </x-input-icon>
                    <div class="flex items-center my-2">
                        <input checked id="orange-checkbox" type="checkbox" name="remember"
                            class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="orange-checkbox"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                    </div>
                    <button type="submit"
                        class="w-full rounded-full p-2 text-white bg-amber-500 hover:bg-amber-700 transition ">Login</button>
                </form>
                <a href="{{ route('password.request') }}"
                    class="inline-block text-sm text-gray-700 dark:text-gray-200 mt-2 hover:text-gray-900">Lost Your
                    password?!</a>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="register" role="tabpanel"
                aria-labelledby="register-tab">
                <h1 class="font-bold text-2xl mb-2">Register</h1>
                <form action='{{ route('register') }}' method='post'>
                    @csrf
                    <input type="hidden" name="tab" value="register">
                    <x-input-icon name='name_register' title="Your name?!" typeInput='text' class="" defValue=''
                        id="name_register" placeholder="What is Your Name?..">
                        <i class="fa-solid fa-user text-gray-500"></i>
                    </x-input-icon>
                    <x-input-icon name='email_register' title=" Your e-mail?!" typeInput='email' class=""
                        defValue='' id="email_register" placeholder="name@elumos.com?..">
                        <i class="fa-solid fa-envelope text-gray-500"></i>
                    </x-input-icon>

                    <div class="mb-4">
                        <label for="role_register" class="block text-sm font-medium text-gray-900 dark:text-white">Who Are
                            you?</label>
                        <select id="role_register" name="role_register"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="student" @selected(old('role_register') == 'student')>Student</option>
                            <option value="instructor" @selected(old('role_register') == 'instructor')>Instructor</option>
                        </select>
                    </div>
                    <x-input-icon name='password_register' title="Your Password?!" typeInput='password' class=""
                        defValue='' id="password_register" placeholder="********">
                        <i class="fa-solid fa-lock text-gray-500"></i>
                    </x-input-icon>
                    <x-input-icon name='password_register_confirmation' title="Your Password?!" typeInput='password'
                        class="" defValue='' id="password_register_confirmation" placeholder="********">
                        <i class="fa-solid fa-circle-check text-gray-500"></i>
                    </x-input-icon>
                    <div class=" mb-4">
                        <div class="flex items-center">
                            <input @checked(old('terms_register')) id="terms_register" name="terms_register" type="checkbox"
                                class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="terms_register"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">This
                                means
                                you agree to our terms and conditions, which can be
                                <a href="{{ route('terms') }}" class="hover:text-amber-600 underline">read here.</a>
                            </label>
                        </div>
                        @error('terms_register')
                            <span class="block text-red-700 text-sm font-bold mb-1">- {{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full rounded-full p-2 text-white bg-amber-500 hover:bg-amber-700 transition ">Register</button>
                </form>
            </div>
            <hr class="block w-96 mx-auto my-2">
            <a href="{{ route('oauth.redirect', 'google') }}"
                class="flex gap-2 items-center px-4 hover:bg-gray-100 w-full rounded-xl border border-gray-200 duration-200">
                <img src="{{ asset('assets/images/icons/google.svg') }}" class="h-12" alt="icon google for login">
                <span>Login With Google</span>
            </a>
        </div>

    </div>
@endsection

@section('js')
@endsection
