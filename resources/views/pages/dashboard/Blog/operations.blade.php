@extends('layouts.app')
@section('title', 'Operation Article')

@section('content')
    <div class="container max-w-full px-4 mt-28 md:mt-24 text-gray-800">
        <h1 class="text-center my-4 text-2xl font-bold">Add New Article</h1>
        <form action="{{ route('dashboard.articles.store') }}" method="post">
            @csrf

            <div class="flex flex-col md:flex-row gap-6 justify-between">
                <div id="article" class="w-full md:w-2/3 bg-white p-4 rounded-xl shadow overflow-hidden">
                    <div class="flex justify-between gap-1 items-center mb-3">
                        <h2 class="font-bold">Your Article</h2>
                        <i data-section="article"
                            class="toggle-section text-gray-600 fa-solid fa-arrow-up py-1 px-2 bg-gray-50 rounded-sm hover:bg-gray-300 duration-200 cursor-pointer text-sm"></i>
                    </div>
                    <x-input name="title" label="Title Article" padding="p-3" value="{{ old('title') }}" />
                    <x-textarea name="content" label="Content" placeholder=" " classParent="mt-2">
                        {{ old('content') }}
                    </x-textarea>
                </div>
                <div class="w-full md:w-1/3">
                    <div id="photo" class="bg-white p-4 rounded-xl shadow overflow-hidden">
                        <div class="flex justify-between gap-1 items-center mb-3">
                            <h2 class="font-bold">Photo Article</h2>
                            <i data-section="photo"
                                class="toggle-section text-gray-600 fa-solid fa-arrow-up py-1 px-2 bg-gray-50 rounded-sm hover:bg-gray-300 duration-200 cursor-pointer text-sm"></i>
                        </div>
                        <x-file name="photo" label="PNG, JPG, JPEG" accept="image/png,image/jpg,image/jpeg" />
                        @error('photo')
                            <span class="block text-red-700 text-sm font-bold mt-1">- {{ $message }}</span>
                        @enderror
                    </div>
                    <div id="tags" class="bg-white p-4 rounded-xl shadow mt-2 overflow-hidden">
                        <div class="flex justify-between gap-1 items-center mb-2">
                            <h2 class="font-bold">Information Article</h2>
                            <i data-section="tags"
                                class="toggle-section text-gray-600 fa-solid fa-arrow-up py-1 px-2 bg-gray-50 rounded-sm hover:bg-gray-300 duration-200 cursor-pointer text-sm"></i>
                        </div>
                        <x-input name="tags" label="Write tags and split it by (,)" padding="p-3"
                            value="{{ old('tags') }}" />
                        <x-input name="slug" label="Write Slug for this Article" padding="p-3"
                            value="{{ old('slug') }}" />
                        <x-textarea name="headline" label="Headline" placeholder=" " classParent="mt-2">
                            {{ old('headline') }}
                        </x-textarea>
                    </div>
                </div>
            </div>
            <button type="submit"
                class="block py-3 px-6 text-white bg-green-700 hover:bg-green-900 duration-200 cursor-pointer rounded-lg my-4 ml-auto font-bold">
                Publish Article
            </button>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(() => {
            $('.toggle-section').on('click', function() {
                const btn = $(this);
                const section = $("#" + btn.attr('data-section'));
                btn.toggleClass('fa-arrow-down');
                btn.toggleClass('fa-arrow-up');
                section.toggleClass("h-[55px]");
            });
        });
    </script>
@endsection
