@extends('layouts.dashboard')
@section('title', 'Profile')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl p-4 rounded-xl border border-gray-200 bg-white">
        <h2 class="font-bold text-xl mb-2 border-b border-gray-200 pb-2">My Profile</h2>
        <div class="flex flex-col md:flex-row gap-4 text-gray-800 dark:text-gray-100">
            <div class="flex flex-col gap-2 w-ful md:w-1/2 ">
                <div>
                    <h3 class="font-bold">First Name</h3>
                    <p class="text-gray-700 dark:text-gray-200">Thomas</p>
                </div>
                <div>
                    <h3 class="font-bold">Registerion Date</h3>
                    <p class="text-gray-700 dark:text-gray-200">January 16, 2024, 11:15 AM</p>
                </div>
                <div>
                    <h3 class="font-bold">Email</h3>
                    <p class="text-gray-700 dark:text-gray-200">instructordemo@example.com</p>
                </div>
            </div>
            <div class="flex flex-col gap-2 w-ful md:w-1/2 ">
                <div>
                    <h3 class="font-bold">Last Name</h3>
                    <p class="text-gray-700 dark:text-gray-200">Emad</p>
                </div>
                <div>
                    <h3 class="font-bold">User Name</h3>
                    <p class="text-gray-700 dark:text-gray-200">thomas-emad</p>
                </div>
                <div>
                    <h3 class="font-bold">Phone Number</h3>
                    <p class="text-gray-700 dark:text-gray-200">89104-71829</p>
                </div>
            </div>

        </div>
        <div class="mt-4">
            <h3 class="font-bold text-gray-800 dark:text-gray-100">Bio</h3>
            <p class="text-sm text-gray-700 dark:text-gray-200">
                Very well thought out and articulate communication. Clear milestones, deadlines and fast work. Patience.
                Infinite patience. No shortcuts. Even if the client is being careless. Some quick example text to build on
                the
                card title and bulk the card's content Moltin gives you platform. As a highly skilled and successfull
                product
                development and design specialist with more than 4 Years of My experience lies in successfully
                conceptualizing,
                designing, and modifying consumer products specific to interior design and home furnishings.
            </p>
        </div>
    </div>
@endsection
