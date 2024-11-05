@section('js')
    <script>
        $(document).ready(() => {
            setTimeout(() => {
                $.ajax({
                    method: "POST",
                    url: "{{ route('course-details.reviews') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        course_id: "{{ $course->id }}",
                        instructor_id: "{{ $course->user->id }}"
                    }
                }).done((response) => {
                    window.reviews = function() {
                        return response.reviewsContent;
                    }
                    window.instructor = function() {
                        return response.instructorContent;
                    }
                    $(document).trigger('reviewsDataLoaded');
                    $(document).trigger('instructorDataLoaded');
                });
            }, 1000 * 3);
        })
    </script>

    {{-- Reviews Scripts  --}}
    <script>
        $(document).ready(() => {
            // Listen for the custom event triggered when reviews data is loaded
            $(document).on('reviewsDataLoaded', () => {
                // DisPlay content Reviews
                const response = window.reviews();
                $('.ratesProgress .content').html(displayProgress(response.ratesProgress));
                $('.reviews .content').html(displayReviews(response.reviews.content));
                $('.loading').addClass('hidden')
                initFlowbite();

                // DisPlay Reviews in Modal
                $(".reviewsModal .content").html(displayReviewsModal(response.reviews.content))
                displayPaginationReviewsModal(response.reviews.pagination)
            })
        })

        // Display content Reviews
        function displayReviews(reviews) {
            let reviewsHtml = '';
            if (reviews.length > 0) {
                const displayCount = Math.min(reviews.length, 2);

                for (let i = 0; i < displayCount; i++) {
                    let stars = ''; // Reset stars for each review

                    // Generate stars based on rating
                    for (let j = 1; j <= reviews[i].rate; j++) {
                        stars += `<i class="fa-solid fa-star text-amber-400"></i>`;
                    }
                    for (let j = 1; j <= (5 - reviews[i].rate); j++) {
                        stars += `<i class="fa-solid fa-star text-gray-400"></i>`;
                    }
                    reviewsHtml += `
                        <div class='border-b border-gray-300 pb-2  mb-4'>
                            <div class="flex justify-between items-center gap-2 border-b border-gray-200 py-2">
                                <div class="flex items-center gap-2">
                                    <img src="${reviews[i].photo}" onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';" class="w-12 h-12 rounded-full" alt="user photo">
                                    <div>
                                        <h4 class="font-bold text-xl hover:text-amber-500 duration-300">
                                            <a href="${reviews[i].profile_user}">${reviews[i].name}</a>
                                        </h4>
                                        <p class="text-sm ">${reviews[i].headline}</p>
                                    </div>
                                </div>
                                <div class="text-sm">
                                    ${stars}
                                    <span>${reviews[i].rate} Rating</span>
                                </div>
                            </div>
                            <p>
                                <q class="text-gray-800 dark:text-gray-200 text-sm italic py-2">
                                    ${reviews[i].content}
                                </q>
                            </p>  
                        </div>
                    `;
                }

                // Add "See All Reviews" button
                reviewsHtml += `
                      <button data-modal-target="reviews-modal" data-modal-toggle="reviews-modal"
                          class="w-full mt-2 px-4 py-2 text-sm font-bold text-center text-amber-600 border border-amber-600 hover:text-white hover:bg-amber-600 duration-300 rounded-full">
                          See All Reviews
                      </button>  
                  `;

            } else {
                reviewsHtml += `
                    <p class='text-center italic'>It seems no one has left a review yet.</p>
                `;
            }

            return reviewsHtml;
        }

        // Display progress Rates
        function displayProgress(ratesProgress) {
            let contentRatesArray = [];
            Object.values(ratesProgress).map((element) => {
                contentRatesArray.push(`
                    <div class="flex items-center">
                        <p class="font-medium text-black mr-0.5">${element.rate}</p>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_12042_8589)">
                                <path
                                    d="M9.10326 2.31699C9.47008 1.57374 10.5299 1.57374 10.8967 2.31699L12.7063 5.98347C12.8519 6.27862 13.1335 6.48319 13.4592 6.53051L17.5054 7.11846C18.3256 7.23765 18.6531 8.24562 18.0596 8.82416L15.1318 11.6781C14.8961 11.9079 14.7885 12.2389 14.8442 12.5632L15.5353 16.5931C15.6754 17.41 14.818 18.033 14.0844 17.6473L10.4653 15.7446C10.174 15.5915 9.82598 15.5915 9.53466 15.7446L5.91562 17.6473C5.18199 18.033 4.32456 17.41 4.46467 16.5931L5.15585 12.5632C5.21148 12.2389 5.10393 11.9079 4.86825 11.6781L1.94038 8.82416C1.34687 8.24562 1.67438 7.23765 2.4946 7.11846L6.54081 6.53051C6.86652 6.48319 7.14808 6.27862 7.29374 5.98347L9.10326 2.31699Z"
                                    fill="#FBBF24" />
                            </g>
                            <defs>
                                <clipPath id="clip0_12042_8589">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <p class="h-2 w-full xl:min-w-[278px] rounded-3xl bg-amber-50 ml-5 mr-3">
                            <span style='width:${element.progress}%;' class="h-full rounded-3xl bg-amber-400 flex"></span>
                        </p>
                        <p class="font-medium  py-[1px] text-black mr-0.5">${element.count}</p>
                    </div>
                `);
            });
            return contentRatesArray.join('');
        }

        // Display Modal
        function displayReviewsModal(reviews) {
            let reviewsHtml = '';
            if (reviews.length > 0) {
                for (let i = 0; i < reviews.length; i++) {
                    let stars = ''; // Reset stars for each review

                    // Generate stars based on rating
                    for (let j = 1; j <= reviews[i].rate; j++) {
                        stars += `<i class="fa-solid fa-star text-amber-400"></i>`;
                    }
                    for (let j = 1; j <= (5 - reviews[i].rate); j++) {
                        stars += `<i class="fa-solid fa-star text-gray-400"></i>`;
                    }
                    reviewsHtml += `
                      <div class="bg-gray-50 dark:bg-gray-600 border border-gray-100 rounded-xl p-2">
                          <div class="flex justify-between items-center gap-2 border-b border-gray-200 py-4">
                              <div class="flex items-center gap-2">
                                  <img src="${reviews[i].photo}" onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';" class="w-12 h-12 rounded-full"
                                      alt="user photo">
                                  <div>
                                      <h4 class="font-bold text-xl hover:text-amber-500 duration-300">
                                          <a href="${reviews[i].profile_user}">${reviews[i].name}</a>
                                      </h4>
                                      <p class="text-sm ">${reviews[i].headline}</p>
                                  </div>
                              </div>
                              <div class="text-sm">
                                  ${stars}
                                  <span>${reviews[i].rate} Instructor Rating</span>
                              </div>
                          </div>
                          <p class="text-sm whitespace-pre-line py-3">${reviews[i].content}</p>
                      </div>
                    `;
                }
            } else {
                reviewsHtml += `
                      <p class='text-center'>It seems no one has left a review yet.</p>
                  `;
            }

            return reviewsHtml;
        }

        function displayPaginationReviewsModal(pagination) {
            $(".reviewsModal .pagination").html(`
                  <nav aria-label="Page navigation example">
                    <ul class="inline-flex -space-x-px text-base h-10">
                    <!-- prettier-ignore-start -->
                      <li>
                        <a data-page="${pagination.current_page - 1}"  class="${pagination.current_page > 1 ? 'cursor-pointer' : 'disabled'}  link-pagination flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                      </li>
                      ${Array.from({ length: pagination.last_page }, (_, i) => `
                        <li>
                          <a data-page="${i + 1}" class="link-pagination flex items-center justify-center px-4 h-10 border border-gray-300 dark:border-gray-700 dark:text-white ${pagination.current_page == (i+1) ? 'disabled text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-white' : 'cursor-pointer leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700'}">
                            ${i + 1}
                          </a>
                        </li>
                      `).join('')}
                        <li>
                          <a data-page="${pagination.current_page + 1}"  class="${pagination.last_page > pagination.current_page ? 'cursor-pointer' : 'disabled'} link-pagination flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                        </li>
                    <!-- prettier-ignore-end -->
                    </ul>
                  </nav>
                `);
            changePageReviews();
        }

        // Get Reviews when click on pagination
        let pageReviews = 1;

        function changePageReviews() {
            $('.link-pagination').each(function() {
                $(this).on('click', function() {
                    if ($(this).hasClass('disabled')) return false;
                    var pageReviews = $(this).data('page');
                    getReviewsNewPage(pageReviews);
                })
            })
        }

        // get Reviews as published
        function getReviewsNewPage(pageReviews = pageReviews) {
            // Show Loader, initialize Review and message content
            $('.loader-courses').removeClass('hidden');
            $(`.reviewsModal .content`).empty();
            $('.reviewsModal .pagination').empty();

            $.ajax({
                url: `{{ route('api.course-details.reviews') }}/{{ $course->id }}?page=${pageReviews}`,
                type: 'GET',
                success: function(response) {
                    $(".reviewsModal .content").html(displayReviewsModal(response.content))

                    displayPaginationReviewsModal(response.pagination)

                    $('.loader-courses').addClass('hidden');
                }
            });
        }
    </script>

    {{-- Instructor Script --}}
    <script>
        $(document).ready(() => {
            // Listen for the custom event triggered when reviews data is loaded
            $(document).on('instructorDataLoaded', () => {
                // DisPlay content Reviews
                const response = window.instructor();
                $('.instructor .content').html(displayInstructorInfo(response));

            })
        })

        function displayInstructorInfo(instructor) {
            return `
              <div class="flex justify-between items-center gap-2 border-b border-gray-200 py-4">
                  <div class="flex items-center gap-2">
                      <img src="${instructor.photo}"
                          onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                          class="w-12 h-12 rounded-full" alt="user photo">
                      <div>
                          <h4 class="font-bold text-xl hover:text-amber-500 duration-300">
                              <a href="${instructor.profile_user}">${instructor.name}</a>
                          </h4>
                          <p class="text-sm ">${instructor.headline}</p>
                      </div>
                  </div>
                  <div class="text-sm">
                      <i class="fa-solid fa-star text-amber-400"></i>
                      <i class="fa-solid fa-star text-amber-400"></i>
                      <i class="fa-solid fa-star text-amber-400"></i>
                      <i class="fa-solid fa-star text-amber-400"></i>
                      <i class="fa-solid fa-star text-gray-400"></i>
                      <span>4.5 Instructor Rating</span>
                  </div>
              </div>
              <div class="flex gap-4 border-b border-gray-200 py-4 font-bold text-gray-700 dark:text-gray-200 text-sm mb-1">
                  <div>
                      <i class="fa-solid fa-play text-amber-700"></i>
                      <span>${instructor.countCourses} Courses</span>
                  </div>
                  <div>
                      <i class="fa-solid fa-calendar-check text-amber-700"></i>
                      <span>${instructor.timeLectures}</span>
                  </div>
                  <div>
                      <i class="fa-solid fa-book-open-reader text-amber-700"></i>
                      <span>${instructor.countLectures}+ Lesson</span>
                  </div>
                  <div>
                      <i class="fa-solid fa-users-rectangle text-amber-700"></i>
                      <span>${instructor.totalStudents} students enrolled</span>
                  </div>
              </div>
              <div class="text-gray-800 dark:text-gray-200 text-sm whitespace-pre-line">${instructor.description}</div>
          `;
        }
    </script>
@endsection
