@extends('layouts.dashboard')
@section('title', 'My Courses')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
        <h2 class="font-bold text-xl mb-2 border-b border-gray-200 pb-2">Enrolled Courses</h2>
        <nav class="flex gap-x-2">
            <button type="button"
                class="tab-courses py-2 px-4 rounded-xl text-white bg-amber-500 hs-tab-active:bg-amber-700 active"
                data-type-courses='published'>
                Published ({{ $countCourses['published'] }})
            </button>
            <button type="button" class="tab-courses py-2 px-4 rounded-xl text-white bg-amber-500 hs-tab-active:bg-amber-700"
                data-type-courses='pending'>
                Pending ({{ $countCourses['pending'] }})
            </button>
            <button type="button"
                class="tab-courses py-2 px-4 rounded-xl text-white bg-amber-500 hs-tab-active:bg-amber-700"
                data-type-courses='draft'>
                Draft ({{ $countCourses['draft'] }})
            </button>
        </nav>

        <div class="mt-3 p-4">
            <x-loader classCall="loader-courses" />

            <div>
                <div
                    class="courses grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-4 mt-2 text-gray-800 dark:text-gray-100">

                </div>
                <div class="message text-center font-bold text-xl italic text-gray-500"></div>
            </div>


            <div class="pagination mt-4 flex justify-end">

            </div>

        </div>
    </div>

    <x-modal-info id="delete-course-modal">
        <form action="{{ route('dashboard.instructor.courses.destroy', 'destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <p class="text-gray-800 text-center">Do you sure?! want delete this Course (<span class="title"></span>)</p>

            <input type="hidden" name="id">
            <div class="flex gap-2 justify-between items-center my-2">
                <button data-modal-hide="delete-course-modal" type="submit"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, I'm sure
                </button>
                <button data-modal-hide="delete-course-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                    cancel</button>
            </div>
        </form>
    </x-modal-info>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Get Courses as published by default Tab
            let typeCourses = 'published';
            let pageCourses = 1;
            getCoursesByType(typeCourses, pageCourses);

            // Get Courses when open tab by his type
            $('.tab-courses').each(function() {
                $(this).on('click', function() {
                    var typeTab = $(this).data('type-courses');
                    if (typeTab !== typeCourses) {
                        pageCourses = 1;
                        typeCourses = typeTab;
                        getCoursesByType(typeCourses, pageCourses);
                    }
                })
            })

            // get Courses as published
            function getCoursesByType(typeCourses, pageCourses = pageCourses) {
                // Show Loader, initialize courses and message content
                $('.loader-courses').removeClass('hidden');
                $(`.courses`).empty();
                $(`.message`).empty();
                $('.pagination').empty();

                $.ajax({
                    url: `{{ route('dashboard.api.instructor.courses.show') }}?type=${typeCourses}&page=${pageCourses}`,
                    type: 'GET',
                    success: function(response) {
                        buildCoursesHTML(response);
                        $('.loader-courses').addClass('hidden');
                    }
                });
            }

            // Get Courses when click on pagination
            function changePageCourses() {
                $('.link-pagination').each(function() {
                    $(this).on('click', function() {
                        if ($(this).hasClass('disabled')) return false;
                        var pageCourses = $(this).data('page');
                        getCoursesByType(typeCourses, pageCourses);
                    })
                })
            }

            // Display Courses
            function buildCoursesHTML(response) {
                if (response.count > 0) {
                    response.courses.map((course) => {
                        let editRoute = `{{ route('dashboard.instructor.courses.edit', ':id') }}`
                            .replace(':id', course.data.id);
                        let statisticsRoute = `{{ route('dashboard.instructor.courses.tracking', ':id') }}`
                            .replace(':id', course.data.id);

                        $(`.courses`).append(`
                            <div class="p-2 bg-white dark:bg-gray-600  border border-gray-200 rounded-xl">
                                <a href="{{ route('course-details') }}" class="block rounded-xl overflow-hidden">
                                    <img src="${course.data.mockup ? `${course.data.mockup}` : `{{ asset('assets/images/course.png') }}` }"
                                        class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                                </a>
                                <div class="py-2 flex justify-between gap-2 items-center">
                                    <div class="flex gap-2">
                                        <img src="${course.user.photo ? `{{ asset('storage/${course.user.photo}') }}` : `{{ asset('assets/images/user-1.png') }}` }" class="w-10 h-10 rounded-full"
                                            alt="photo Instructor">
                                        <div>
                                            <h3 class=" font-bold hover:text-amber-600 duration-200">
                                                <a href="{{ route('dashboard.profile') }}/${course.user.username}">Thomas E.</a>
                                            </h3>
                                            <span class="text-sm">${course.user.headline}</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('course-details') }}/${course.data.id}"
                                    class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                                    ${course.data.title}
                                </a>
                                <hr>
                                <div class="text-sm p-2 flex justify-between gap-2  text-gray-800  dark:text-gray-200">
                                    ${course.data.status == 'active' ? `
                                            <a href='${statisticsRoute}' class="flex items-center gap-2 hover:text-amber-600 duration-300">
                                                <i class="fa-solid fa-chart-line"></i><span>Statistics</span>
                                            </a>
                                        ` : `
                                          <a href='${editRoute}' class="flex  items-center gap-2 hover:text-amber-600 duration-300">
                                              <i class="fa-solid fa-pen-to-square"></i><span>Edit</span>
                                          </a>
                                          <a data-id="${course.data.id}" data-title="${course.data.title}" data-modal-target="delete-course-modal" data-modal-toggle="delete-course-modal" class="deleteCourse flex  items-center gap-2 hover:text-amber-600 duration-300 cursor-pointer">
                                              <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                                          </a>
                                        `}
                                </div>
                            </div>
                        `)
                    })
                    if (response.count > 0) {
                        $('.pagination').append(`
                            <nav aria-label="Page navigation example">
                              <ul class="inline-flex -space-x-px text-base h-10">
                              <!-- prettier-ignore-start -->
                                <li>
                                  <a data-page="${response.pagination.current_page - 1}"  class="${response.pagination.current_page > 1 ? 'cursor-pointer' : 'disabled'}  link-pagination flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                                </li>
                                ${Array.from({ length: response.pagination.last_page }, (_, i) => `
                                  <li>
                                    <a data-page="${i + 1}" class="link-pagination flex items-center justify-center px-4 h-10 border border-gray-300 dark:border-gray-700 dark:text-white ${response.pagination.current_page == (i+1) ? 'disabled text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-white' : 'cursor-pointer leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700'}">
                                      ${i + 1}
                                    </a>
                                  </li>
                                `).join('')}
                                  <li>
                                    <a data-page="${response.pagination.current_page + 1}"  class="${response.pagination.last_page > response.pagination.current_page ? 'cursor-pointer' : 'disabled'} link-pagination flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                                  </li>
                              <!-- prettier-ignore-end -->
                              </ul>
                            </nav>
                          `);
                        changePageCourses();
                        initFlowbite();

                        customizeDeleteCourse();
                    }
                } else {
                    $(`.message`).append(`
                        <p>You Dosen't Have Any Course</p>
                    `);
                }
            }

            // Destroy Course
            function customizeDeleteCourse() {
                $(".deleteCourse").on('click', function() {
                    let id = $(this).attr('data-id');
                    let title = $(this).attr('data-title');

                    $("#delete-course-modal input[name=id]").val(id);
                    $("#delete-course-modal .title").text(title);
                })
            };
        })
    </script>
@endsection
