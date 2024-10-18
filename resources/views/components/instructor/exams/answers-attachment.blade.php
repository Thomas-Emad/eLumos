<div class="text-gray-800">
    <hr class="my-2">
    <div class="mb-2 flex gap-2 justify-between items-center">
        <h3 class="font-bold text-md">* You must correct manually with this option..</h3>
    </div>
    <div class="answers">
        <div class="flex gap-4 items-center justify-between mb-2 box" data-id='1'>
            <div class="w-full">
                <x-textarea name='answers[1]' label='Your Answer'
                    placeholder='Do you have any criteria you would like us to tell you when you check this file?! (optional)'>
                </x-textarea>
                <p class="text-sm text-gray-800 mt-1">- Do you have any criteria you would like us to tell you when you
                    check this file?!
                    (optional)</p>
            </div>
            <div class="flex gap-2 items-center justify-between">
                <input type="radio" name="where-true[]" value='1' checked class="hidden">
            </div>
        </div>
    </div>
</div>
