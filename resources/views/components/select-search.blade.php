<!-- Select -->
<select {{ $name }}
    data-hs-select='{
    "hasSearch": true,
    "searchPlaceholder": "{{ $placeholderSearch }}",
    "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 before:absolute before:inset-0 before:z-[1] dark:bg-gray-800 dark:border-amber-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
    "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-gray-800",
    "placeholder": "{{ $placeholder }}",
    "toggleTag": "<button type=\"button\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200\" data-title></span></button>",
    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-amber-500 focus:ring-amber-500 before:absolute before:inset-0 before:z-[1] dark:bg-gray-800 dark:border-amber-700 dark:text-neutral-400",
    "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-gray-800 dark:border-amber-700",
    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-gray-800 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
    "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200\" data-title></div></div></div>",
    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"flex-shrink-0 size-3.5 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
  }'
    class="hidden">
    <option value="">Choose</option>
    <option value="de"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/de.png') }}\" alt=\"German\" />"}'>
        German
    </option>
    <option value="fr"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/fr.png') }}\" alt=\"French\" />"}'>
        French
    </option>
    <option value="es"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/es.png') }}\" alt=\"Spanish\" />"}'>
        Spanish
    </option>
    <option value="it"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/it.png') }}\" alt=\"Italian\" />"}'>
        Italian
    </option>
    <option value="pt"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/pt.png') }}\" alt=\"Portuguese\" />"}'>
        Portuguese
    </option>
    <option value="el"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/gr.png') }}\" alt=\"Greek\" />"}'>
        Greek
    </option>
    <option value="ru"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('../assets/vendor/svg-country-flags/png100px/ru.png') }}\" alt=\"Russian\" />"}'>
        Russian
    </option>
    <option value="zh"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/cn.png') }}\" alt=\"Chinese\" />"}'>
        Chinese
    </option>
    <option value="ja"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/jp.png') }}\" alt=\"Japanese\" />"}'>
        Japanese
    </option>
    <option value="ko"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/kr.png') }}\" alt=\"Korean\" />"}'>
        Korean
    </option>
    <option value="tr"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/tr.png') }}\" alt=\"Turkish\" />"}'>
        Turkish
    </option>
    <option value="fa"
        data-hs-select-option='{
  "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ asset('path/to/flags/ir.png') }}\" alt=\"Persian\" />"}'>
        Persian
    </option>

</select>
<!-- End Select -->
