<!DOCTYPE html>
<html lang="id" x-data="{ activeTab: 'selesai' }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Servis</title>
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

<body class="bg-gray-50 font-sans min-h-screen">
    @include('komponen.sidebar')

    <div class="lg:ml-30 p-3">
        <div class="">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Ringkasan Servis</h1>
                <p class="text-gray-600">Lihat analisis dan ringkasan performa servis</p>
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

            <!-- Filter Teknisi -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Teknisi</h3>
                <form method="GET" action="" class="flex gap-4">
                    <select name="teknisi_id"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Teknisi</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" {{ request('teknisi_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Filter
                    </button>
                    @if (request('teknisi_id'))
                        <a href="{{ url()->current() }}"
                            class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
            <!-- Tab Content Selesai -->
            <div x-show="activeTab === 'selesai'" x-transition:enter="fade-enter"
                x-transition:enter-active="fade-enter-active">
                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Servis Selesai</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalSelesai }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-money-bill-wave text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Pendapatan </p>
                                <h3 class="text-2xl font-bold text-gray-800">
                                    Rp{{ number_format($pendapatanBersih ?? 0, 0, ',', '.') }}
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
                                    @if ($totalSelesai > 0)
                                        Rp{{ number_format(($pendapatanBersih ?? 0) / $totalSelesai, 0, ',', '.') }}
                                    @else
                                        Rp0
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Servis Selesai -->
                @if ($selesai->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="mx-auto w-24 h-24 mb-4 text-gray-300">
                            <i class="fas fa-check-circle text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada servis yang selesai</h3>
                        <p class="text-gray-500">Servis yang telah selesai akan muncul di sini.</p>
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
                                            Teknisi</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Update</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rating</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ulasan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga Jasa</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga Sparepart</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Biaya</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($selesai as $s)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $s->service_id }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $s->nama_pelanggan }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $s->jenis_barang }}</div>
                                                <div class="text-sm text-gray-500">{{ $s->nama_barang }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $s->handledBy->name ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $s->updated_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($s->rating)
                                                    <div class="flex items-center">
                                                        <span class="text-yellow-400">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="fas fa-star{{ $i <= $s->rating ? '' : '-empty' }} text-sm"></i>
                                                            @endfor
                                                        </span>
                                                        <span
                                                            class="ml-1 text-xs text-gray-600">{{ $s->rating }}/5</span>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                                    {{ $s->ulasan ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp{{ number_format($s->harga_jasa ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp{{ number_format($s->harga_sparepart ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Rp{{ number_format($s->total_biaya ?? 0, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tab Content Tidak Selesai -->
            <div x-show="activeTab === 'tidak-selesai'" x-transition:enter="fade-enter"
                x-transition:enter-active="fade-enter-active">
                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-red-100 text-red-600 mr-4">
                                <i class="fas fa-times-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Servis Tidak Selesai</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalTidakSelesai }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-orange-100 text-orange-600 mr-4">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Potensi Pendapatan Hilang</p>
                                <h3 class="text-2xl font-bold text-gray-800">
                                    Rp{{ $totalSelesai > 0 ? number_format($totalTidakSelesai * ($pendapatanBersih / $totalSelesai), 0, ',', '.') : 0 }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-gray-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-gray-100 text-gray-600 mr-4">
                                <i class="fas fa-chart-pie text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Rasio Penyelesaian</p>
                                <h3 class="text-2xl font-bold text-gray-800">
                                    @if ($totalSelesai + $totalTidakSelesai > 0)
                                        {{ number_format(($totalSelesai / ($totalSelesai + $totalTidakSelesai)) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Servis Tidak Selesai -->
                @if ($tidakSelesai->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="mx-auto w-24 h-24 mb-4 text-gray-300">
                            <i class="fas fa-times-circle text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada servis yang tidak selesai</h3>
                        <p class="text-gray-500">Servis yang tidak selesai akan muncul di sini.</p>
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
                                            Teknisi</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Update</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($tidakSelesai as $t)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $t->service_id }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $t->nama_pelanggan }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $t->jenis_barang }}</div>
                                                <div class="text-sm text-gray-500">{{ $t->nama_barang }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $t->handledBy->name ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $t->updated_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Tidak Selesai
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tab Content Analisis -->
            <div x-show="activeTab === 'analisis'" x-transition:enter="fade-enter"
                x-transition:enter-active="fade-enter-active" class="space-y-8">


                <!-- Diagram Biaya + Rating -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Perbandingan Biaya {{ $lastYearVal }} vs
                                {{ $currentYear }}</h3>
                            <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                        <div class="relative h-72">
                            <canvas id="biayaChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Distribusi Rating Pelanggan</h3>
                            <div class="p-2 rounded-lg bg-green-100 text-green-600">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                        </div>
                        <div class="relative h-72">
                            <canvas id="ratingChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bar Chart Biaya
            const ctx = document.getElementById('biayaChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov",
                        "Des"
                    ],
                    datasets: [{
                            label: "{{ $currentYear }}",
                            data: {!! $thisYear !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: "{{ $lastYearVal }}",
                            data: {!! $lastYear !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let val = context.raw || 0;
                                    return 'Rp' + val.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Pie Chart Rating
            const ratingCtx = document.getElementById('ratingChart').getContext('2d');
            new Chart(ratingCtx, {
                type: 'pie',
                data: {
                    labels: ['1 ⭐', '2 ⭐', '3 ⭐', '4 ⭐', '5 ⭐'],
                    datasets: [{
                        data: {!! json_encode($ratingCounts ?? [0, 0, 0, 0, 0]) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(54, 162, 235, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let val = context.raw || 0;
                                    return label + ': ' + val + ' rating';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
<footer class="footer">
    @include('komponen.footer')
</footer>

</html>
