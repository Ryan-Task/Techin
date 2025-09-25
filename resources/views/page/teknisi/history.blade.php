<!DOCTYPE html>
<html lang="id" x-data="{ activeTab: 'servis' }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Servis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .fade-enter {
            opacity: 0;
            transform: translateY(10px);
        }

        .fade-enter-active {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Custom Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .pagination-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
            background-color: white;
            color: #6b7280;
        }

        .pagination-link:hover {
            background-color: #f3f4f6;
            color: #374151;
            border-color: #d1d5db;
        }

        .pagination-link.active {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }

        .pagination-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #f9fafb;
        }

        .pagination-link.disabled:hover {
            background-color: #f9fafb;
            color: #6b7280;
            border-color: #e5e7eb;
        }

        .pagination-ellipsis {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            color: #6b7280;
            font-weight: 500;
        }

        @media (max-width: 640px) {
            .pagination-link {
                width: 2.25rem;
                height: 2.25rem;
                font-size: 0.8rem;
            }

            .pagination-ellipsis {
                width: 2.25rem;
                height: 2.25rem;
            }
        }
    </style>
</head>

@include('komponen.sidebar')

<body class="bg-gray-50 font-sans min-h-screen">

    <div class="lg:ml-30 p-3">
        <div class="">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">History Servis</h1>
                <p class="text-gray-600">Lihat riwayat servis dan analisis pendapatan Anda</p>
            </div>

            <!-- Informasi Akun -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Informasi Akun</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-lg bg-gray-100 text-gray-600">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-lg bg-gray-100 text-gray-600">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium text-gray-800">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="mb-8">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button @click="activeTab = 'servis'"
                            :class="activeTab === 'servis' ? 'border-blue-500 text-blue-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                            <i class="fas fa-tools mr-2"></i>Data Servis
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div x-show="activeTab === 'servis'" x-transition:enter="fade-enter"
                x-transition:enter-active="fade-enter-active">
                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-tools text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Servis</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $services->total() }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-money-bill-wave text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Pendapatan</p>
                                <h3 class="text-2xl font-bold text-gray-800">
                                    Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                                <i class="fas fa-chart-pie text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Rata-rata per Servis</p>
                                <h3 class="text-2xl font-bold text-gray-800">
                                    @if ($services->total() > 0)
                                        Rp{{ number_format($totalPendapatan / $services->total(), 0, ',', '.') }}
                                    @else
                                        Rp0
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel History -->
                @if ($services->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="mx-auto w-24 h-24 mb-4 text-gray-300">
                            <i class="fas fa-tools text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada history servis</h3>
                        <p class="text-gray-500">Servis yang telah selesai dan terbayar akan muncul di sini.</p>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-10">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID Servis</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pelanggan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Barang</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kerusakan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Biaya</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pendapatan Bersih</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($services as $service)
                                        @php
                                            $pendapatanBersih = $service->total_biaya - $service->harga_sparepart;
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $service->service_id }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $service->nama_pelanggan }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $service->jenis_barang }}</div>
                                                <div class="text-sm text-gray-500">{{ $service->nama_barang }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    {{ Str::limit($service->kerusakan, 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Rp{{ number_format($service->total_biaya, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Rp{{ number_format($pendapatanBersih, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($service->updated_at)->translatedFormat('d M Y, H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 bg-gray-50 border-t">
                            <div class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($services->onFirstPage())
                                    <span class="pagination-link disabled">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $services->previousPageUrl() }}" class="pagination-link">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $current = $services->currentPage();
                                    $last = $services->lastPage();
                                    $start = max($current - 2, 1);
                                    $end = min($current + 2, $last);

                                    if ($start > 1) {
                                        echo '<a href="' . $services->url(1) . '" class="pagination-link">1</a>';
                                        if ($start > 2) {
                                            echo '<span class="pagination-ellipsis">...</span>';
                                        }
                                    }

                                    for ($i = $start; $i <= $end; $i++) {
                                        if ($i == $current) {
                                            echo '<span class="pagination-link active">' . $i . '</span>';
                                        } else {
                                            echo '<a href="' .
                                                $services->url($i) .
                                                '" class="pagination-link">' .
                                                $i .
                                                '</a>';
                                        }
                                    }

                                    if ($end < $last) {
                                        if ($end < $last - 1) {
                                            echo '<span class="pagination-ellipsis">...</span>';
                                        }
                                        echo '<a href="' .
                                            $services->url($last) .
                                            '" class="pagination-link">' .
                                            $last .
                                            '</a>';
                                    }
                                @endphp

                                {{-- Next Page Link --}}
                                @if ($services->hasMorePages())
                                    <a href="{{ $services->nextPageUrl() }}" class="pagination-link">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="pagination-link disabled">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Analisis Tab -->
            <div x-show="activeTab === 'analisis'" x-transition:enter="fade-enter"
                x-transition:enter-active="fade-enter-active" class="space-y-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Pendapatan Per Bulan</h3>
                            <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="relative h-72">
                            <canvas id="incomeChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Statistik Servis</h3>
                            <div class="p-2 rounded-lg bg-green-100 text-green-600">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                        <div class="relative h-72">
                            <canvas id="serviceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-12">
        @include('komponen.footer')
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx1 = document.getElementById('serviceChart').getContext('2d');
            new Chart(ctx1, {
                type: 'doughnut',
                data: {
                    labels: ['Diterima', 'Ditolak'],
                    datasets: [{
                        data: [{{ $totalDiterima }}, {{ $totalDitolak }}],
                        backgroundColor: ['#3b82f6', '#ef4444'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });

            const ctx2 = document.getElementById('incomeChart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: [
                        @foreach ($incomePerMonth as $row)
                            "{{ \Carbon\Carbon::create($row->year, $row->month)->translatedFormat('M Y') }}",
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Pendapatan Bersih',
                        data: [
                            @foreach ($incomePerMonth as $row)
                                {{ $row->total }},
                            @endforeach
                        ],
                        fill: true,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'white',
                            titleColor: '#1f2937',
                            bodyColor: '#6b7280',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            padding: 12,
                            usePointStyle: true,
                            callbacks: {
                                label: function(context) {
                                    return `Rp${context.raw.toLocaleString('id-ID')}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>

</body>

</html>
