@props([
    'idChart' => '',
    'title' => '',
    'topNumber' => '0',
    'present' => '0%',
    'descHead' => '',
    'description' => '',
])

<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="flex justify-between mb-3">
        <div class="flex justify-center items-center">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">{{ $title }}</h5>
            <svg data-popover-target="chart-info" data-popover-placement="bottom"
                class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z" />
            </svg>
            <div data-popover id="chart-info" role="tooltip"
                class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                <div class="p-3 space-y-2">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $descHead }}</h3>
                    <p>{{ $description }}</p>

                </div>
                <div data-popper-arrow></div>
            </div>
        </div>
    </div>

    <div>
        <div class="flex" id="devices">
            <div class="flex items-center me-4">
                <input id="desktop" type="checkbox" value="desktop"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="desktop" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Desktop</label>
            </div>
            <div class="flex items-center me-4">
                <input id="tablet" type="checkbox" value="tablet"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="tablet" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tablet</label>
            </div>
            <div class="flex items-center me-4">
                <input id="mobile" type="checkbox" value="mobile"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="mobile" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mobile</label>
            </div>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="py-6" id="{{ $idChart }}"></div>
</div>
