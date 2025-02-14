<script src="{{ asset('assets/js/jquery.js') }}"></script>

{{-- Basket Code --}}
<script>
    $(".btn-cart").on("click", async function() {
        $(".cart-content").addClass("hidden");
        $(".loader-cart").removeClass("hidden");

        try {
            await triggerBasketUpdate();
            await getBasket();
        } catch (error) {
            console.error("Error updating basket:", error);
        }

        $(".cart-content").removeClass("hidden");
        $(".loader-cart").addClass("hidden");
    });

    // Click event for each individual .change-cart button
    $("body").on("click", ".change-cart", async function() {
        try {
            await setBasket($(this));
            await getBasket();
        } catch (error) {
            console.error("Error updating basket:", error);
        }
    });


    // Function to trigger clicks on all .change-cart buttons
    async function triggerBasketUpdate() {
        let buttons = $(".change-cart");
        let promises = [];

        buttons.each(function() {
            promises.push(setBasket($(this)));
        });

        return Promise.all(promises);
    }

    // Send a course to the basket
    function setBasket(courseButton) {
        return new Promise((resolve, reject) => {
            let courseId = courseButton.attr("data-id");

            $.ajax({
                    type: "POST",
                    url: "{{ route('basket.setData') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "POST",
                        id: courseId,
                    },
                })
                .done((data) => {
                    courseButton.html(data.message); // Update button text
                    resolve();
                })
                .fail((jqXHR, textStatus, errorThrown) => {
                    reject(errorThrown);
                });
        });
    }

    // Get content basket
    function getBasket() {
        return new Promise((resolve, reject) => {
            $.ajax({
                    type: "GET",
                    url: "{{ route('basket.getData') }}",
                })
                .done((data) => {
                    displayBasket(data.courses);
                    resolve();
                })
                .fail((jqXHR, textStatus, errorThrown) => {
                    reject(errorThrown);
                });
        });
    }



    function displayBasket(content) {
        $(".cart").empty(); // Clear existing items

        if (content.length !== 0) {
            content.forEach(function(element, index) {
                $(".cart").append(`
                  <div class="flex gap-4 border-b border-b-gray-200 py-2">
                    <img src="${element.image}" onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';" class="w-16 h-16 rounded-xl" alt="photo cart">
                    <div class="w-full">
                      <div class="flex justify-between mb-2">
                        <span><a href="#">${element.title}</a></span>
                        <span class="text-green-700">${element.price}$</span>
                      </div>
                      <button type="button" data-id="${element.id}" data-type='add'
                        class="change-cart inline-block text-sm py-1 px-4 w-full rounded-xl text-red-800 border border-red-800 hover:bg-red-800 hover:text-white transition duration-300 remove-item">
                        remove
                      </button>
                    </div>
                  </div>
                `);
            });
        } else {
            $(".cart").append(`
              <div class="flex gap-4 border-b border-b-gray-200 py-2">
                <p class="text-gray-400">Your cart is empty</p>
              </div>
            `);
        }
    }

    function getBasketById(ids) {
        $.ajax({
            type: 'GET',
            url: '{{ route('basket.getData') }}',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'GET',
                ids: ids
            }
        }).done((data) => {
            displayBasket(data.courses);
        })
    }
</script>

@if (Auth::check())
    <script>
        // get Notifications After Click it
        $(document).ready(() => {
            $('.sidebar-notify').on('click', function() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('notifications.api') }}',
                }).done((data) => {
                    displayNotifys(data.notifys);
                })
            });
        })

        function displayNotifys(content) {
            $(".notify").empty(); // Clear existing items

            if (content.length !== 0) {
                let notifys = '';
                content.forEach(function(element, index) {
                    notifys += `
                      <li class="mb-10 ms-6">            
                          <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                            <img class="w-6 h-6  rounded-full shadow-lg" src="{{ asset('assets/images/favicon.png') }}" alt="System Logo"/>
                          </span>
                          <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                              <time class="block mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0 text-right">${element.duration}</time>
                              <div class="text-sm font-normal text-gray-500 dark:text-gray-300"><b class='uppercase'>${element.sender}</b> ${element.message}</div>
                          </div>
                      </li>
                    `;
                });
                $(".notify").append(notifys);
                $(".badge-notify").remove();
            } else {
                $(".notify").append(`
                  <div class="flex gap-4 py-2">
                    <p class="text-gray-400 text-center">It Seem You haven't Any Notification..</p>
                  </div>
                `);
            }
        }
    </script>
@endif

@yield('js')
