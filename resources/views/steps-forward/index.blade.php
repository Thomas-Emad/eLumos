@extends('layouts.app')
@section('title', 'Steps Forward')

@section('content')
    <div class="container mx-auto max-w-screen-xl p-4">
        <div
            class="w-11/12 md:w-2/3  rounded-xl bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-200/25 p-2 mt-20  mx-auto">
            @if (Auth::user()->steps_forward == 'new')
                <h2 class="font-bold text-2xl text-center text-amber-600">Just one step, you are all set</h2>
            @elseif (Auth::user()->steps_forward == 'info')
                <h2 class="font-bold text-2xl text-center text-amber-600">Instructor, please fill in the information
                    (Optional)</h2>
            @endif
        </div>
        <div
            class="w-11/12 md:w-2/3  rounded-xl bg-white dark:bg-gray-700 border border-gray-200  dark:border-gray-200/25 p-2 my-2 mx-auto">
            @if (Auth::user()->steps_forward == 'new')
                @include('steps-forward.new')
            @elseif (Auth::user()->steps_forward == 'info')
                @include('steps-forward.info')
            @elseif (Auth::user()->steps_forward == 'complate')
                @include('steps-forward.complate')
            @endif
        </div>
    </div>

@endsection

@section('js')
@endsection
