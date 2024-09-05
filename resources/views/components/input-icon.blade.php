<div class="mb-4" {{ $class }}>
  <label for="{{ $id }}" class="block text-sm font-medium text-gray-900 dark:text-white">
    {{ $title }}
  </label>
  <div class="relative">
    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
      {{ $slot }}
    </div>
    <input type="{{ $typeInput }}" id="{{ $id }}" name="{{ $name }}"
      value='{{ old("$name", $defValue) }}'
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-amber-600 dark:placeholder-gray-400 dark:text-white"
      placeholder="{{ $placeholder }}">
  </div>
  @error($name)
    <span class="block text-red-700 text-sm font-bold mb-1">- {{ $message }}</span>
  @enderror
</div>
