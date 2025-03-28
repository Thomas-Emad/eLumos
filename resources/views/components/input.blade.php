@props(['name' => '', 'type' => 'text', 'label' => '', 'value' => '', 'disabled' => false, 'padding' => 'p-4'])

<div class="relative mt-2">
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}"
        {{ $attributes->merge([
            'class' =>
                'peer ' .
                $padding .
                ' block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-amber-500 focus:ring-amber-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-amber-700 dark:text-neutral-400 dark:focus:ring-neutral-600 focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 autofill:pt-6 autofill:pb-2',
        ]) }}
        placeholder=" " @disabled($disabled) />

    <label for="{{ $name }}"
        class="absolute top-0 start-0 {{ $padding }} h-full text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none peer-focus:text-xs peer-focus:-translate-y-1.5 peer-focus:text-gray-500 dark:peer-focus:text-neutral-500 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500 dark:peer-[:not(:placeholder-shown)]:text-neutral-500 ">
        {{ $label }}
    </label>

    @error($name)
        <span class="block text-red-700 text-sm font-bold mt-1">- {{ $message }}</span>
    @enderror
</div>
