@props(['user_name', 'course_title', 'completed_at', 'id', 'completed_year', 'qrCode'])
<div class="content-pdf flex items-center justify-center bg-gradient-to-r from-blue-500 to-teal-500 py-4">
    <div class="bg-white border-2 border-gray-300 shadow-xl w-[800px] p-10 rounded-lg relative">
        <!-- Top Section -->
        <div class="flex justify-between items-center mb-8">
            <!-- Logo -->
            <div>
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-24">
            </div>
            <!-- Title -->
            <div>
                <h1 class="text-3xl font-bold text-center text-gray-800 uppercase">
                    Certificate of Completion
                </h1>
            </div>
            <!-- QR Code -->
            <div>
                {!! $qrCode !!}
            </div>
        </div>

        <!-- Recipient Name -->
        <div class="text-center mb-6">
            <p class="text-gray-600 text-lg mb-2">This is to certify that</p>
            <h2 class="text-4xl font-semibold text-gray-800">{{ $user_name }}</h2>
        </div>

        <!-- Course Title -->
        <div class="text-center mb-8">
            <p class="text-gray-600 text-lg">has successfully completed</p>
            <h3 class="text-2xl font-semibold text-gray-800">{{ $course_title }}</h3>
        </div>

        <!-- Date and Signature Section -->
        <div class="flex justify-between items-center mt-10">
            <!-- Left: Date -->
            <div>
                <p class="text-gray-600">Date of Completion</p>
                <p class="font-semibold text-gray-800">{{ $completed_at }}</p>
            </div>

            <!-- Center: Badge -->
            <div class="text-center">
                <div
                    class="w-24 h-24 border-2 border-gray-300 rounded-full flex items-center justify-center mx-auto bg-gradient-to-r from-indigo-600 to-indigo-400">
                    <p class="text-white font-bold text-sm">ATTENDED<br>{{ $completed_year }}</p>
                </div>
            </div>

            <!-- Right: Signature -->
            <div class="text-right">
                <p class="text-gray-600">Authorized Signature</p>
                <p class="font-semibold text-gray-800 italic">{{ config('app.signature') }}</p>
            </div>
        </div>

        <!-- Bottom: Certificate ID -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">Certificate ID: <span class="font-semibold">{{ $id }}</span></p>
        </div>

    </div>
</div>
