<form action="{{ route('steps-forward.save') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="step" value="new">
    <div class="flex items-center justify-center w-full">
        <label for="photo"
            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                        upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">PNG or JPG (MAX. 2MB)</p>
            </div>
            <input id="photo" type="file" class="hidden" name="photo" accept="image/png, image/jpeg" />
        </label>
    </div>
    @error('photo')
        <span class="block text-red-700 text-sm font-bold mb-1">- {{ $message }}</span>
    @enderror
    <hr class="w-10/12 m-auto my-4">

    <x-input-icon name='username' nameInput='username' id="username" title="- Unique Name"
        placeholder='You can write Unique Name' defValue='' typeInput='text' class="">
        <i class="fa-solid fa-address-card text-gray-500"></i>
    </x-input-icon>

    <div>
        <label for="tag" class="block text-sm font-medium text-gray-900 dark:text-white">- Tags</label>
        <x-tags name='tags[]' placeholder='Select OR Write Your Tags'>
            @foreach (\App\Models\Tag::all() as $tag)
                <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tags', [])))>{{ $tag->name }}</option>
            @endforeach
        </x-tags>
        @error('tags')
            <span class="block text-red-700 text-sm font-bold mb-1">- {{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="mt-4 w-full rounded-full p-2 text-white bg-amber-500 hover:bg-amber-700 transition">
        Next
    </button>
</form>
