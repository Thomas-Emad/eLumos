@props(['typeQuestion', 'questionId' => '', 'answers' => ''])
<input type="text" name="questions[{{ $questionId }}][typeQuestion]" value="{{ $typeQuestion }}" class="hidden peer">
@if (in_array($typeQuestion, ['radio', 'checkbox']))
    <ul class="w-full flex flex-col gap-4">
        <h3 class="mb-2 text-sm font-medium text-gray-900 dark:text-white">
            This Question is:
            {{ $typeQuestion == 'checkbox' ? 'Multi choice' : 'Single Choice' }}
        </h3>
        @foreach ($answers as $answer)
            <li>
                <input type="{{ $typeQuestion }}" name="questions[{{ $questionId }}][answers][]"
                    id="{{ $answer->id }}-option" value="{{ $answer->id }}" class="hidden peer">

                <label for="{{ $answer->id }}-option"
                    class="inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="block">

                        <div class="w-full font-semibold">{{ $answer->answer }}</div>

                    </div>
                </label>
            </li>
        @endforeach
    </ul>
@elseif ($typeQuestion === 'text')
    <x-textarea name='questions[{{ $questionId }}][answers][]'
        placeholder="Please write your answer here, so that the corrector can review it." label='Your Answer' />
@elseif ($typeQuestion === 'attachment')
    <x-file name='questions[{{ $questionId }}][answers][]' label=''></x-file>
@endif
