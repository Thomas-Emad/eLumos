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
          `<p class="text-gray-500 dark:text-gray-100 text-center mt-5 italic">No Sections Found</p>`)
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
                        class="block text-sm font-bold px-4 py-2 border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 duration-300 rounded-xl">
                        Add Lecture
                      </button>
                    </div>
                  </div>
                  <div class="flex gap-4 flex-col mt-2">
                    <p class="bg-white p-2 rounded-xl text-sm text-center text-gray-500 dark:text-gray-100">You can add up to 10 lectures</p>
                  </div>
                </div>
              `);
        });
        initFlowbite();
      }
    }

    // Event delegation for dynamic elements Show info modal
    $(".sections").on("click", ".showModal", function() {
      $('.modal input[name=id]').val($(this).data("section-id"));
      $('.modal input[name=title]').val($(this).data("section-title"));
    });

    // Event delegation for dynamic elements
    $(".sections").on("click", ".changeSortOrderSection", function() {
      const sectionId = $(this).data("section-id");
      const sortOrder = $(this).data("sort-order") === "up" ? 1 : 0;
      changeSortOrderSection(sectionId, sortOrder);
    });

    // Get All Sections By api
    let sections = [];
    $.ajax({
      type: 'GET',
      url: "{{ route('dashboard.course.edit.getSections') }}",
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
        url: "{{ route('dashboard.course.edit.addSection') }}",
        data: JSON.stringify(data),
        contentType: 'application/json',
      }).done((data) => {
        sections.push(...data.section);
        displaySections(sections);
      }).fail((data) => {
        $('.notifications').append(`@include('components.notifications.fail', ['message' => '${data.responseJSON.message}'])`);
      }).always((data) => {
        $("#add-section input[name=title]").val('');
        $('#loader').addClass('hidden');
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
        url: "{{ route('dashboard.course.edit.editSection') }}",
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
        // sections.push(data.section);
        displaySections(sections);
      }).fail((data) => {
        $('.notifications').append(`@include('components.notifications.fail', ['message' => '${data.responseJSON.message}'])`);
      }).always((data) => {
        $("#edit-section input[name=title]").val('');
        $('#loader').addClass('hidden');
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
        url: "{{ route('dashboard.course.edit.deleteSection') }}",
        data: JSON.stringify(data),
        contentType: 'application/json',
      }).done((data) => {
        // Remove Setion from array sections and redisplay it again
        $("#loader").addClass('hidden');
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
        url: "{{ route('dashboard.course.edit.changeSortSection') }}",
        data: {
          _method: "PUT",
          _token: "{{ csrf_token() }}",
          section_id: id,
          course_id: "{{ $course->id ?? 0 }}",
          up: Boolean(up)
        }
      }).done((data) => {
        $("#loader").addClass('hidden');
        displaySections(data.sections);
      }).fail((data) => {
        $("#loader").addClass('hidden');
      })
    }

  });
</script>
