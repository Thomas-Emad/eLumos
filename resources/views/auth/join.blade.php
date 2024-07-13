@extends('layouts.app')
@section('title', 'Joing')

@section('css')
@endsection

@section('content')
    <div class="p-4 w-11/12 md:w-2/3  rounded-xl border border-gray-200 my-20 mt-28 mx-auto ">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="logs" data-tabs-toggle="#logs"
            role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2  rounded-t-lg " id="login-tab" data-tabs-target="#login"
                    type="button" role="tab" aria-controls="login" aria-selected="false">Login</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="register-tab" data-tabs-target="#register" type="button" role="tab" aria-controls="register"
                    aria-selected="false">Register</button>
            </li>

        </ul>
        <div id="logs">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="login" role="tabpanel"
                aria-labelledby="login-tab">
                <h1 class="font-bold text-2xl mb-2">Login</h1>
                <form>
                    <div class="mb-4">
                        <label for="email-login" class="block text-sm font-medium text-gray-900 dark:text-white">
                            Your Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <i class="fa-solid fa-envelope text-gray-500"></i>
                            </div>
                            <input type="text" id="email-login"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full ps-10 p-2.5  dark:bg-amber-700 dark:border-amber-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500"
                                placeholder="name@flowbite.com">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password-login" class="block text-sm font-medium text-gray-900 dark:text-white">
                            Your Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-500"></i>
                            </div>
                            <input type="text" id="password-login"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@flowbite.com">
                        </div>
                    </div>
                    <div class="flex items-center my-2">
                        <input checked id="orange-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="orange-checkbox"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                    </div>
                    <button type="submit"
                        class="w-full rounded-full p-2 text-white bg-amber-500 hover:bg-amber-700 transition ">Login</button>
                </form>
                <a href="#" class="inline-block text-sm text-gray-700 mt-2 hover:text-gray-900">Lost Your
                    password?!</a>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="register" role="tabpanel"
                aria-labelledby="register-tab">
                <h1 class="font-bold text-2xl mb-2">Register</h1>
                <form>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white">
                            Your name?!</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <i class="fa-solid fa-user text-gray-500"></i>
                            </div>
                            <input type="text" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full ps-10 p-2.5  dark:bg-amber-700 dark:border-amber-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500"
                                placeholder="name@flowbite.com">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white">
                            Your e-mail?!</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <i class="fa-solid fa-envelope text-gray-500"></i>
                            </div>
                            <input type="text" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full ps-10 p-2.5  dark:bg-amber-700 dark:border-amber-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500"
                                placeholder="name@flowbite.com">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-900 dark:text-white">Who Are
                            you?</label>
                        <select id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="US">Student</option>
                            <option value="CA">Instructor</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white">
                            Your Password?!
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-500"></i>
                            </div>
                            <input type="text" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@flowbite.com">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="block text-sm font-medium text-gray-900 dark:text-white">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <i class="fa-solid fa-circle-check text-gray-500"></i>
                            </div>
                            <input type="text" id="confirm_password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@flowbite.com">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full rounded-full p-2 text-white bg-amber-500 hover:bg-amber-700 transition ">Register</button>
                </form>
            </div>

        </div>

    </div>
@endsection

@section('js')
@endsection
