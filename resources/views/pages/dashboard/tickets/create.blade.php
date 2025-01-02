@extends('layouts.app')
@section('title', 'New Request | Support')

@section('content')
    <div class="container mx-auto min-h-screen mt-20 p-2">
        <div class="p-4 rounded-xl border border-gray-200 bg-white">
            <h2 class="font-bold text-2xl">
                Add New Request To Support
            </h2>
        </div>
        <form action="{{ route('dashboard.tickets.store') }}" method="POST" enctype="multipart/form-data"
            class='text-gray-600 mt-2 p-4 rounded-xl border border-gray-200 bg-white relative overflow-x-auto shadow-md sm:rounded-lg'>
            @csrf
            <div>
                <h3 class='font-bold'>
                    - Can Tell Us in Short What your Problem?!
                </h3>
                <div class="flex items-center flex-col md:flex-row gap-4">
                    <div class="w-full md:w-2/3">
                        <x-input name='subject' label='subject' value="{{ old('subject') }}" />
                    </div>
                    <div class="w-full md:w-1/3">
                        <x-select name='type'>
                            <option selected>Type Request Problem</option>
                            <option value='assistant' @selected(old('type') == 'assistant')>Assistant</option>
                            <option value='payment' @selected(old('type') == 'payment')>payment</option>
                            <option value='technial_support' @selected(old('type') == 'technial_support')>Technial Support</option>
                            <option value='other' @selected(old('type') == 'other')>Other</option>
                        </x-select>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4">
                <div class="mt-2 w-full md:w-2/3">
                    <h3 class='font-bold '>
                        - Can you tell us more about your problem?
                    </h3>
                    <x-textarea class="h-80"
                        placeholder="
  - Tell us a little about, and what you were trying to do when you saw this problem?
  - Where is this problem directed?
  - Do you have any pictures or videos that show the problem in detail as it is happening to you?
              "
                        name='description' label='Description'>
                        {{ old('description') }}
                    </x-textarea>
                </div>
                <div class="mt-2 w-full md:w-1/3">

                    <x-file name="attachments[]" label='Can send Photos, Video for your Problem here..'
                        accept="video/mp4, image/png, image/jpeg, .doc, .docx, .pdf" multiple="true" />

                    <p class='text-sm'>
                        - Do you have any pictures or videos that show the problem in detail as it is happening to you?
                    </p>
                </div>
            </div>
            <button type="submit"
                class="block w-fit ml-auto mt-2 py-2 px-4 font-bold text-white bg-green-600 hover:bg-green-800 duration-200 rounded-lg">
                Submit
            </button>
        </form>
    </div>
@endsection
