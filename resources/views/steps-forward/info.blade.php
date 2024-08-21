<form action="{{ route('steps-forward.save') }}" method="post">
    @csrf
    <input type="hidden" name="step" value="info">
    <x-textarea name='description' placeholder='The course description can be written here..' nameInput='Description'
        value=''>
    </x-textarea>
    <p class="text-sm text-gray-500 dark:text-gray-100 ">- Your description should be between 3 characters and 2000
        characters maximum.</p>

    <button type="submit"
        class="block ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl mt-2">Save</button>
</form>
