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
                <button type="button"
                    class="inline-block py-2 px-4 font-bold text-white bg-gray-700 hover:bg-gray-600 border border-gray-900 rounded-xl duration-200">
                    Settings
                </button>
            </div>
        </div>

        <div class='mt-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4'>
            <x-charts.area-chart idChart='area-chart' title='Avarget Countiune Course' topNumber='' present=''>
            </x-charts.area-chart>

            <x-charts.column-chart idChart='column-chart' title='Profits This month' topNumber='' present=''
                earns="${{ $profits['earns'] }}" />

            <x-charts.timeline title="Logs Changes on Course">
                @forelse ($course->logs as $log)
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
                                <img src="{{ Stroage::url($review->user->photo) }}" class='w-12 h-12 rounded-full' alt="photo user reviewer">
                                <a href="{{ route('dashboard.profile', $review->user->id) }}" target="__blank">
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

            /* */

            const getChartOptions = () => {
                return {
                    series: [35.1, 23.5, 2.4, 5.4],
                    colors: ["#1C64F2", "#16BDCA", "#FDBA8C", "#E74694"],
                    chart: {
                        height: 320,
                        width: "100%",
                        type: "donut",
                    },
                    stroke: {
                        colors: ["transparent"],
                        lineCap: "",
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontFamily: "Inter, sans-serif",
                                        offsetY: 20,
                                    },
                                    total: {
                                        showAlways: true,
                                        show: true,
                                        label: "Unique visitors",
                                        fontFamily: "Inter, sans-serif",
                                        formatter: function(w) {
                                            const sum = w.globals.seriesTotals.reduce((a, b) => {
                                                return a + b
                                            }, 0)
                                            return '$' + sum + 'k'
                                        },
                                    },
                                    value: {
                                        show: true,
                                        fontFamily: "Inter, sans-serif",
                                        offsetY: -20,
                                        formatter: function(value) {
                                            return value + "k"
                                        },
                                    },
                                },
                                size: "80%",
                            },
                        },
                    },
                    grid: {
                        padding: {
                            top: -2,
                        },
                    },
                    labels: ["Direct", "Sponsor", "Affiliate", "Email marketing"],
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        position: "bottom",
                        fontFamily: "Inter, sans-serif",
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return value + "k"
                            },
                        },
                    },
                    xaxis: {
                        labels: {
                            formatter: function(value) {
                                return value + "k"
                            },
                        },
                        axisTicks: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                    },
                }
            }

            if (document.getElementById("donut-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("donut-chart"), getChartOptions());
                chart.render();

                // Get all the checkboxes by their class name
                const checkboxes = document.querySelectorAll('#devices input[type="checkbox"]');

                // Function to handle the checkbox change event
                function handleCheckboxChange(event, chart) {
                    const checkbox = event.target;
                    if (checkbox.checked) {
                        switch (checkbox.value) {
                            case 'desktop':
                                chart.updateSeries([15.1, 22.5, 4.4, 8.4]);
                                break;
                            case 'tablet':
                                chart.updateSeries([25.1, 26.5, 1.4, 3.4]);
                                break;
                            case 'mobile':
                                chart.updateSeries([45.1, 27.5, 8.4, 2.4]);
                                break;
                            default:
                                chart.updateSeries([55.1, 28.5, 1.4, 5.4]);
                        }

                    } else {
                        chart.updateSeries([35.1, 23.5, 2.4, 5.4]);
                    }
                }

                // Attach the event listener to each checkbox
                checkboxes.forEach((checkbox) => {
                    checkbox.addEventListener('change', (event) => handleCheckboxChange(event, chart));
                });
            }

        })
    </script>
@endsection
