@extends('layouts.dashboard')
@section('title', 'courses list')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700">
        <h2 class="font-bold text-xl mb-2 border-b border-gray-200 pb-2">Enrolled Courses</h2>

        <nav class="flex gap-x-2">
            <button type="button"
                class="tab-courses py-2 px-4 rounded-xl text-white bg-amber-500 hs-tab-active:bg-amber-700 active"
                data-type-courses='all'>
                Enrolled Courses ({{ $countCourses['all'] }})
            </button>
            <button type="button" class="tab-courses py-2 px-4 rounded-xl text-white bg-amber-500 hs-tab-active:bg-amber-700"
                data-type-courses='active'>
                Active Courses ({{ $countCourses['active'] }})
            </button>
            <button type="button"
                class="tab-courses py-2 px-4 rounded-xl text-white bg-amber-500 hs-tab-active:bg-amber-700"
                data-type-courses='completed'>
                Complated Courses ({{ $countCourses['completed'] }})
            </button>
        </nav>

        <div class="mt-3 p-4">
            {{-- Loader --}}
            <div class="loader-courses flex justify-center" role="status">
                <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-400"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>

            {{-- Content Course --}}
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Get Courses as all by default Tab
            let typeCourses = 'all';
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

            // get Courses as all
            function getCoursesByType(typeCourses, pageCourses = pageCourses) {
                // Show Loader, initialize courses and message content
                $('.loader-courses').removeClass('hidden');
                $(`.courses`).empty();
                $(`.message`).empty();
                $('.pagination').empty();

                $.ajax({
                    url: `{{ route('dashboard.courses-list.show') }}?type=${typeCourses}&page=${pageCourses}`,
                    type: 'GET',
                    success: function(response) {
                        buildCoursesHTML(response, typeCourses);
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
            function buildCoursesHTML(response, typeCourses) {
                if (response.count > 0) {
                    response.courses.map((course) => {
                        $(`.courses`).append(`
                          <div class="p-2 bg-white dark:bg-gray-600 border border-gray-200 rounded-xl">
                              <a href="{{ route('course-details') }}/${course.data.id}" class="block rounded-xl overflow-hidden">
                                  <img src="${course.data.mockup}" onerror='this.onerror=null;this.src="{{ asset('assets/images/course.png') }}"'
                                      class="w-full h-[150px] hover:scale-125 duration-300" alt="photo course">
                              </a>
                              <div class="py-2 flex justify-between gap-2 items-center">
                                  <div class="flex gap-2">
                                      <img src="${course.user.photo}" onerror='this.onerror=null;this.src="{{ asset('assets/images/user-1.png') }}"' class="w-10 h-10 rounded-full"
                                          alt="photo Instructor">
                                      <div>
                                          <h3 class=" font-bold hover:text-amber-600 duration-200">
                                            <a href="{{ route('dashboard.profile') }}/${course.user.id}">
                                              ${course.user.name}    
                                            </a>
                                          </h3>
                                          <span class="text-sm">${course.user.headline}</span>
                                      </div>
                                  </div>
                                  <a href="#" class='text-sm text-white font-bold bg-amber-500 p-2 rounded-lg'>
                                    Play  
                                  </a>
                              </div>
                              <a href="{{ route('course-details') }}/${course.data.id}"
                                  class="block pb-2 text-xl font-bold hover:text-amber-600 duration-200">
                                  ${course.data.title}
                              </a>
                              <hr>
                              <div class="text-sm py-2 flex justify-between gap-2">
                                  <div>
                                      <i class="fa-solid fa-star text-amber-400"></i>
                                      <i class="fa-solid fa-star text-amber-400"></i>
                                      <i class="fa-solid fa-star text-amber-400"></i>
                                      <i class="fa-solid fa-star text-amber-400"></i>
                                      <i class="fa-solid fa-star text-gray-400"></i>
                                      <span>4.0 (15)</span>
                                  </div>
                                  <div class="font-bold">
                                    ${course.data.progress}%
                                  </div>
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
                    }
                } else {
                    $(`.message`).append(`
                  <p>You Dosen't Have Any Course</p>
              `);
                }
            }
        })
    </script>
@endsection
