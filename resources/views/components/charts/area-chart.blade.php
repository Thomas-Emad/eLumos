@props(['idChart' => '', 'title' => '', 'topNumber' => '0'])
<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="flex justify-between">
        <div>
            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">{{ $topNumber }}</h5>
            <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $title }}</p>
        </div>

    </div>
    <div id="{{ $idChart }}"></div>
</div>
