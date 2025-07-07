<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-600 mt-1">ภาพรวมข้อมูลทางการเงิน</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-6">
        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-wrap gap-4 items-center">
                <div class="flex items-center gap-3">
                    <label class="text-sm font-medium text-gray-700">ปี:</label>
                    <select class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white min-w-[100px]" wire:model="selectedYear">
                        @foreach ($yearList as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <label class="text-sm font-medium text-gray-700">เดือน:</label>
                    <select class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white min-w-[120px]" wire:model="selectedMonth">
                        @foreach ($monthList as $index => $month)
                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center gap-2" wire:click="loadNewData">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    แสดงรายการ
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            <!-- Income Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-coins text-green-600"></i>
                            <h3 class="text-sm font-medium text-gray-900">รายได้</h3>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($income) }}</p>
                        <p class="text-xs text-gray-500">บาท</p>
                    </div>
                </div>
            </div>

            <!-- Empty Rooms Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-bed text-blue-600"></i>
                            <h3 class="text-sm font-medium text-gray-900">ห้องว่าง</h3>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $roomFee }}</p>
                        <p class="text-xs text-gray-500">ห้อง</p>
                    </div>
                </div>
            </div>

            <!-- Debt Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-handshake text-amber-600"></i>
                            <h3 class="text-sm font-medium text-gray-900">ค้างจ่าย</h3>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($debt) }}</p>
                        <p class="text-xs text-gray-500">บาท</p>
                    </div>
                </div>
            </div>

            <!-- Expenses Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-arrow-down text-red-600"></i>
                            <h3 class="text-sm font-medium text-gray-900">รายจ่าย</h3>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($pay) }}</p>
                        <p class="text-xs text-gray-500">บาท</p>
                    </div>
                </div>
            </div>

            <!-- Balance Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-chart-line {{ $income - $pay > 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                            <h3 class="text-sm font-medium text-gray-900">ผลประกอบการ</h3>
                        </div>
                        <p class="text-2xl font-bold {{ $income - $pay > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($income - $pay) }}
                        </p>
                        <p class="text-xs text-gray-500">บาท</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Income Chart -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">รายได้รายเดือน</h2>
                </div>
                <div id="incomeChart" class="w-full h-80"></div>
            </div>

            <!-- Pie Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">รายได้ตามประเภท</h2>
                </div>
                <div id="pieChart" class="w-full h-80"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:init', function() {
            var incomeChart = null;
            var pieChart = null;

            function initIncomeChart() {
                const options = {
                    chart: {
                        type: 'bar',
                        height: 320,
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                selection: false,
                                zoom: false,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                                reset: false
                            }
                        },
                        background: '#ffffff'
                    },
                    series: [{
                        name: 'รายได้',
                        data: @json(array_values($incomeInMonths))
                    }],
                    plotOptions: {
                        bar: {
                            borderRadius: 2,
                            columnWidth: '60%',
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    colors: ['#2563eb'],
                    xaxis: {
                        categories: [
                            'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.',
                            'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.',
                            'ต.ค.', 'พ.ย.', 'ธ.ค.'
                        ],
                        axisBorder: {
                            show: true,
                            color: '#e5e7eb'
                        },
                        axisTicks: {
                            show: true,
                            color: '#e5e7eb'
                        },
                        labels: {
                            style: {
                                colors: '#6b7280',
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                return val.toLocaleString('th-TH');
                            },
                            style: {
                                colors: '#6b7280',
                                fontSize: '12px'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return val.toLocaleString('th-TH');
                        },
                        offsetY: -20,
                        style: {
                            fontSize: '11px',
                            colors: ['#374151'],
                            fontWeight: '500'
                        }
                    },
                    grid: {
                        show: true,
                        borderColor: '#f3f4f6',
                        strokeDashArray: 0,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                incomeChart = new ApexCharts(document.querySelector("#incomeChart"), options);
                incomeChart.render();
            }

            function initPieChart() {
                const pieOptions = {
                    series: @json(array_values($incomePie)),
                    chart: {
                        type: 'pie',
                        height: 320,
                        toolbar: {
                            show: true,
                            tools: {
                                download: true
                            }
                        }
                    },
                    labels: ['รายวัน', 'รายเดือน'],
                    colors: ['#059669', '#2563eb'],
                    plotOptions: {
                        pie: {
                            size: 200,
                            donut: {
                                size: '0%'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return val.toFixed(1) + '%';
                        },
                        style: {
                            fontSize: '12px',
                            fontWeight: '500',
                            colors: ['#ffffff']
                        }
                    },
                    legend: {
                        position: 'bottom',
                        fontSize: '12px',
                        fontWeight: '500',
                        markers: {
                            radius: 4
                        },
                        labels: {
                            colors: '#374151'
                        }
                    },
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 250
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                pieChart = new ApexCharts(document.querySelector("#pieChart"), pieOptions);
                pieChart.render();
            }

            initIncomeChart();
            initPieChart();
        });
    </script>
@endpush