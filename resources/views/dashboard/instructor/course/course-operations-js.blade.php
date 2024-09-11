<script>
    $(document).ready(function() {
        // initialize tabs
        const tabButtons = document.querySelectorAll("[role='tab']");
        const tabContents = document.querySelectorAll("[role='tabpanel']");

        tabButtons.forEach(button => {
            button.addEventListener("click", function() {
                tabButtons.forEach(btn => btn.classList.remove(
                    "bg-gray-100", "text-gray-700", "hover:bg-gray-50"));
                this.classList.add("bg-gray-100", "text-gray-700", "hover:bg-gray-50");
                tabContents.forEach(content => content.classList.add("hidden"));
                const target = document.querySelector(this.dataset.tabsTarget);
                target.classList.remove("hidden");
            });
        });

        // Display Sections from sections array
        function displaySections(sections) {
            $(".sections").empty();
            if (sections.length == 0) {
                $(".sections").append(
                    `<p class="text-gray-500 dark:text-gray-100 text-center mt-5 italic">No Sections Found</p>`
                )
            } else {
                sections.forEach((section, index) => {
                    $(".sections").append(`
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl mb-2">
                          <div class="flex gap-2 justify-between">
                            <div class="flex gap-2 items-center">
                              <h3><b>Section ${index + 1}:</b> ${section.title}</h3>
                              <i data-section-id="${section.section_id}" data-section-title="${section.title}" class="showModal fa-solid fa-pen-to-square p-2 rounded-full hover:bg-white dark:bg-gray-800 duration-300 cursor-pointer"
                                data-modal-target="edit-section-modal" data-modal-toggle="edit-section-modal"></i>
                              <i data-section-id="${section.section_id}" class="showModal fa-solid fa-trash p-2 rounded-full hover:bg-white dark:bg-gray-800 duration-300 cursor-pointer"
                                data-modal-target="delete-section-modal" data-modal-toggle="delete-section-modal"></i>
                            </div>
                            <div class='flex gap-2 items-center'>
                              ${(index + 1) >= 1 && sections.length > (index + 1) ?
                              `<i class="changeSortOrderSection fa-solid fa-arrow-down p-2 rounded-xl hover:bg-gray-200 duration-300 cursor-pointer" data-sort-order="down" data-section-id="${section.section_id}"></i>` : ''}
                              ${(index + 1) > 1 ? `<i class="changeSortOrderSection fa-solid fa-arrow-up p-2 rounded-xl hover:bg-gray-200 duration-300 cursor-pointer" data-sort-order="up" data-section-id="${section.section_id}"></i>` : ''}
                              <button data-modal-target="add-lecture-modal" data-modal-toggle="add-lecture-modal" data-section-id="${section.section_id}" type="button"
                                class="showModal block text-sm font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">
                                Add Lecture
                              </button>
                            </div>
                          </div>
                          <div class="lectures flex gap-4 flex-col mt-2">
                            ${section.lectures.length > 0 ? displayLectures(section.lectures).outerHTML : `
                              <p class="bg-white p-2 rounded-xl text-sm text-center text-gray-500 dark:text-gray-100">You can add up to 10 lectures</p>
                            `}
                          </div>
                        </div>
                    `);
                });
                initFlowbite();
            }
        }

        // Display Lectures from lectures array
        function displayLectures(lectures) {
            if (!Array.isArray(lectures)) {
                console.error('Invalid input: lectures should be an array.');
                return;
            }

            const lectureContainer = document.createElement('div');
            lectureContainer.classList.add('flex', 'gap-4', 'flex-col', 'mt-2');

            if (lectures.length > 0) {
                lectures.forEach((lecture, index) => {
                    lectureContainer.innerHTML += `
                        <div class="px-4 py-2 bg-white dark:bg-gray-600 rounded-xl flex justify-between gap-2 items-center">
                          <div class="flex gap-2  font-bold text-gray-900 dark:text-gray-50 text-xl">
                            <div class='flex items-center gap-2  '>
                              <i class="fa-solid fa-laptop-file"></i>
                              <h4>${lecture.title}</h4>  
                            </div>
                            <div class='flex gap-2 items-center text-sm text-gray-400 dark:text-ammber-500'>
                              ${lecture.hasContent ? '<i class="fa-solid fa-book"></i>' : ''}
                              ${lecture.hasVideo ? '<i class="fa-solid fa-video"></i>' : ''}
                              ${lecture.hasExam ? '<i class="fa-solid fa-circle-exclamation"></i>' : ''}
                            </div>
                            
                          </div>
                          <div class="flex gap-4 text-gray-600">
                            <i data-lecture-id="${lecture.id}" data-lecture-content="${lecture.content}" data-lecture-title="${lecture.title}" class="showModal fa-solid fa-pen-to-square hover:text-amber-700 duration-300 cursor-pointer"
                              data-modal-target="edit-lecture-modal" data-modal-toggle="edit-lecture-modal"></i>
                            <i data-lecture-id="${lecture.id}" class="showModal fa-solid fa-trash hover:text-amber-700 duration-300 cursor-pointer"
                              data-modal-target="delete-lecture-modal" data-modal-toggle="delete-lecture-modal"></i>
                          </div>
                        </div>`;
                });
            } else {
                lectureContainer.innerHTML = `
                  <p class="bg-white p-2 rounded-xl text-sm text-center text-gray-500 dark:text-gray-100">You can add up to 10 lectures</p></p>
                `;
            }

            return lectureContainer;
        }

        // Event delegation for dynamic elements Show info modal
        $(".sections").on("click", ".showModal", function() {
            $('.modal input[name=id]').val($(this).data("section-id"));
            $('.modal input[name=title]').val($(this).data("section-title"));
        });
        $(".sections").on("click", ".lectures .showModal", async function() {
            $('.modal input[name=id]').val($(this).data("lecture-id"));
            let lectureId = $(this).data("lecture-id");

            // Get Lecture By api
            try {
                let lecture = await getLecture(lectureId);
                if (lecture.title.length > 0) {
                    $('.modal input[name=title]').val(lecture.title);
                    $('.modal textarea[name=content]').val(lecture.content);
                    // display exams lecture.exams
                } else {
                    $(" #edit-lecture-modal .close").click()
                }
            } catch (error) {
                console.error("Error fetching lecture:", error);
            }

        });

        function getLecture(lectureId) {
            return new Promise((resolve, reject) => {
                $('#loader').removeClass('hidden');
                $.ajax({
                    type: 'GET',
                    url: `{{ route('dashboard.course.lectures.show', '') }}/` + lectureId,
                    async: true,
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "GET",
                        lecture_id: lectureId,
                    },
                    contentType: 'application/json',
                }).done((response) => {
                    resolve(response); // Resolve the promise with the response
                }).fail((response) => {
                    $('.notifications').append(`@include('components.notifications.fail', [
                        'message' => 'Something is wrong, please try again',
                    ])`);
                    initializeResponse();
                    reject(response); // Reject the promise on failure
                }).always(() => {
                    $('#loader').addClass('hidden');
                });
            });
        }

        // Event delegation for dynamic elements
        $(".sections").on("click", ".changeSortOrderSection", function() {
            const sectionId = $(this).data("section-id");
            const sortOrder = $(this).data("sort-order") === "up" ? 1 : 0;
            changeSortOrderSection(sectionId, sortOrder);
        });

        // initializeResponse
        function initializeResponse() {
            $('.modal input[name=id]').val('');
            $('.modal input[name=title]').val('');
            $('#loader').addClass('hidden');
        }

        // Get All Sections By api
        let sections = [];
        $.ajax({
            type: 'GET',
            url: "{{ route('dashboard.course.sections.index') }}",
            data: {
                course_id: "{{ $course->id ?? 0 }}",
            }
        }).done((data) => {
            sections.push(...data.sections);
            displaySections(sections)
        })

        // Optimize Request add Section
        $("#add-section button[type=submit]").on('click', function(e) {
            e.preventDefault();
            $('#loader').removeClass('hidden');
            $('.notifications').empty();

            const data = {
                title: $("#add-section input[name=title]").val(),
                course_id: "{{ $course->id ?? 0 }}",
                _token: "{{ csrf_token() }}",
                _method: "POST",
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.course.sections.store') }}",
                data: JSON.stringify(data),
                contentType: 'application/json',
            }).done((data) => {
                sections.push(...data.section);
                displaySections(sections);
            }).fail((data) => {
                $('.notifications').append(`@include('components.notifications.fail', ['message' => '${data.responseJSON.message}'])`);
            }).always((data) => {
                initializeResponse();
            })
        })

        // Edit Section
        $("#edit-section").on('submit', function(e) {
            e.preventDefault();
            $('#loader').removeClass('hidden');
            $('.notifications').empty();
            const data = {
                _token: "{{ csrf_token() }}",
                _method: "PUT",
                course_id: "{{ $course->id ?? 0 }}",
                section_id: $("#edit-section input[name=id]").val(),
                title: $("#edit-section input[name=title]").val(),
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.course.sections.update', 'section') }}",
                data: JSON.stringify(data),
                contentType: 'application/json',
            }).done((data) => {
                $('.notifications').append(`@include('components.notifications.success', ['message' => '${data.message}'])`);
                sections = sections.map(section => {
                    if (section.section_id == data.section.section_id) {
                        section.title = data.section.title;
                    }
                    return section;
                })
                displaySections(sections);
            }).fail((data) => {
                $('.notifications').append(`@include('components.notifications.fail', ['message' => '${data.responseJSON.message}'])`);
            }).always((data) => {
                initializeResponse();
            })
        })

        // Delete Section
        $("#delete-section").on('submit', function(e) {
            e.preventDefault();
            $('#loader').removeClass('hidden');
            $('.notifications').empty();
            const data = {
                _token: "{{ csrf_token() }}",
                _method: "DELETE",
                course_id: "{{ $course->id ?? 0 }}",
                section_id: $("#delete-section input[name=id]").val(),
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.course.sections.destroy', 'section') }}",
                data: JSON.stringify(data),
                contentType: 'application/json',
            }).done((data) => {
                // Remove Setion from array sections and redisplay it again
                initializeResponse();
                $('.notifications').append(`@include('components.notifications.success', ['message' => '${data.message}'])`);
                sections = sections.filter(section => section.section_id != data.section_id);
                displaySections(sections);
            })
        })

        // Change Sort Order for Section, up and down
        function changeSortOrderSection(id, up) {
            $('#loader').removeClass('hidden');

            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.course.sections.changeSortSection') }}",
                data: {
                    _method: "PUT",
                    _token: "{{ csrf_token() }}",
                    section_id: id,
                    course_id: "{{ $course->id ?? 0 }}",
                    up: Boolean(up)
                }
            }).done((data) => {
                displaySections(data.sections);
            }).always((data) => {
                initializeResponse();
            })
        }

        function handleLectureFormSubmit(formId, requestType) {
            $(`#${formId}`).on('submit', function(e) {
                e.preventDefault();
                $('#loader').removeClass('hidden');
                $('.notifications').empty();

                let video = $(`#${formId} input[name=video]`)[0].files[0];
                let form = {
                    title: $(`#${formId} input[name=title]`).val(),
                    content: $(`#${formId} textarea[name=content]`).val(),
                    video: video,
                    _token: "{{ csrf_token() }}",
                    _method: requestType,
                }

                if (formId === 'add-lecture') {
                    form.section_id = $(`#${formId} input[name=id]`).val();
                } else if (formId === 'edit-lecture') {
                    form.lecture_id = $(`#${formId} input[name=id]`).val();
                }

                if ((video !== undefined && video.size <= (40 * 1024 * 1024) && video.type ===
                        'video/mp4') ||
                    video === undefined) {
                    uploadLectureRequest(form, 'update');
                } else {
                    $('.notifications').append(`@include('components.notifications.fail', [
                        'message' => 'Your Video Is Bigger Than 40MB',
                    ])`);
                    initializeResponse();
                }
            });
        }

        // Initialize form submissions
        handleLectureFormSubmit('add-lecture', 'store');
        handleLectureFormSubmit('edit-lecture', 'update');


        function uploadLectureRequest(formData, typeRequest = 'store') {
            let url = typeRequest === 'store' ?
                "{{ route('dashboard.course.lectures.store') }}" :
                "{{ route('dashboard.course.lectures.update', 'lecture') }}";

            // Send Request Save Lecture
            $.ajax({
                type: typeRequest === 'store' ? 'POST' : 'PATCH',
                url: url,
                data: JSON.stringify(formData),
                contentType: "application/json",
                processData: false,
                cache: false,
            }).done((response) => {
                $('.notifications').append(`@include('components.notifications.success', ['message' => '${response.message}'])`);

                // replace section with new one
                sections = sections.map(section => {
                    if (section.section_id == response.section.section_id) {
                        return Object.assign({}, section, response.section);
                    }
                    return section;
                })
                displaySections(sections);
            }).fail((response) => {
                let errorMessage = response.responseJSON?.message ||
                    'An error occurred. Please try again.';
                $('.notifications').append(`@include('components.notifications.fail', ['message' => '${errorMessage}'])`);
            }).always(() => {
                initializeResponse();
            })
        }


    });
</script>
