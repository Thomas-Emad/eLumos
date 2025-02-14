@extends('layouts.app')
@section('title', 'Statistics')
@section('css')
@endsection

@section('content')
    <div class="container mx-auto min-h-screen p-4 mt-20">
        <div class='bg-white p-4 rounded-xl shadow-md flex justify-between items-center gap-2'>
            <h1 class="text-2xl font-bold">Statistics</h1>
            <a href="{{ route('dashboard.index') }}"
                class='inline-block text-green-800 hover:text-white font-bold border border-green-800 hover:bg-green-800 rounded-lg text-sm py-2 px-4 duration-200'>Dashboard</a>
        </div>
        <div class='mt-4 bg-white p-4 rounded-xl shadow-md flex justify-between gap-2'>
            <div class="flex gap-4">
                <a href="{{ route('course-details', $course->id) }}" target="__blank">
                    <img src="{{ json_decode($course->mockup)->url }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/course.png') }}';"
                        class='w-86 h-40 rounded-xl' alt="course mockup">
                </a>
                <div>
                    <a href="{{ route('course-details', $course->id) }}" target="__blank">
                        <h1 class="text-2xl font-bold hover:text-amber-600 duration-200">{{ $course->title }}</h1>
                    </a>
                    <p><b>Status: </b>{{ $course->status }}</p>
                    <p><b>Created At: </b>{{ $course->created_at->format('Y/m/d') }}</p>
                    @if ($course->preview_at)
                        <p><b>Published At: </b>{{ $course->preview_at->format('Y/m/d') }}</p>
                    @endif
                    @php
                        $averageRating = $course->average_rating;
                    @endphp
                    <div class="flex gap-1 text-sm">
                        @for ($i = 1; $i <= floor($averageRating); $i++)
                            <i class="fa-solid fa-star text-amber-500"></i>
                        @endfor

                        @if ($averageRating - floor($averageRating) >= 0.5)
                            <i class="fa-solid fa-star-half-stroke text-amber-500"></i>
                        @endif

                        @for ($i = 1; $i <= 5 - ceil($averageRating); $i++)
                            <i class="fa-solid fa-star text-gray-200"></i>
                        @endfor
                        <span class="text-sm">({{ $course->reviews_count }})</span>
                    </div>

                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p title="Total Earns from this Course"
                    class="text-gray-700 text-center text-2xl py-2 px-4 bg-gray-50 shadow rounded-lg flex items-center gap-2 cursor-pointer hover:-translate-x-2 duration-200">
                    <span class=" font-bold">{{ $profits['earns'] }}</span>
                    <i class="fa-solid fa-dollar-sign"></i>
                </p>
                <p title="Total Students Buy this Course"
                    class="text-gray-700 text-center text-2xl py-2 px-4 bg-gray-50 shadow rounded-lg flex items-center gap-2 cursor-pointer hover:-translate-x-2 duration-200">
                    <span class="font-bold"> {{ $avargetWatchs['enrolleds_count'] }}</span>
                    <i class="fa-solid fa-graduation-cap"></i>
                </p>
                <div class="flex gap-2">
                    <button type="button" data-modal-target="settings-modal" data-modal-toggle="settings-modal"
                        class="inline-block py-2 px-4 font-bold text-white bg-gray-700 hover:bg-gray-600 border border-gray-900 rounded-xl duration-200">
                        <i class="fa-solid fa-gear"></i>
                    </button>
                    @if ($avargetWatchs['enrolleds_count'] == 0)
                        <a href="{{ route('dashboard.instructor.courses.edit', $course->id) }}"
                            class="inline-block py-2 px-4 font-bold text-white bg-slate-700 hover:bg-slate-600 border border-gray-900 rounded-xl duration-200">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class='mt-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4'>
            <x-charts.area-chart idChart='area-chart' title='Avarget Countiune Course' topNumber=''>
            </x-charts.area-chart>

            <x-charts.column-chart idChart='column-chart' title='Profits This month' topNumber='' present=''
                earns="${{ $profits['earns'] }}" />

            <x-charts.timeline title="Logs Changes on Course">
                @forelse ($course->logs()->latest()->get() as $log)
                    <li class="mb-10 ms-4">
                        <div
                            class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                        </div>
                        <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                        </time>
                        <h3 class="text-md font-semibold text-gray-900 dark:text-white">
                            Changes Status Course To Be {{ $log->status }}
                        </h3>
                        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                            "{{ $log->reason }}"
                        </p>
                    </li>
                @empty
                    <p class="text-center italic font-bold text-gray-400">it Seem here is no Update on this Course..</p>
                @endforelse
            </x-charts.timeline>

            <x-charts.timeline title="Review Students on Course">
                @forelse ($course->reviews as $review)
                    <li class="mb-10 ms-4">
                        <div
                            class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                        </div>
                        <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                            {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}
                        </time>
                        <div class="flex justify-between items-center gap-2">
                            <div class='flex justify-between items-center gap-2'>
                                <img src="{{ Stroage::url($review->user->photo) }}" class='w-12 h-12 rounded-full'
                                    alt="photo user reviewer">
                                <a href="{{ route('dashboard.profile', $review->user->username) }}" target="__blank">
                                    <h3
                                        class="text-md font-semibold text-gray-900 dark:text-white hover:text-amber-500 duration-200">
                                        {{ $review->user->name }}
                                    </h3>
                                </a>
                            </div>
                            <div class="flex gap-1 text-sm">
                                @for ($i = 1; $i <= floor($review->rate); $i++)
                                    <i class="fa-solid fa-star text-amber-500"></i>
                                @endfor

                                @if ($review->rate - floor($review->rate) >= 0.5)
                                    <i class="fa-solid fa-star-half-stroke text-amber-500"></i>
                                @endif

                                @for ($i = 1; $i <= 5 - ceil($review->rate); $i++)
                                    <i class="fa-solid fa-star text-gray-200"></i>
                                @endfor
                                <span class="text-sm">({{ $review->rate }})</span>
                            </div>
                        </div>
                        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                            "{{ $review->content }}"
                        </p>
                    </li>
                @empty
                    <p class="text-center italic font-bold text-gray-400">it Seem here is no Update on this Course..</p>
                @endforelse
            </x-charts.timeline>
        </div>
    </div>

    <!-- Modal HTML -->
    <div id="settings-modal" tabindex="-1" aria-hidden="true"
        class="modal hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <span>Control Your Course</span>
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="settings-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal content -->
                <div class="modal-content p-4">
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <h1 class="text-xl font-bold text-amber-600">Change Content Course</h1>
                            <a href="@if ($avargetWatchs['enrolleds_count'] == 0) {{ route('dashboard.instructor.courses.edit', $course->id) }} @else # @endif"
                                class=" inline-block py-2 px-4 @if ($avargetWatchs['enrolleds_count'] == 0) cursor-pointer bg-amber-600 hover:bg-amber-800 @else bg-gray-600 @endif duration-200 text-white font-bold rounded-lg shadow-md">
                                Update
                            </a>
                        </div>
                        @if ($avargetWatchs['enrolleds_count'] > 0)
                            <p class="text-sm text-gray-700">* Sorry, but the course content cannot be modified after a
                                student has purchased it.</p>
                        @endif
                    </div>

                    <hr class="block my-4 w-2/3 mx-auto border border-gray-100">

                    <div class="bg-gray-100 p-4 rounded-lg flex flex-col gap-4">
                        <div class="flex justify-between items-center">
                            <h1 class="text-xl font-bold text-amber-600">Change Price Course</h1>
                            <button type="button"
                                class="price-course inline-block py-2 px-4 bg-amber-600 hover:bg-amber-800 duration-200 text-white font-bold rounded-lg shadow-md">
                                Change
                            </button>
                        </div>
                        <div class="price-settings hidden">
                            <x-input name='price' type="number" label='Price Course' value="{{ $course->price }}"
                                step='0.01'></x-input>
                            <button type="submit"
                                class="block text-white font-bold bg-green-500 rounded-lg py-2 px-4 mt-2 ms-auto hover:bg-green-700 duration-200">
                                Save
                            </button>
                        </div>
                    </div>

                    <hr class="block my-4 w-2/3 mx-auto border border-gray-100">

                    <div class="bg-gray-100 p-4 rounded-lg flex flex-col gap-4">
                        <div class="flex justify-between items-center">
                            <h1 class="text-xl font-bold text-amber-600">Settings</h1>
                            <button type="button"
                                class="status-course inline-block py-2 px-4 bg-amber-600 hover:bg-amber-800 duration-200 text-white font-bold rounded-lg shadow-md">
                                Change Settings
                            </button>
                        </div>
                        <div class="show-status hidden">
                            <form action="{{ route('dashboard.review.log.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <h2 class="font-bold text-lg mb-2">Change Status Course</h2>
                                <ul class="flex justify-center gap-4 ">
                                    @if (in_array($course->status, ['inactive', 'removed']))
                                        <li class="w-full md:w-1/2">
                                            <input type="radio" id="active-option" name="status" value="active"
                                                class="hidden peer" required="">
                                            <label for="active-option"
                                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-green-50">
                                                <div class="block">
                                                    <img class="w-12 h-12"
                                                        src="{{ asset('assets/images/icons/active.png') }}"
                                                        alt="icon student">
                                                    <div class="w-full text-lg font-semibold">Active</div>
                                                </div>
                                            </label>
                                        </li>
                                    @endif

                                    @if ($course->status == 'active')
                                        <li class="w-full md:w-1/2">
                                            <input type="radio" id="inactive-option" name="status" value="inactive"
                                                class="hidden peer">
                                            <label for="inactive-option"
                                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-red-50">
                                                <div class="block">
                                                    <img class="w-12 h-12"
                                                        src="{{ asset('assets/images/icons/inactive.png') }}"
                                                        alt="icon student">
                                                    <div class="w-full text-lg font-semibold">InActive</div>
                                                </div>
                                            </label>
                                        </li>
                                    @endif
                                    <li class="w-full md:w-1/2">
                                        <input type="radio" id="removed-option" name="status" value="removed"
                                            class="hidden peer">
                                        <label for="removed-option"
                                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-red-50">
                                            <div class="block">
                                                <img class="w-12 h-12"
                                                    src="{{ asset('assets/images/icons/removed.png') }}"
                                                    alt="icon student">
                                                <div class="w-full text-lg font-semibold">Remove</div>
                                            </div>
                                        </label>
                                    </li>
                                </ul>

                                <div class="submit hidden">
                                    <x-textarea name="reason" label="Reason" placeholder="Reason" required />
                                    <p>* There will be no impact on students who have this course.</p>
                                    <button type="submit"
                                        class="mt-2 bg-green-400 hover:bg-green-700 duration-200 text-white font-bold rounded-lg shadow-md py-2 px-4">
                                        <span>Submit</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="settings-modal" type="button"
                        class="w-full py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-amber-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            /* Chart Avaraget Wachers for Course */
            const options = {
                chart: {
                    height: "100%",
                    maxWidth: "100%",
                    type: "area",
                    fontFamily: "Inter, sans-serif",
                    dropShadow: {
                        enabled: false,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                tooltip: {
                    enabled: true,
                    x: {
                        show: false,
                    },
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.55,
                        opacityTo: 0,
                        shade: "#1C64F2",
                        gradientToColors: ["#1C64F2"],
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 6,
                },
                grid: {
                    show: false,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: 0
                    },
                },
                series: [{
                    name: "Users",
                    data: {!! json_encode($avargetWatchs['counts']) !!},
                    color: "#1A56DB",
                }, ],
                xaxis: {
                    categories: {!! json_encode($avargetWatchs['progress']) !!},
                    labels: {
                        show: true,
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: false,
                },
            }

            if (document.getElementById("area-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("area-chart"), options);
                chart.render();
            }

            /* Profit with rate course on Y/m */
            const optionsColumn = {
                colors: ["#1A56DB", "#FDBA8C"],
                series: [{
                    name: "Profits",
                    color: "#1A56DB",
                    data: {!! json_encode($profits['charts']) !!},
                }, ],
                chart: {
                    type: "bar",
                    height: "320px",
                    fontFamily: "Inter, sans-serif",
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "70%",
                        borderRadiusApplication: "end",
                        borderRadius: 8,
                    },
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                states: {
                    hover: {
                        filter: {
                            type: "darken",
                            value: 1,
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 0,
                    colors: ["transparent"],
                },
                grid: {
                    show: false,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -14
                    },
                },
                dataLabels: {
                    enabled: true,
                },
                legend: {
                    show: false,
                },
                xaxis: {
                    floating: false,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        }
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: false,
                },
                fill: {
                    opacity: 1,
                },
            }

            if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("column-chart"), optionsColumn);
                chart.render();
            }


            /* Actions */
            $(".price-course").on('click', function() {
                $(".price-settings").toggleClass('hidden');
            });

            $(".status-course").on('click', function() {
                $(".show-status").toggleClass('hidden');
            });
            $("input[name=status]").on('change', function() {
                if ($(this).val() != null) {
                    $(".submit").removeClass('hidden');
                }
            });
        })
    </script>
@endsection
