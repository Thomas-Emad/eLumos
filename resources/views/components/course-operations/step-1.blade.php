<form
    action="{{ isset($course) ? route('dashboard.instructor.courses.update', ['course' => $course->id]) : route('dashboard.instructor.courses.store') }}"
    method="POST">
    @csrf

    @if (isset($course))
        @method('PATCH')
        <input type="hidden" name="step" value="{{ request()->input('step') }}">
    @endif

    <x-input name="title" label="Title Course" value="{{ old('title', $course->title ?? '') }}"></x-input>
    <x-input name="headline" label="Headline Course" value="{{ old('headline', $course->headline ?? '') }}"></x-input>

    <x-textarea name='description' class="mt-2"
        label='Description'>{{ old('description', $course->description ?? '') }}</x-textarea>

    <div class="mt-2">
        <x-select-search name='language' placeholder='Choose Lang Your Course' placeholderSearch='Select lang...'>
            @if ((isset($course) && request()->input('step') == '1') || empty(request()->input('step')))
                @foreach (\App\Models\Language::all() as $lang)
                    <option @selected(old('language', $course->language_id ?? '') == $lang->id) value="{{ $lang->id }}"
                        data-hs-select-option='{
                        "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ $lang->img }}\" alt=\"{{ $lang->name }}\" />"}'>
                        {{ $lang->name }}
                    </option>
                @endforeach
            @endif
        </x-select-search>
    </div>
    <div class="mt-2">
        @php
            $tags = \App\Models\Tag::select('id', 'name')->get();
        @endphp
        <x-select-search name='category' placeholder='Select Category Your course'
            placeholderSearch="Search About Course's Category..">
            @foreach ($tags as $item)
                <option value="{{ $item->id }}" @selected(old('category', isset($course) ? $course->category_id : ''))>
                    {{ $item->name }}
                </option>
            @endforeach
        </x-select-search>
    </div>
    <div class="mt-2">
        <x-multi-select name='tags[]' placeholder='Select OR Write Your Tags'>
            @foreach ($tags as $item)
                <option value="{{ $item->id }}" @selected(in_array($item->id, old('tags', isset($course) ? $course->tags->pluck('id')->toArray() : [])))>
                    {{ $item->name }}
                </option>
            @endforeach
        </x-multi-select>
        <p class="text-sm text-gray-500">- This helps you appear in searches only, and does not appear to
            the student. (Between 1 to 5 tags Allow)</p>
    </div>
    <button type="submit"
        class="block mt-2 ml-auto font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">Save
        Changes</button>
</form>
