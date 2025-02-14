@if (isset($course) && $course->steps < 6)
    <p class="bg-gray-900/40 text-white font-bold py-2 px-4 text-center rounded-xl">
        You should end from prev steps before publish your course
    </p>
@endif
<form action="{{ route('dashboard.instructor.courses.update', ['course' => $course->id]) }}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="step" value="{{ request()->input('step') }}">
    <x-input name='price' type="number" label='Price Course' value="{{ old('price', $course->price ?? '') }}"
        step='0.01'></x-input>
    @if (isset($course) && $course->steps == 6)
        <button type="submit"
            class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Send
            Course To Preview</button>
    @endif

</form>
