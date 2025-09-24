<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Servis</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            z-index: 1000;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
            max-width: 350px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .notification.show {
            opacity: 1;
            transform: translateX(0);
        }

        .notification.success {
            background-color: #10B981;
        }

        .notification.error {
            background-color: #EF4444;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .pagination-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 2.5rem;
            min-width: 2.5rem;
            padding: 0 0.5rem;
            margin: 0 0.25rem;
            border-radius: 0.375rem;
            border: 1px solid #D1D5DB;
            background-color: white;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .pagination-btn:hover:not(.disabled) {
            background-color: #F3F4F6;
            border-color: #9CA3AF;
        }

        .pagination-btn.active {
            background-color: #3B82F6;
            border-color: #3B82F6;
            color: white;
        }

        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Chart Container Styles */
        .chart-container {
            position: relative;
            height: 12rem;
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
        }

        .chart-wrapper {
            min-width: 100%;
            height: 100%;
        }

        @media (max-width: 640px) {
            .table-container {
                overflow-x: auto;
                width: 100%;
                -webkit-overflow-scrolling: touch;
            }

            table {
                min-width: 700px;
            }

            .card-grid {
                grid-template-columns: 1fr;
            }

            .pagination {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }

            .pagination-btn {
                margin: 0 0.125rem;
                min-width: 2.25rem;
                height: 2.25rem;
                font-size: 0.75rem;
            }

            .chart-container {
                height: 10rem;
            }
        }

        @media (min-width: 1024px) {
            .chart-container {
                height: 14rem;
            }
        }

        /* Modal Konfirmasi */
        .confirmation-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .confirmation-modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .confirmation-input {
            width: 100%;
            padding: 8px 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    @include('komponen.sidebar')

    <!-- Notification Area -->
    <div id="notificationArea"></div>

    <main class="container mx-auto p-4 lg:p-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Daftar Servis</h1>
        </div>

        <!-- Flash Message Handler -->
        <div id="flash-messages">
            @if (session('success'))
                <div class="success-message" data-message="{{ session('success') }}"></div>
            @endif
            @if (session('error'))
                <div class="error-message" data-message="{{ session('error') }}"></div>
            @endif
        </div>

        <!-- Grid Atas: Card User + Rating + Diagram -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 card-grid">
            @php
                $user = Auth::user();
                $rating = $user->rating ?? 0;
                $ratingDescription = '';

                if ($rating >= 4.5) {
                    $ratingDescription = 'Sangat Baik';
                } elseif ($rating >= 4.0) {
                    $ratingDescription = 'Baik';
                } elseif ($rating >= 3.0) {
                    $ratingDescription = 'Cukup';
                } elseif ($rating >= 2.0) {
                    $ratingDescription = 'Perlu Peningkatan';
                } else {
                    $ratingDescription = 'Belum Ada Rating';
                }
            @endphp

            <!-- Card Info + Rating (hanya user login) -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div class="max-w-[75%]">
                        <p class="font-semibold text-black text-lg ">{{ $user->name }}</p>
                        <p class="text-black text-sm ">{{ $user->email }}</p>
                    </div>
                    <div class="text-black text-4xl shrink-0">
                        <i class="fa-regular fa-user-circle"></i>
                    </div>
                </div>
                <div class="mt-auto text-center pt-4 border-t border-gray-400">
                    <p class="font-semibold text-black text-base mb-2">Rata-rata Rating</p>
                    <div class="flex items-center justify-center space-x-1 mb-2 text-xl">
                        @php
                            $filledStars = floor($rating);
                            $halfStar = $rating - $filledStars >= 0.5;
                            $emptyStars = 5 - $filledStars - ($halfStar ? 1 : 0);
                        @endphp

                        @for ($i = 0; $i < $filledStars; $i++)
                            <i class="fas fa-star text-yellow-300"></i>
                        @endfor

                        @if ($halfStar)
                            <i class="fas fa-star-half-alt text-yellow-300"></i>
                        @endif

                        @for ($i = 0; $i < $emptyStars; $i++)
                            <i class="far fa-star text-yellow-300"></i>
                        @endfor
                    </div>
                    <p class="text-lg font-bold">{{ number_format($rating, 1) }}/5</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $ratingDescription }}</p>
                </div>
            </div>

            <!-- Diagram -->
            <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
                <h2 class="text-base font-semibold mb-3 text-gray-700">Total Servis Per Hari</h2>
                <div class="chart-container">
                    <div class="chart-wrapper">
                        <canvas id="servisChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter + Search -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Filter & Pencarian</h2>
            <div class="flex flex-col md:flex-row gap-4">
                <div class="w-full md:w-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="filterStatus"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 text-sm">
                        <option value="">Semua Status</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="belum">Belum diisi</option>
                    </select>
                </div>

                <div class="w-full md:w-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Proses</label>
                    <select id="filterProses"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 text-sm">
                        <option value="">Semua Proses</option>
                        <option value="barang diterima">Barang Diterima</option>
                        <option value="barang sedang diperbaiki">Sedang Diperbaiki</option>
                        <option value="barang sudah selesai diperbaiki">Selesai Diperbaiki</option>
                        <option value="barang sudah selesai dan terbayar">Selesai & Terbayar</option>
                        <option value="belum">Belum diisi</option>
                    </select>
                </div>

                <!-- Input Search -->
                <div class="w-full md:flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="searchInput" placeholder="Cari nama pelanggan atau ID Servis..."
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-10 pr-3 py-2 text-sm" />
                    </div>
                </div>
            </div>
        </div>

        <!-- FORM BULK DELETE -->
        <form id="bulkDeleteForm" method="POST" action="{{ route('service.bulk-delete') }}">
            @csrf
            @method('DELETE')
        </form>

        <!-- Tabel Service Request -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-2 md:mb-0">Daftar Service Request</h2>
                <div class="flex gap-2">
                    <button id="toggleDeleteMode"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm flex items-center gap-2 transition-colors">
                        <i class="fas fa-trash"></i> Mode Hapus
                    </button>

                    <button type="submit" form="bulkDeleteForm"
                        class="px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-red-800 text-sm hidden flex items-center gap-2 transition-colors"
                        id="deleteSelectedBtn">
                        <i class="fas fa-trash"></i> Hapus Terpilih
                    </button>
                </div>
            </div>

            <div class="table-container">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 hidden delete-col">
                                <input type="checkbox" id="selectAll" class="rounded text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-4 py-3">Pelanggan</th>
                            <th class="px-4 py-3">ID Servis</th>
                            <th class="px-4 py-3">Informasi Barang</th>
                            <th class="px-4 py-3">Proses</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Ditangani Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="serviceBody">
                        @php
                            $currentPage = request()->get('page', 1);
                            $perPage = 10;

                            // Urutkan data: diterima -> belum -> ditolak
                            $servicesCollection = $services->sortBy(function ($s) {
                                if ($s->status === 'diterima') {
                                    return 1;
                                }
                                if ($s->status === 'ditolak') {
                                    return 3;
                                }
                                return 2; // belum diisi
                            });

                            $paginatedServices = $servicesCollection->forPage($currentPage, $perPage);
                            $totalPages = ceil($servicesCollection->count() / $perPage);
                        @endphp

                        @foreach ($paginatedServices as $service)
                            <tr class="hover:bg-gray-50 transition" data-status="{{ $service->status ?? 'belum' }}"
                                data-proses="{{ $service->proses ?? 'belum' }}"
                                data-search="{{ strtolower($service->nama_pelanggan . ' ' . $service->service_id) }}">
                                <td class="px-4 py-3 hidden delete-col">
                                    <input type="checkbox"
                                        class="delete-checkbox rounded text-blue-600 focus:ring-blue-500"
                                        name="ids[]" value="{{ $service->id }}" form="bulkDeleteForm">
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $service->nama_pelanggan }}</td>
                                <td class="px-4 py-3 text-gray-700 font-mono">{{ $service->service_id }}</td>
                                <td class="px-4 py-3 text-gray-700">
                                    <p class="font-medium">{{ $service->jenis_barang }} - {{ $service->nama_barang }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $service->kerusakan }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('service.updateProsesStatus') }}"
                                        id="proses-form-{{ $service->id }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $service->id }}">
                                        <select name="proses"
                                            onchange="checkProsesStatus(this, {{ $service->id }})"
                                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-2"
                                            {{ $service->status === 'ditolak' ? 'disabled' : '' }}>
                                            <option value="">- Pilih Proses -</option>
                                            <option value="barang diterima"
                                                {{ $service->proses === 'barang diterima' ? 'selected' : '' }}>Barang
                                                Diterima</option>
                                            <option value="barang sedang diperbaiki"
                                                {{ $service->proses === 'barang sedang diperbaiki' ? 'selected' : '' }}>
                                                Sedang Diperbaiki</option>
                                            <option value="barang sudah selesai diperbaiki"
                                                {{ $service->proses === 'barang sudah selesai diperbaiki' ? 'selected' : '' }}>
                                                Selesai Diperbaiki</option>
                                            <option value="barang sudah selesai dan terbayar"
                                                {{ $service->proses === 'barang sudah selesai dan terbayar' ? 'selected' : '' }}>
                                                Selesai & Terbayar</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($service->status === 'ditolak')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                        @if ($service->catatan)
                                            <p class="text-xs text-gray-500 mt-1">Catatan: {{ $service->catatan }}</p>
                                        @endif
                                    @elseif ($service->status === 'diterima')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Diterima
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('service.updateProsesStatus') }}"
                                            id="status-form-{{ $service->id }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $service->id }}">
                                            <input type="hidden" name="catatan"
                                                id="catatan-input-{{ $service->id }}">
                                            <select name="status" id="status-select-{{ $service->id }}"
                                                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-2"
                                                onchange="checkStatus(this, {{ $service->id }})">
                                                <option value="">- Pilih Status -</option>
                                                <option value="diterima"
                                                    {{ $service->status === 'diterima' ? 'selected' : '' }}>Diterima
                                                </option>
                                                <option value="ditolak"
                                                    {{ $service->status === 'ditolak' ? 'selected' : '' }}>Ditolak
                                                </option>
                                            </select>
                                        </form>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $service->handledBy ? $service->handledBy->name : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($totalPages > 1)
                <div class="pagination">
                    <!-- Previous Button -->
                    <button class="pagination-btn {{ $currentPage == 1 ? 'disabled' : '' }}"
                        onclick="changePage({{ $currentPage - 1 }})" {{ $currentPage == 1 ? 'disabled' : '' }}>
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $totalPages; $i++)
                        @if ($i == 1 || $i == $totalPages || ($i >= $currentPage - 1 && $i <= $currentPage + 1))
                            <button class="pagination-btn {{ $i == $currentPage ? 'active' : '' }}"
                                onclick="changePage({{ $i }})">
                                {{ $i }}
                            </button>
                        @elseif ($i == $currentPage - 2 || $i == $currentPage + 2)
                            <span class="pagination-btn disabled">...</span>
                        @endif
                    @endfor

                    <!-- Next Button -->
                    <button class="pagination-btn {{ $currentPage == $totalPages ? 'disabled' : '' }}"
                        onclick="changePage({{ $currentPage + 1 }})"
                        {{ $currentPage == $totalPages ? 'disabled' : '' }}>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            @endif
        </div>
    </main>

    @include('komponen.footer')

    <!-- Modal Catatan -->
    <div id="catatan-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Masukkan Catatan Penolakan</h2>
            <textarea id="catatan-textarea"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 px-3 py-2 text-sm"
                rows="3" placeholder="Tuliskan alasan penolakan..."></textarea>
            <div class="mt-4 flex justify-end gap-2">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                <button onclick="submitCatatan()"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Modal Biaya -->
    <div id="biaya-modal" class="fixed inset-0 bg-black bg-black/50 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Masukkan Detail Biaya</h2>
            <form id="biaya-form" method="POST" action="{{ route('service.updateProsesStatus') }}">
                @csrf
                <input type="hidden" name="id" id="biaya-service-id">
                <input type="hidden" name="proses" value="barang sudah selesai diperbaiki">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sparepart</label>
                    <input type="text" name="nama_sparepart" placeholder="Masukkan nama sparepart"
                        class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Sparepart</label>
                    <input type="number" name="harga_sparepart" id="harga_sparepart" placeholder="0"
                        class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jasa</label>
                    <input type="number" name="harga_jasa" id="harga_jasa" placeholder="0"
                        class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Biaya</label>
                    <input type="number" name="total_biaya" id="total_biaya" placeholder="Otomatis dihitung"
                        class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
                        readonly>
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" onclick="closeBiayaModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Selesai & Terbayar -->
    <div id="konfirmasi-modal" class="confirmation-modal">
        <div class="confirmation-modal-content">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Konfirmasi Penyelesaian</h2>
            <p class="mb-3">Apakah Anda yakin ingin menyelesaikan dan menandai servis sebagai terbayar?</p>
            <p class="mb-3 text-sm text-gray-600">Ketik <strong>"YA"</strong> untuk mengonfirmasi:</p>
            <input type="text" id="konfirmasi-input" class="confirmation-input" placeholder="Ketik YA di sini">
            <div class="mt-4 flex justify-end gap-2">
                <button onclick="closeKonfirmasiModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                <button onclick="submitKonfirmasi()"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">Konfirmasi</button>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        // Chart
        const ctx = document.getElementById('servisChart').getContext('2d');
        const rawData = @json($services->map(fn($s) => \Carbon\Carbon::parse($s->created_at)->format('Y-m-d')));
        const counts = {};
        rawData.forEach(date => {
            counts[date] = (counts[date] || 0) + 1;
        });

        // Format tanggal untuk tampilan yang lebih baik
        const formattedLabels = Object.keys(counts).map(date => {
            const d = new Date(date);
            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: formattedLabels,
                datasets: [{
                    label: 'Jumlah Servis',
                    data: Object.values(counts),
                    borderWidth: 1,
                    backgroundColor: 'rg59, 130, 246, 0.8)',
                    borderRadius: 4,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
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
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            font: {
                                size: 10,
                                weight: 'bold'
                            },
                            color: '#1f2937'
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11,
                                weight: 'bold'
                            },
                            color: '#1f2937'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        let currentServiceId = null;
        let currentProsesSelect = null;
        let previousProsesValue = null;

        // Urutan proses yang valid
        const prosesOrder = {
            '': 0,
            'barang diterima': 1,
            'barang sedang diperbaiki': 2,
            'barang sudah selesai diperbaiki': 3,
            'barang sudah selesai dan terbayar': 4
        };

        function checkStatus(select, id) {
            if (select.value === 'ditolak') {
                currentServiceId = id;
                document.getElementById('catatan-modal').classList.remove('hidden');
            } else if (select.value === 'diterima') {
                select.form.submit();
            }
        }

        function checkProsesStatus(select, id) {
            const selectedValue = select.value;
            const previousValue = select.getAttribute('data-previous') || '';

            // Simpan nilai sebelumnya untuk referensi
            select.setAttribute('data-previous', selectedValue);

            // Jika memilih proses "Selesai & Terbayar", tampilkan konfirmasi
            if (selectedValue === 'barang sudah selesai dan terbayar') {
                currentServiceId = id;
                currentProsesSelect = select;
                previousProsesValue = select.getAttribute('data-previous') || '';
                document.getElementById('konfirmasi-modal').style.display = 'flex';
                return;
            }

            // Validasi urutan proses
            if (!validateProsesOrder(previousValue, selectedValue)) {
                showNotification('Tidak dapat melompati proses. Silakan ikuti urutan yang benar.', 'error');
                select.value = previousValue;
                return;
            }

            // Jika memilih proses "Selesai Diperbaiki", tampilkan modal biaya
            if (selectedValue === 'barang sudah selesai diperbaiki') {
                currentServiceId = id;
                document.getElementById('biaya-service-id').value = id;
                document.getElementById('biaya-modal').classList.remove('hidden');
            } else {
                select.form.submit();
            }
        }

        function validateProsesOrder(previous, next) {
            // Jika sebelumnya kosong atau sama, valid
            if (!previous || previous === next) return true;

            // Jika next adalah proses awal, valid
            if (next === 'barang diterima') return true;

            // Validasi urutan
            return prosesOrder[next] === prosesOrder[previous] + 1;
        }

        function closeModal() {
            document.getElementById('catatan-modal').classList.add('hidden');
            document.getElementById('catatan-textarea').value = '';
            if (currentServiceId) {
                document.getElementById(`status-select-${currentServiceId}`).value = '';
            }
        }

        function submitCatatan() {
            const note = document.getElementById('catatan-textarea').value.trim();
            if (!note) {
                showNotification('Catatan penolakan wajib diisi.', 'error');
                return;
            }
            document.getElementById(`catatan-input-${currentServiceId}`).value = note;
            document.getElementById(`status-form-${currentServiceId}`).submit();
            closeModal();
        }

        function closeBiayaModal() {
            document.getElementById('biaya-modal').classList.add('hidden');
            document.getElementById('biaya-form').reset();
            document.getElementById('total_biaya').value = "";
            if (currentServiceId) {
                const select = document.querySelector(`#proses-form-${currentServiceId} select[name="proses"]`);
                if (select) {
                    // Kembalikan ke nilai sebelumnya
                    select.value = select.getAttribute('data-previous') || '';
                }
            }
        }

        function showKonfirmasiModal() {
            document.getElementById('konfirmasi-modal').style.display = 'flex';
        }

        function closeKonfirmasiModal() {
            document.getElementById('konfirmasi-modal').style.display = 'none';
            document.getElementById('konfirmasi-input').value = '';
            if (currentProsesSelect) {
                // Kembalikan ke nilai sebelumnya
                currentProsesSelect.value = previousProsesValue;
            }
        }

        function submitKonfirmasi() {
            const input = document.getElementById('konfirmasi-input').value;
            if (input.toUpperCase() === 'YA') {
                // Submit form proses
                document.getElementById(`proses-form-${currentServiceId}`).submit();
                closeKonfirmasiModal();
            } else {
                showNotification('Konfirmasi gagal. Silakan ketik "YA" untuk melanjutkan.', 'error');
            }
        }

        // Hitung total biaya otomatis
        const hargaSparepart = document.getElementById("harga_sparepart");
        const hargaJasa = document.getElementById("harga_jasa");
        const totalBiaya = document.getElementById("total_biaya");

        function updateTotal() {
            const sparepart = parseFloat(hargaSparepart.value) || 0;
            const jasa = parseFloat(hargaJasa.value) || 0;
            totalBiaya.value = sparepart + jasa;
        }

        if (hargaSparepart && hargaJasa && totalBiaya) {
            hargaSparepart.addEventListener("input", updateTotal);
            hargaJasa.addEventListener("input", updateTotal);
        }

        // Filter & Search
        const filterStatus = document.getElementById("filterStatus");
        const filterProses = document.getElementById("filterProses");
        const searchInput = document.getElementById("searchInput");
        const rows = document.querySelectorAll("#serviceBody tr");

        function applyFilters() {
            const status = filterStatus.value;
            const proses = filterProses.value;
            const search = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const rowStatus = row.dataset.status;
                const rowProses = row.dataset.proses;
                const rowSearch = row.dataset.search;

                // Perbaikan: Handle status "ditolak" dengan benar
                const matchStatus = !status ||
                    (status === 'ditolak' && rowStatus === 'ditolak') ||
                    (status === 'diterima' && rowStatus === 'diterima') ||
                    (status === 'belum' && (rowStatus === '' || rowStatus === 'belum'));

                // Perbaikan: Handle proses dengan benar
                const matchProses = !proses ||
                    (proses === 'belum' && (rowProses === '' || rowProses === 'belum')) ||
                    (proses !== 'belum' && rowProses === proses);

                const matchSearch = !search || rowSearch.includes(search);

                row.style.display = (matchStatus && matchProses && matchSearch) ? "" : "none";
            });
        }

        filterStatus.addEventListener("change", applyFilters);
        filterProses.addEventListener("change", applyFilters);
        searchInput.addEventListener("keyup", applyFilters);

        // Mode Hapus
        const toggleDeleteMode = document.getElementById("toggleDeleteMode");
        const deleteSelectedBtn = document.getElementById("deleteSelectedBtn");
        const deleteCols = document.querySelectorAll(".delete-col");
        let deleteMode = false;

        toggleDeleteMode.addEventListener("click", () => {
            deleteMode = !deleteMode;
            deleteCols.forEach(col => col.classList.toggle("hidden", !deleteMode));
            deleteSelectedBtn.classList.toggle("hidden", !deleteMode);

            // Update teks tombol
            if (deleteMode) {
                toggleDeleteMode.innerHTML = '<i class="fas fa-times"></i> Batal';
                toggleDeleteMode.classList.replace('bg-red-500', 'bg-gray-600');
            } else {
                toggleDeleteMode.innerHTML = '<i class="fas fa-trash"></i> Mode Hapus';
                toggleDeleteMode.classList.replace('bg-gray-600', 'bg-red-500');
            }
        });

        // Select All
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', () => {
                document.querySelectorAll('.delete-checkbox').forEach(cb => cb.checked = selectAll.checked);
            });
        }

        // Validasi bulk delete
        document.getElementById('bulkDeleteForm').addEventListener('submit', function(e) {
            const checked = document.querySelectorAll('.delete-checkbox:checked');
            if (checked.length === 0) {
                e.preventDefault();
                showNotification('Pilih minimal satu data untuk dihapus!', 'error');
            } else if (!confirm('Yakin hapus data terpilih?')) e.preventDefault();
        });

        // Fungsi notifikasi
        function showNotification(message, type = 'success') {
            const notificationArea = document.getElementById('notificationArea');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2 mt-0.5"></i>
                    <span>${message}</span>
                </div>
            `;

            notificationArea.appendChild(notification);

            // Trigger reflow untuk memastikan transisi berjalan
            notification.offsetHeight;

            // Tampilkan notifikasi
            notification.classList.add('show');

            // Sembunyikan notifikasi setelah 5 detik
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    notificationArea.removeChild(notification);
                }, 300);
            }, 5000);
        }

        // Fungsi pagination
        function changePage(page) {
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }

        // Tampilkan notifikasi flash message jika ada
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.success-message');
            const errorMessage = document.querySelector('.error-message');

            if (successMessage) {
                showNotification(successMessage.getAttribute('data-message'), 'success');
            }

            if (errorMessage) {
                showNotification(errorMessage.getAttribute('data-message'), 'error');
            }

            // Inisialisasi nilai sebelumnya untuk semua select proses
            document.querySelectorAll('select[name="proses"]').forEach(select => {
                select.setAttribute('data-previous', select.value);
            });

            // Inisialisasi filter
            applyFilters();
        });
    </script>
</body>

</html>
