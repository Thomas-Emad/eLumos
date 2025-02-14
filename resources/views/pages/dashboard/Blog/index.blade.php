@extends('layouts.dashboard')
@section('title', 'Control Articles')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl">
        <div class="grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-4">
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Articles</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">
                    {{ $statistics->count_articles }}
                </p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Views</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">
                    {{ $statistics->views_articles }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Likes</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">
                    {{ $statistics->likes_articles }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Comments</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">
                    {{ $statistics->count_comments }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl ">
                <p class="text-gray-700 dark:text-gray-400 text-xl">Removed Articles</p>
                <p class="font-bold text-gray-900 text-4xl mt-2 dark:text-white">
                    {{ $statistics->count_removed_articles }}</p>
            </div>
        </div>
        @can('instructors-control-courses')
            <hr class="my-4">
            <h2 class="font-bold text-gray-800 dark:text-gray-200 text-2xl my-4">Recently Created Courses</h2>
            <div class="w-full overflow-x-auto">
                <div
                    class="bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-400  text-gray-700 dark:text-gray-400  min-width-20 overflow-hidden">
                    <div class="flex justify-between gap-2 bg-gray-100 dark:bg-gray-800  p-4">
                        <span>Courses</span>
                        <div class="flex gap-4">
                            <span>Enrolled</span>
                            <span>Status</span>
                        </div>
                    </div>
                    <div>
                        @forelse ($coursesInstructor->courses as $course)
                            <div
                                class="flex justify-between items-center gap-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-400  p-4 border-b border-b-gray-200 last-of-type:border-none only-of-type:border-none">
                                <a href="{{ route('course-details', $course->id) }}"
                                    class="flex gap-2 items-center text-lg hover:text-amber-600 duration-200">
                                    <img src="{{ getParameterFromJsonOrNull($course->mockup, 'url') }}"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                                        alt="Image courses" class="w-16 h-16 rounded-lg">
                                    <h3>
                                        {{ \Str::limit($course->title, 20) }}
                                    </h3>
                                </a>
                                <div class="flex gap-4">
                                    <span>{{ $course->enrolleds_count }}</span>
                                    <span>{{ $course->status }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center font-bold italic text-gray-500 py-4">No Courses Found</d>
                        @endforelse
                    </div>
                </div>
            </div>
        @endcan

        @if (count($articles) > 1)
            <hr class="my-4">
            <h2 class="font-bold text-gray-800 dark:text-gray-200 text-2xl my-4">Top 3 Articles Viewed</h2>
            <div class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-8 mt-4 text-gray-800 dark:text-gray-200">
                @foreach ($articles as $article)
                    <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                        <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                            <img src="{{ getParameterFromJsonOrNull($article->photo, 'url') }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                                class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                        </a>
                        <div class="py-2 flex justify-between gap-2 items-center">
                            <div class="flex gap-2">
                                <img src="{{ $article->user->photo ? asset('storage/' . $article->user->photo) : asset('assets/images/user-1.png') }}"
                                    class="w-10 h-10 rounded-full" alt="photo Instructor">
                                <div>
                                    <h3 class=" font-bold hover:text-amber-600 duration-200">
                                        <a href="{{ route('dashboard.profile', $article->user->username) }}">
                                            {{ $article->user->name }}
                                        </a>
                                    </h3>
                                    <span class="text-sm">{{ $article->user->headline }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            {{ \Str::limit($article->title, 20) }}
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <hr class="my-4">
        <div class="flex justify-between items-center gap-2">
            <h2 class="font-bold text-gray-800 dark:text-gray-200 text-2xl ">Recently Articles</h2>
            <a href="{{ route('dashboard.articles.create') }}"
                class="text-sm rounded-md py-1 px-4 border-2 border-green-700 text-green-700 hover:text-white hover:bg-green-700 duration-200 font-bold">New
                Article</a>
        </div>
        <div class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-8 mt-4 text-gray-800 dark:text-gray-200">
            @foreach ($articles as $article)
                <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                    <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                        <img src="{{ getParameterFromJsonOrNull($article->photo, 'url') }}"
                            onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                            class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                    </a>
                    <div class="py-2 flex justify-between gap-2 items-center">
                        <div class="flex gap-2">
                            <img src="{{ $article->user->photo ? asset('storage/' . $article->user->photo) : asset('assets/images/user-1.png') }}"
                                class="w-10 h-10 rounded-full" alt="photo Instructor">
                            <div>
                                <h3 class=" font-bold hover:text-amber-600 duration-200">
                                    <a href="{{ route('dashboard.profile', $article->user->username) }}">
                                        {{ $article->user->name }}
                                    </a>
                                </h3>
                                <span class="text-sm">{{ $article->user->headline }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('articles.show', $article->slug) }}"
                        class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                        {{ \Str::limit($article->title, 20) }}
                    </a>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-2">
            {{ $articles->links() }}
        </div>

        @if (sizeof($articles) === 0)
            <div class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-400 rounded-xl">
                <div class="text-center font-bold italic text-gray-500 py-4">You have not any article..</div>
            </div>
        @endif
    </div>
@endsection
