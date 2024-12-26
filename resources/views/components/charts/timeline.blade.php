@props(['title' => ''])
<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <h2 class="font-bold text-lg mb-2">- {{ $title }}</h2>
    <ol class="relative border-s border-gray-200 dark:border-gray-700">
        {{ $slot }}
    </ol>
</div>
