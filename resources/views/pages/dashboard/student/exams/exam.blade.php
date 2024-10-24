@extends('layouts.app')

@section('title', 'Exam Now')

@section('content')
    <div class="min-h-screen container mx-auto px-4 mt-24 ">
        <div class="flex gap-4 justify-between items-center mb-4">
            <span></span>
            <h2 class="font-bold text-2xl  text-center">{{ $session->exam->title }}</h2>
            <span>{{ $session->exam->duration }}</span>
        </div>
        <x-stepper>
            <x-slot name='steps'>
                @foreach ($session->exam->questions as $key => $question)
                    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                        data-hs-stepper-nav-item='{"index": {{ $key + 1 }}}'>
                        <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                            <span
                                class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600">
                                <span
                                    class="hs-stepper-success:hidden hs-stepper-completed:hidden">{{ $key + 1 }}</span>
                                <svg class="hidden shrink-0 size-3 hs-stepper-success:block"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </span>
                            <span class="ms-2 text-sm font-medium text-gray-800">
                                {{ $question->title }}
                            </span>
                        </span>
                        <div
                            class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600">
                        </div>
                    </li>
                @endforeach
            </x-slot>
            <x-slot name='content'>
                <form action="{{ route('dashboard.student.exams.update', $session->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    @foreach ($errors->all() as $item)
                        {{ $item }}
                    @endforeach

                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    @foreach ($session->exam->questions as $key => $question)
                        <!--  Content -->
                        <div data-hs-stepper-content-item='{"index": {{ $key + 1 }}}'
                            class="{{ $loop->first ? 'active' : 'none' }}">
                            <div class="p-4 min-h-80 bg-gray-50 border border-dashed border-gray-200 rounded-xl">
                                <h3 class="text-gray-900 font-bold">{{ $key + 1 }}- {{ $question->title }}</h3>
                                <x-exams.answers-solve :typeQuestion="$question->type_question" :questionId="$question->id" :answers="$question->answers" />

                            </div>
                        </div>
                        <!-- End  Content -->
                    @endforeach
                    <!-- Final Content -->
                    <div data-hs-stepper-content-item='{"isFinal": true}' style="display: none;">
                        <div
                            class="p-4 min-h-80 bg-gray-50 flex flex-col items-center justify-between border border-dashed border-gray-200 rounded-xl">
                            <div class="text-center">
                                <h3 class="text-gray-800 text-lg font-bold">
                                    Congratulations, you have finished the exam but you must click submit in order for it to
                                    be
                                    submitted successfully.
                                </h3>
                                <p class="text-sm text-gray-600">
                                    The exam is not considered completed until you click submit.
                                </p>
                            </div>
                            <button type="submit"
                                class=" text-white font-bold py-2 px-8 bg-green-700 hover:bg-green-900 duration-300 mt-4 rounded-lg">
                                Submit Your Solve
                            </button>
                        </div>
                    </div>
                    <!-- End Final Content -->
                </form>
            </x-slot>
        </x-stepper>
    </div>
@endsection
