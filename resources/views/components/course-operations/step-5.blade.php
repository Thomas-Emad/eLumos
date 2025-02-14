<form action="{{ route('dashboard.instructor.courses.update', ['course' => $course->id]) }}" method="POST">
    @csrf
    @method('PATCH')
    @php
        $message = json_decode($course->message);
    @endphp
    <input type="hidden" name="step" value="{{ request()->input('step') }}">
    <div class="mb-2">
        <p class="text-sm text-gray-500 dark:text-gray-100 ">Would you prefer to inform the buyer by any
            message after
            completing the course?</p>
        <x-textarea name='message-before-start' placeholder='Message after purchasing the course'
            label='Message after purchasing the course?!..'>{{ old('message-before-start', isset($course) ? $message->before_start ?? '' : '') }}</x-textarea>
    </div>
    <div class="mb-1">
        <p class="text-sm text-gray-500 dark:text-gray-100 ">Are there any requirements to attend this
            course?!..</p>
        <x-textarea name='message-complete' placeholder='Message after completing the course...'
            label='Message after completing the course?!..'>{{ old('message-complete', isset($course) ? $message->complete ?? '' : '') }}</x-textarea>
    </div>
    <button type="submit"
        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
        Changes</button>
</form>
