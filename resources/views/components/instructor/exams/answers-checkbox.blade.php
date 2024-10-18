<div class="text-gray-800">
    <hr class="my-2">
    <div class="mb-2 flex gap-2 justify-between items-center">
        <h3 class="font-bold text-sm">- Good choice, this will make autocorrect easier for you.</h3>
        <button type="button" id="add-new-option"
            class="text-white bg-amber-700 hover:bg-amber-800 duration-300 py-2 px-3 rounded-lg shadow-md text-xs">
            New Answer
        </button>
    </div>
    <div class="answers">
        <div class="flex gap-4 items-center justify-between mb-2 box" data-id='1'>
            <div class="w-full"><x-input name='answers[1]' required label='Write Title Question'></x-input></div>
            <div class="flex gap-2 items-center justify-between">
                <input type="checkbox" name="where-true[]" value='1' checked>
                <i data-id='1'
                    class="delete-option fa-solid fa-trash-can text-gray-700 hover:text-red-800 duration-300 cursor-pointer"></i>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Add new Option
        countOptions = 1;
        $("#add-new-option").on('click', function() {
            if (countOptions < 4) {
                countOptions++;
                $('.answers').append(`
                  <div class="flex gap-4 items-center justify-between mb-2 box" data-id='${countOptions}'>
                      <div class="w-full"><x-input name='answers[${countOptions}]' required label='Write Title Question'></x-input></div>
                      <div class="flex gap-2 items-center justify-between">
                          <input type="checkbox" name="where-true[]" value='${countOptions}'>
                          <i data-id='${countOptions}'
                              class="delete-option fa-solid fa-trash-can text-gray-700 hover:text-red-800 duration-300 cursor-pointer"></i>
                      </div>
                  </div>
                `);
            }
        });

        // Remove option
        $(".answers").on('click', '.delete-option', function() {
            let id = $(this).attr('data-id');
            console.log(id)
            $('.answers>div[data-id=' + id + ']').remove();
            countOptions--;
        });
    });
</script>
