@extends('layouts.app')

@section('title', 'Report Exam :' . $session->exam->title)

@section('css')

@endsection

@section('content')
    <div class="min-h-screen container mx-auto px-4 mt-24 text-gray-800">
        <div class="bg-white rounded-lg shadow-md p-4 text-center font-bold an-section an-right">
            @switch($session->status)
                @case('processing')
                    <div class="text-gray-700">
                        <i class="fa-solid fa-circle-info mr-2"></i>
                        <span> This exam is still coming, you can complete it</span>
                        <a href="{{ route('dashboard.student.exams.test', $session->id) }}"
                            class="text-blue-700 hover:underline">here</a>
                    </div>
                @break

                @case('waiting')
                    <div class="text-yellow-700">
                        <i class="fa-regular fa-circle-question mr-2"></i>
                        <span>You have to wait, not all questions have been corrected.</span>
                    </div>
                @break

                @case('sucess')
                    <div class="text-green-700">
                        <i class="fa-regular fa-circle-check mr-2"></i>
                        <span>You did well on this exam.</span>
                    </div>
                @break

                @case('failed')
                    <div class="text-red-700">
                        <i class="fa-regular fa-circle-xmark mr-2"></i>
                        <span>I did well but it wasn't enough to try again.</span>
                    </div>
                @break
            @endswitch
        </div>

        <hr class="h-0.5 w-[90%] mx-auto my-2 bg-gray-400/20">

        <div class="bg-white rounded-lg shadow-md p-4 an-section an-right">
            <div class="flex gap-4 justify-between items-center flex-col md:flex-row overflow-hidden">
                <div class="flex gap-4 flex-wrap ">
                    <img src="{{ json_decode($session->lecture->course->mockup)->url }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';" alt="photo course"
                        class="w-[200px] h-[100px] rounded-xl overflow-hidden md:mx-auto">
                    <div class="flex flex-col text-sm">
                        <h1 class="font-bold text-2xl">{{ $session->exam->title }}</h1>
                        <a href="{{ route('course-details', $session->lecture->course_id) }}">
                            <h2 class="text-lg mb-2 hover:text-amber-500 duration-200">Course Title</h2>
                        </a>
                        <p>
                            <b>Duration:</b>
                            {{ round($session->created_at->diffInMinutes($session->updated_at), 2) }}{{ !is_null($session->exam->duration) ? '/' . $session->exam->duration : '' }}
                            per minute
                        </p>
                        <p>
                            <b>Your Degree: </b><span>{{ $session->degree . '/' . $session->total_degree }}</span>
                        </p>
                    </div>
                </div>
                <div class="an-section an-left">
                    @php
                        $percentDegree = 75;
                        $colorPercentDegree = '';
                        if ($percentDegree == 0 || $percentDegree <= 25) {
                            $colorPercentDegree = 'bg-red-700';
                        } elseif ($percentDegree < 75) {
                            $colorPercentDegree = 'bg-amber-600';
                        } elseif ($percentDegree >= 75) {
                            $colorPercentDegree = 'bg-green-700';
                        }
                    @endphp
                    <div class="flex flex-col items-center gap-2">

                        <div class="relative w-24 h-20 ">
                            <div class="bg-gray-400 rounded-full w-full h-full overflow-hidden">
                                <div class="h-full {{ $colorPercentDegree }}" style="width:{{ $percentDegree }}%">
                                </div>
                                <div
                                    class="flex items-center justify-center font-bold text-xl w-[80%] h-[80%] bg-white rounded-full absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10">
                                    {{ $percentDegree . '%' }}
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('dashboard.student.exams.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="{{ 'retest' }}">
                            <input type="hidden" name="exam_id" value="{{ $session->exam_id }}">
                            <input type="hidden" name='lecture_id' value="{{ $session->lecture_id }}">
                            <button type="submit"
                                class="inline-block text-xs cursor-pointer py-1 px-2 font-bold text-white bg-green-700 hover:bg-green-900 duration-300 rounded-md">
                                Re-Test
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <hr class="h-0.5 w-[90%] mx-auto my-2 bg-gray-400/20">

        <div class="bg-white rounded-lg shadow-md p-4 an-section an-right">
            <h2 class="font-bold text-2xl">Solve Questions:</h2>
            <div>
                @foreach ($session->exam->questions as $key => $question)
                    <div class="mb-4 an-section an-bottom">
                        <div class="flex gap-2 item-center justify-between mb-2">
                            <h3 class="font-bold">Q{{ $key + 1 }}: {{ $question->title }}</h3>
                            @php
                                $countRightAnswerStudents = 0;
                            @endphp
                            @foreach ($question->answers as $item)
                                @php
                                    $countRightAnswerStudents += $item->answerStudent?->is_true == true;
                                @endphp
                            @endforeach
                            <span>{{ calcDegreeAnswer($question->answers->where('is_true', true)->count(), $countRightAnswerStudents) }}/1</span>
                        </div>
                        <div class="flex gap-2 flex-col">
                            @foreach ($question->answers as $item)
                                @if (in_array($question->type_question, ['checkbox', 'radio']))
                                    <input type="text" value="{{ $item->answer }}" disabled
                                        class="block w-full @if (!is_null($item->answerStudent) && $item->answerStudent->is_true == true) border-green-600 @elseif(!is_null($item->answerStudent)) border-red-600 @else border-gray-600 @endif rounded-lg text-sm"
                                        placeholder=" " />
                                @elseif ($question->type_question === 'text')
                                    <div class="flex items-center justify-between gap-4">
                                        <x-textarea label='Your Answer' classParent="w-1/2" disabled="true"
                                            class="
                                          @if (!is_null($item->answerStudent) && $item->answerStudent->is_true == true) border-green-600 @elseif(!is_null($item->answerStudent) && $item->answerStudent->is_true === false) border-red-600 @else border-gray-400 @endif">
                                            {{ $item->answerStudent->content }}
                                        </x-textarea>
                                        @if (!is_null($item->answerStudent->info))
                                            <x-textarea label='Right Answer' classParent="w-1/2" disabled="true">
                                                {{ $item->answerStudent->info }}
                                            </x-textarea>
                                        @endif
                                    </div>
                                @elseif ($question->type_question === 'attachment')
                                    <p class="mb-2"> Can Download Your Attachment From
                                        <a href="{{ json_decode($item->answerStudent?->content)->url }}" target="__blank"
                                            class="text-blue-700 hover:underline">here</a>
                                    </p>
                                    @if (!is_null($item->answerStudent->info))
                                        <x-textarea label='Right Answer' classParent="w-1/2" disabled="true">
                                            {{ $item->answerStudent->info }}
                                        </x-textarea>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <hr class="h-0.5 w-[90%] mx-auto my-2 bg-gray-400/20">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
