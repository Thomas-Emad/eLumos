  <!-- Switch/Toggle -->
  <div class="relative inline-block">
      <input type="checkbox" id="hs-default-switch-soft-with-icons" name="{{ $name }}" {{ $attributes }}
          class="peer relative w-[3.25rem] h-7 p-px bg-gray-100 border border-gray-200 text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-amber-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-100 checked:border-blue-200 focus:checked:border-blue-200 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-800/30 dark:checked:border-amber-800 dark:focus:ring-offset-gray-600 before:inline-block before:size-6 before:bg-white checked:before:bg-amber-600 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-amber-500">
      <label for="hs-default-switch-soft-with-icons" class="sr-only">switch</label>
      <span
          class="peer-checked:text-amber-600 text-gray-500 text-gray-500 size-6 absolute top-0.5 start-0.5 flex justify-center items-center pointer-events-none transition-colors ease-in-out duration-200 dark:text-neutral-500">
          <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
              stroke-linejoin="round">
              <path d="M18 6 6 18"></path>
              <path d="m6 6 12 12"></path>
          </svg>
      </span>
      <span
          class="peer-checked:text-white size-6 absolute top-0.5 end-0.5 flex justify-center items-center pointer-events-none transition-colors ease-in-out duration-200 dark:text-neutral-500">
          <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
              stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
      </span>
  </div>
  <!-- End Switch/Toggle -->
