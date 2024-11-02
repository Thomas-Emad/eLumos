@extends('layouts.dashboard')
@section('title', 'Exams')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
        <div class="mb-2 border-b border-gray-200 pb-2 flex justify-between items-center gap-2">
            <h2 class="font-bold text-xl flex gap-2">

                <button type="button"
                    data-modal-target='{{ $exam->students->count() > 0 ? 'cannt-change-exam-modal' : 'delete-exam-modal' }}'
                    data-modal-toggle='{{ $exam->students->count() > 0 ? 'cannt-change-exam-modal' : 'delete-exam-modal' }}'>
                    <i class="fa-solid fa-trash-can text-gray-700 hover:text-red-800 duration-300"></i>
                </button>
                <span>Exam: {{ $exam->title }}</span>
            </h2>
            <button class="py-2 px-4 text-white bg-green-700 hover:bg-green-900 rounded-lg duration-300 text-sm font-bold"
                data-modal-target='add-question-modal' data-modal-toggle='add-question-modal'>
                Add Question
            </button>
        </div>
        <div class="p-2 border-b border-gray-200 mb-2">
            <div class=" text-gray-700 flex justify-between items-center gap-2 flex-wrap text-sm">
                <div class="inline-flex justify-between items-center gap-2" title="Time Created This Exam">
                    <i class="fa-solid fa-person-chalkboard"></i>
                    {{ 'Lectures: ' . $exam->lectures->count() }}
                </div>
                <div class="inline-flex justify-between items-center gap-2" title="Time Created This Exam">
                    <i class="fa-solid fa-graduation-cap"></i>
                    {{ 'Students: ' . $exam->students->count() }}
                </div>

                <div class="inline-flex justify-between items-center gap-2" title="Time Created This Exam">
                    <i class="fa-regular fa-circle-question"></i>
                    {{ 'Questions: ' . $exam->questions->count() }}
                </div>

                <div class="inline-flex justify-between items-center gap-2" title="Time Created This Exam">
                    <i class="fa-solid fa-calendar-week font-bold"></i>
                    {{ 'Since: ' . $exam->created_at->diffForHumans() }}
                </div>
            </div>

        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Type Question
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Answers
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Created
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($exam->questions as $key=> $question)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            {{ 1 + $key }}
                        </td>
                        <th title="{{ $question->title }}" scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ \Str::limit($question->title, 15) }}
                        </th>
                        <td class="px-6 py-4">
                            {{ \Str::ucfirst($question->type_question) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $question->answers->count() }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $question->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4">
                            <button data-modal-target='preview-question-modal' data-modal-toggle='preview-question-modal'
                                data-id="{{ $question->id }}"
                                class="preview font-medium text-blue-600 dark:text-blue-500 hover:underline">Preview</button>
                        </td>
                    </tr>
                @empty
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4" colspan="6">
                            <p class="font-bold text-center italic text-gray-600">
                                it Look you not Have Any Exam?! Let's Add one for your Lectures..
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Question Modals  --}}
    <x-modal id="add-question-modal">
        <form action="{{ route('dashboard.instructor.exams.questions.store', $exam->id) }}" method="POST">
            @csrf
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <span>Add New Question for This Exam..</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="add-question-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-sm text-gray-500 dark:text-gray-100 mb-0">
                    It is preferable to write a title that expresses the purpose of the test..
                </p>
                <div class="flex gap-2 flex-col md:flex-row items-center">
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <input type="text" name="title"
                        class="w-full md:w-[70%] bg-gray-50 border border-gray-300 text-gray-900 dark:text-gray-50 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block p-2.5"
                        placeholder="Title of this Question.." required />

                    <select id="type_question" name="type_question"
                        title="We Prefer Type of Question are Checkbox or Radio.."
                        class="w-full md:w-[30%] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose a Type Question</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="radio">Radio</option>
                        <option value="text">Text</option>
                        <option value="attachment">Attachment</option>
                    </select>
                </div>
                @if (session('notification') && session('notification.type') == 'fail')
                    <p class="font-bold text-red-800 text-sm">{{ session('notification.message') }}</p>
                @endif

                {{-- Content Answers --}}
                <div class='answers'></div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Save
                </button>
                <button data-modal-hide="add-question-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-whit rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </form>
    </x-modal>
    <x-modal id="preview-question-modal">
        <form action="{{ route('dashboard.instructor.exams.questions.store', $exam->id) }}" method="POST">
            @csrf
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
                    <span>Edit in This Question..</span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="preview-question-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 content">
                {{-- Content is Here --}}

            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="preview-question-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-whit rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </form>
    </x-modal>
    <x-modal-info id="delete-exam-modal">
        <form action="{{ route('dashboard.instructor.exams.destroy', $exam->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h3 class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-100 ">
                Are you sure you want to delete this Exam?
            </h3>
            <p class="text-start text-gray-500 dark:text-gray-100 mb-5 text-sm">
                - If there is a user in the lecture who will not be deleted (Your must be removed manually first)
            </p>
            <button data-modal-hide="delete-exam-modal" type="submit"
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Yes, I'm sure
            </button>
            <button data-modal-hide="delete-exam-modal" type="button"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                cancel</button>
        </form>
    </x-modal-info>
    <x-modal-info id="cannt-change-exam-modal">

        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        <p class="text-center text-gray-500 dark:text-gray-100 mb-5 text-xl">
            <b>Sorry</b>, you cannot delete or edit this exam, because some students have already passed this exam.
        </p>
        <button data-modal-hide="cannt-delete-exam-modal" type="button"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
            Close
        </button>
    </x-modal-info>
    <x-modal-info id="delete-question-modal">
        <form action="{{ route('dashboard.instructor.exams.destroy', $exam->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h3 class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-100 ">
                Are you sure you want to delete this Exam?
            </h3>
            <p class="text-start text-gray-500 dark:text-gray-100 mb-5 text-sm">
                - If there is a user in the lecture who will not be deleted (Your must be removed manually first)
            </p>
            <button data-modal-hide="delete-exam-modal" type="submit"
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Yes, I'm sure
            </button>
            <button data-modal-hide="delete-exam-modal" type="button"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                cancel</button>
        </form>
    </x-modal-info>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Optimize Select Type Question When Change get right component
            $('#add-question-modal select[name=type_question]').on('change', function() {
                $('#answers').empty();

                if (this.value) {
                    $.ajax({
                        url: "{{ route('dashboard.instructor.exams.get-component') }}/" +
                            this.value,
                        method: 'GET',
                        success: function(data) {
                            $('#add-question-modal .answers').html(data); // Load component HTML
                        }
                    });
                }
            });

            // Preview
            $('.preview').on('click', function() {
                $('#loader').removeClass('hidden');
                let uri = "{{ route('dashboard.instructor.exams.questions.show', ':id') }}";
                $.ajax({
                    url: uri.replace(":id", $(this).attr('data-id')),
                    method: 'GET',
                }).done(function(response) {
                    $('#preview-question-modal .content').empty();
                    let answersHtml = response.answers.map(element => {
                        return `
                            <div class="flex gap-2 items-center mb-2">
                                <input type="text" value='${element.answer ?? 'Nothing..'}' disabled
                                    class="peer p-2 block w-full border-2 ${element.is_true ? 'border-green-700' : 'border-red-700'} rounded-lg text-sm disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-amber-700 dark:text-neutral-400">
                                <i class="fa-solid ${element.is_true ? 'fa-check text-green-700' : 'fa-xmark text-red-700'}  font-bold"></i>
                            </div>
                        `;
                    }).join('');

                    $('#preview-question-modal .content').append(`
                      <p class="text-lg"><span class='font-bold'>Title Question:</span>${response.question.title}</p>
                      <p><span class="font-bold">Type Question:</span> ${response.question.type_question}</p>
                      <p><span class="font-bold">Count Answers:</span> (${response.answers.length})</p>
                        @if ($exam->students->count() == 0)
                        <div class="flex justify-between gap-2 items-center text-xs">
                          <p>Do you want Delete This Question?!</p>
                          <form action='{{ route('dashboard.instructor.exams.questions.destroy', 'delete') }}' method='POST'>
                            @csrf
                            @method('DELETE')
                            <input type='hidden' name='id' value='${response.question.id}'>
                            <button type='submit' 
                              data-modal-hide="preview-question-modal"
                                class=" text-white font-bold bg-red-800 hover:bg-red-900 duration-300 py-2 px-4 rounded-md">
                                Delete
                            </button>  
                          </form>
                      </div>
                        @endif
                      <hr class="my-2">
                      <h3 class="font-bold text-lg mb-2">Your Answers:</h3>
                      ${answersHtml}
                    `);
                    $('#loader').addClass('hidden');
                })
            });
        })
    </script>
@endsection
