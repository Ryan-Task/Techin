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

        /* New Styles for Riwayat-like Design */
        .fade-enter {
            opacity: 0;
            transform: translateY(10px);
        }

        .fade-enter-active {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .info-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            border-left: 4px solid;
        }

        .info-card-blue {
            border-left-color: #3b82f6;
        }

        .info-card-green {
            border-left-color: #10b981;
        }

        .info-card-purple {
            border-left-color: #8b5cf6;
        }

        .table-rounded {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table-rounded thead {
            background-color: #f9fafb;
        }

        .table-rounded th {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
        }

        .table-rounded td {
            padding: 1rem 1.5rem;
            border-top: 1px solid #f3f4f6;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-badge-diterima {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-badge-ditolak {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-badge-belum {
            background-color: #f3f4f6;
            color: #374151;
        }

        .select-custom {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .select-custom:focus {
            outline: none;
            ring: 2px;
            ring-color: #3b82f6;
            border-color: #3b82f6;
        }

        .select-custom:disabled {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .lg\:ml-30 {
                margin-left: 0;
            }

            .p-3 {
                padding: 1rem;
            }

            .table-container {
                overflow-x: auto;
                width: 100%;
                -webkit-overflow-scrolling: touch;
                border-radius: 8px;
            }

            table {
                min-width: 800px;
                /* Diperlebar untuk memastikan semua konten terlihat */
            }

            .card-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .pagination {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 0.5rem;
                flex-wrap: wrap;
            }

            .pagination-link {
                margin: 0 0.125rem;
                min-width: 2.25rem;
                height: 2.25rem;
                font-size: 0.75rem;
            }

            .chart-container {
                height: 10rem;
            }

            /* Perbaikan khusus untuk kolom Proses dan Status di mobile */
            .mobile-optimized-select {
                min-width: 140px !important;
                font-size: 14px !important;
                padding: 8px 10px !important;
            }

            .mobile-optimized-select option {
                font-size: 14px;
                padding: 8px;
            }

            .status-badge {
                font-size: 12px;
                padding: 4px 10px;
                white-space: nowrap;
            }

            /* Header yang lebih compact di mobile */
            .table-rounded th {
                padding: 0.5rem 0.75rem;
                font-size: 11px;
            }

            .table-rounded td {
                padding: 0.75rem;
                font-size: 14px;
            }

            /* Text truncate untuk konten panjang */
            .truncate-mobile {
                max-width: 120px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            /* Perbaikan layout filter di mobile */
            .filter-container {
                flex-direction: column;
                gap: 1rem;
            }

            .filter-container>div {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            table {
                min-width: 900px;
                /* Lebih lebar lagi untuk layar sangat kecil */
            }

            .mobile-optimized-select {
                min-width: 160px !important;
                font-size: 16px !important;
                /* Lebih besar untuk readability */
            }

            .status-badge {
                font-size: 14px;
                padding: 6px 12px;
            }

            .table-rounded th {
                padding: 0.5rem;
                font-size: 10px;
            }

            .table-rounded td {
                padding: 0.5rem;
                font-size: 12px;
            }

            .truncate-mobile {
                max-width: 100px;
            }
        }

        @media (min-width: 1024px) {
            .chart-container {
                height: 14rem;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    @include('komponen.sidebar')

    <!-- Notification Area -->
    <div id="notificationArea"></div>

    <div class="lg:ml-30 p-3">
        <div class="">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Daftar Servis</h1>
                <p class="text-gray-600 text-sm md:text-base">Kelola dan pantau semua permintaan servis</p>
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6 card-grid">
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
                <div class="info-card info-card-blue">
                    <div class="flex items-center justify-between mb-4">
                        <div class="max-w-[70%]">
                            <p class="font-semibold text-black text-base md:text-lg truncate">{{ $user->name }}</p>
                            <p class="text-black text-xs md:text-sm truncate">{{ $user->email }}</p>
                        </div>
                        <div class="text-black text-3xl md:text-4xl shrink-0">
                            <i class="fa-regular fa-user-circle"></i>
                        </div>
                    </div>
                    <div class="mt-auto text-center pt-4 border-t border-gray-200">
                        <p class="font-semibold text-black text-sm md:text-base mb-2">Rata-rata Rating</p>
                        <div class="flex items-center justify-center space-x-1 mb-2 text-lg md:text-xl">
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
                        <p class="text-base md:text-lg font-bold">{{ number_format($rating, 1) }}/5</p>
                        <p class="text-xs md:text-sm text-gray-600 mt-1">{{ $ratingDescription }}</p>
                    </div>
                </div>

                <!-- Diagram -->
                <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 lg:col-span-2">
                    <h2 class="text-base font-semibold mb-3 text-gray-700">Total Servis Per Hari</h2>
                    <div class="chart-container">
                        <div class="chart-wrapper">
                            <canvas id="servisChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                <div class="info-card info-card-blue">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 rounded-lg bg-blue-100 text-blue-600 mr-3 md:mr-4">
                            <i class="fas fa-tools text-lg md:text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-600">Total Servis</p>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800">{{ $services->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="info-card info-card-green">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 rounded-lg bg-green-100 text-green-600 mr-3 md:mr-4">
                            <i class="fas fa-check-circle text-lg md:text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-600">Diterima</p>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800">
                                {{ $services->where('status', 'diterima')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="info-card info-card-purple">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 rounded-lg bg-purple-100 text-purple-600 mr-3 md:mr-4">
                            <i class="fas fa-times-circle text-lg md:text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-600">Ditolak</p>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800">
                                {{ $services->where('status', 'ditolak')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter + Search -->
            <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Filter & Pencarian</h2>
                <div class="flex flex-col md:flex-row gap-4 filter-container">
                    <div class="w-full md:w-auto">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="filterStatus" class="select-custom mobile-optimized-select">
                            <option value="">Semua Status</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                            <option value="belum">Belum diisi</option>
                        </select>
                    </div>

                    <div class="w-full md:w-auto">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proses</label>
                        <select id="filterProses" class="select-custom mobile-optimized-select">
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
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-10 pr-3 py-2 text-sm md:text-base" />
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
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 md:mb-10">
                <div
                    class="flex flex-col md:flex-row md:items-center justify-between p-4 md:p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2 md:mb-0">Daftar Service Request</h2>
                    <div class="flex gap-2">
                        <button id="toggleDeleteMode"
                            class="px-3 py-2 md:px-4 md:py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs md:text-sm flex items-center gap-2 transition-colors">
                            <i class="fas fa-trash"></i> <span class="hidden md:inline">Mode Hapus</span>
                        </button>

                        <button type="submit" form="bulkDeleteForm"
                            class="px-3 py-2 md:px-4 md:py-2 bg-red-700 text-white rounded-lg hover:bg-red-800 text-xs md:text-sm hidden flex items-center gap-2 transition-colors"
                            id="deleteSelectedBtn">
                            <i class="fas fa-trash"></i> <span class="hidden md:inline">Hapus Terpilih</span>
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="w-full table-rounded">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden delete-col">
                                    <input type="checkbox" id="selectAll"
                                        class="rounded text-blue-600 focus:ring-blue-500">
                                </th>
                                <th
                                    class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pelanggan</th>
                                <th
                                    class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No Wa</th>
                                <th
                                    class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Servis</th>
                                <th
                                    class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Informasi Barang</th>

                                <th
                                    class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Proses</th>
                                <th
                                    class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ditangani Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="serviceBody">
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
                                <tr class="hover:bg-gray-50 transition-colors duration-150"
                                    data-status="{{ $service->status ?? 'belum' }}"
                                    data-proses="{{ $service->proses ?? 'belum' }}"
                                    data-search="{{ strtolower($service->nama_pelanggan . ' ' . $service->service_id) }}">
                                    <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden delete-col">
                                        <input type="checkbox"
                                            class="delete-checkbox rounded text-blue-600 focus:ring-blue-500"
                                            name="ids[]" value="{{ $service->id }}" form="bulkDeleteForm">
                                    </td>
                                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 truncate-mobile">
                                            {{ $service->nama_pelanggan }}</div>
                                    </td>
                                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 truncate-mobile">
                                            {{ $service->no_wa }}</div>
                                    </td>
                                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $service->service_id }}</span>
                                    </td>
                                    <td class="px-4 md:px-6 py-4">
                                        <div class="text-sm text-gray-900 truncate-mobile">
                                            {{ $service->jenis_barang }} - {{ $service->nama_barang }}</div>
                                        <div class="text-xs md:text-sm text-gray-500 mt-1 truncate">
                                            {{ Str::limit($service->kerusakan, 50) }}</div>
                                    </td>
                                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('service.updateProsesStatus') }}"
                                            id="proses-form-{{ $service->id }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $service->id }}">
                                            <select name="proses"
                                                onchange="checkProsesStatus(this, {{ $service->id }})"
                                                class="select-custom mobile-optimized-select"
                                                {{ $service->status === 'ditolak' ? 'disabled' : '' }}>
                                                <option value="">- Pilih -</option>
                                                <option value="barang diterima"
                                                    {{ $service->proses === 'barang diterima' ? 'selected' : '' }}>
                                                    Barang Diterima</option>
                                                <option value="barang sedang diperbaiki"
                                                    {{ $service->proses === 'barang sedang diperbaiki' ? 'selected' : '' }}>
                                                    Sedang Perbaikan</option>
                                                <option value="barang sudah selesai diperbaiki"
                                                    {{ $service->proses === 'barang sudah selesai diperbaiki' ? 'selected' : '' }}>
                                                    Selesai Diperbaiki</option>
                                                <option value="barang sudah selesai dan terbayar"
                                                    {{ $service->proses === 'barang sudah selesai dan terbayar' ? 'selected' : '' }}>
                                                    Terbayar</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                        @if ($service->status === 'ditolak')
                                            <span class="status-badge status-badge-ditolak">
                                                Ditolak
                                            </span>
                                            @if ($service->catatan)
                                                <p class="text-xs text-gray-500 mt-1 truncate">Catatan:
                                                    {{ $service->catatan }}</p>
                                            @endif
                                        @elseif ($service->status === 'diterima')
                                            <span class="status-badge status-badge-diterima">
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
                                                    class="select-custom mobile-optimized-select"
                                                    onchange="checkStatus(this, {{ $service->id }})">
                                                    <option value="">- Pilih -</option>
                                                    <option value="diterima"
                                                        {{ $service->status === 'diterima' ? 'selected' : '' }}>
                                                        Diterima
                                                    </option>
                                                    <option value="ditolak"
                                                        {{ $service->status === 'ditolak' ? 'selected' : '' }}>Ditolak
                                                    </option>
                                                </select>
                                            </form>
                                        @endif
                                    </td>
                                    <td
                                        class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate-mobile">
                                        {{ $service->handledBy ? $service->handledBy->name : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($totalPages > 1)
                    <div class="px-4 md:px-6 py-4 bg-gray-50 border-t">
                        <div class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($currentPage == 1)
                                <span class="pagination-link disabled">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="?page={{ $currentPage - 1 }}" class="pagination-link">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $start = max($currentPage - 2, 1);
                                $end = min($currentPage + 2, $totalPages);

                                if ($start > 1) {
                                    echo '<a href="?page=1" class="pagination-link">1</a>';
                                    if ($start > 2) {
                                        echo '<span class="pagination-ellipsis">...</span>';
                                    }
                                }

                                for ($i = $start; $i <= $end; $i++) {
                                    if ($i == $currentPage) {
                                        echo '<span class="pagination-link active">' . $i . '</span>';
                                    } else {
                                        echo '<a href="?page=' . $i . '" class="pagination-link">' . $i . '</a>';
                                    }
                                }

                                if ($end < $totalPages) {
                                    if ($end < $totalPages - 1) {
                                        echo '<span class="pagination-ellipsis">...</span>';
                                    }
                                    echo '<a href="?page=' .
                                        $totalPages .
                                        '" class="pagination-link">' .
                                        $totalPages .
                                        '</a>';
                                }
                            @endphp

                            {{-- Next Page Link --}}
                            @if ($currentPage == $totalPages)
                                <span class="pagination-link disabled">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @else
                                <a href="?page={{ $currentPage + 1 }}" class="pagination-link">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


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
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
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
<footer class="footer">
    @include('komponen.footer')
</footer>

</html>
