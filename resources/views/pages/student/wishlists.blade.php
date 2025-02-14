@extends('layouts.dashboard')
@section('title', 'Wishlist')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
        <h2 class="font-bold text-xl mb-2 border-b border-gray-200 pb-2">Courses in Wishlist</h2>
        <div
            class="courses grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4 mt-2 text-gray-800 dark:text-gray-100">
            @foreach ($wishlists as $item)
                <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
                    <a href="{{ route('course-details', $item->course_id) }}" class="block rounded-xl overflow-hidden">
                        <img src="{{ $item->mockup }}"
                            onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                            class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                    </a>
                    <div class="py-2 flex justify-between gap-2 items-center">
                        <div class="flex gap-2">
                            <img src="{{ Storage::url($item->course->user->photo) }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/user-1.png') }}';"
                                class="w-10 h-10 rounded-full" alt="photo Instructor">
                            <div>
                                <h3 class=" font-bold hover:text-amber-600 duration-200">
                                    <a href="{{ route('dashboard.profile', $item->course->user->username) }}">Thomas E.</a>
                                </h3>
                                <span class="text-sm">{{ $item->course->user->headline }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between gap-2 items-center">
                        <a href="{{ route('course-details', $item->course_id) }}"
                            class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                            {{ $item->course->title }}
                        </a>
                        <p class="text-green-700 font-bold">{{ $item->course->price }}$</p>
                    </div>
                    <hr>
                    <div class="text-sm p-2 flex justify-between items-center gap-2  text-gray-800  dark:text-gray-200">

                        <a href="#"
                            class="block  font-bold text-sm text-center py-1 px-2 rounded-full border border-amber-600 text-amber-600 hover:bg-amber-600 hover:text-white duration-300">Add
                            To Cart</a>
                        <form action="{{ route('wishlist.controll', $item->course->id) }}" method='POST'>
                            @csrf
                            <button type="submit" name="type" value="remove">
                                <i
                                    class="fa-solid fa-heart text-lg  text-amber-400 hover:text-gray-300 duration-200 px-2 py-1 rounded-xl border border-amber-400"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($wishlists->count() === 0)
            <div class="message text-center font-bold text-xl italic text-gray-500">
                Your wishlist is empty
            </div>
        @endif
        <div class="pagination mt-4 flex justify-end">
            {{ $wishlists->links() }}
        </div>
    </div>
@endsection
