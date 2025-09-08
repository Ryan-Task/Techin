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
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .modal {
            display: none;
        }

        .modal.active {
            display: flex;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    @include('komponen.sidebar')

    <main class="container mx-auto py-6 ">

        <!-- Header -->
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Servis</h1>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 px-4 py-2 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Grid Atas: Card User + Rating + Diagram -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            @foreach ($users as $user)
                <!-- Card Info + Rating (stack atas-bawah, compact) -->
                <div class="bg-white shadow rounded-lg p-6 flex flex-col">
                    <div class="flex items-center justify-between">
                        <div class="max-w-[75%]">
                            <p class="font-semibold text-gray-800 text-base truncate">Nama: {{ $user->name }}</p>
                            <p class="text-sm text-gray-500 truncate">Email: {{ $user->email }}</p>
                        </div>
                        <div class="text-blue-500 text-4xl shrink-0">
                            <i class="fa-regular fa-user-circle"></i>
                        </div>
                    </div>
                    <!-- Rating di bawah info user -->
                    <div class="mt-4 text-center">
                        <p class="font-semibold text-gray-800 text-base mb-2">Rata-rata Rating</p>
                        <div class="flex items-center justify-center space-x-1 mb-2 text-xl">
                            @php
                                $filledStars = floor($user->rating);
                                $halfStar = $user->rating - $filledStars >= 0.5;
                                $emptyStars = 5 - $filledStars - ($halfStar ? 1 : 0);
                            @endphp

                            @for ($i = 0; $i < $filledStars; $i++)
                                <i class="fas fa-star text-yellow-500"></i>
                            @endfor

                            @if ($halfStar)
                                <i class="fas fa-star-half-alt text-yellow-500"></i>
                            @endif

                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star text-yellow-500"></i>
                            @endfor
                        </div>
                        <p class="text-lg font-bold text-gray-700">{{ number_format($user->rating, 1) }}/5</p>
                    </div>
                </div>
            @endforeach

            <!-- Diagram Batang -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-base font-semibold mb-3 text-gray-700">Total Servis Per Hari</h2>
                <div class="h-48">
                    <canvas id="servisChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Filter + Search + Bulk Delete Controls -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Filter & Pencarian</h2>
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <select id="filterStatus"
                    class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-2">
                    <option value="">Semua Status</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="belum">Belum diisi</option>
                </select>

                <select id="filterProses"
                    class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-2">
                    <option value="">Semua Proses</option>
                    <option value="barang diterima">Barang Diterima</option>
                    <option value="barang sedang diperbaiki">Sedang Diperbaiki</option>
                    <option value="barang sudah selesai diperbaiki">Selesai Diperbaiki</option>
                    <option value="barang sudah selesai dan terbayar">Selesai & Terbayar</option>
                    <option value="belum">Belum diisi</option>
                </select>

                <input type="text" id="searchInput" placeholder="Cari nama pelanggan atau ID Servis..."
                    class="flex-1 border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2" />
            </div>

            <!-- Tombol Mode Hapus + Tombol Submit Bulk -->
            <div class="flex gap-2">
                <button id="toggleDeleteMode"
                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">Mode Hapus</button>

                <!-- Tombol submit bulk dikaitkan ke form terpisah lewat atribut 'form' -->
                <button type="submit" form="bulkDeleteForm"
                    class="px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800 text-sm hidden"
                    id="deleteSelectedBtn">Hapus Terpilih</button>
            </div>
        </div>

        <!-- FORM BULK DELETE TERPISAH (tidak membungkus tabel, menghindari nested forms) -->
        <form id="bulkDeleteForm" method="POST" action="{{ route('service.bulk-delete') }}">
            @csrf
            @method('DELETE')
            <!-- Tidak ada input di sini; checkbox di tabel menggunakan form="bulkDeleteForm" -->
        </form>

        <!-- Tabel Service Request -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Daftar Service Request</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                            <th class="px-4 py-3 border-b hidden delete-col">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th class="px-4 py-3 border-b">Pelanggan</th>
                            <th class="px-4 py-3 border-b">ID Servis</th>
                            <th class="px-4 py-3 border-b">Informasi Barang</th>
                            <th class="px-4 py-3 border-b">Proses</th>
                            <th class="px-4 py-3 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="serviceBody">
                        @foreach ($services->sortBy(function ($s) {
        return $s->status === 'ditolak' ? 1 : 0;
    }) as $service)
                            <tr class="hover:bg-gray-50 transition" data-status="{{ $service->status ?? 'belum' }}"
                                data-proses="{{ $service->proses ?? 'belum' }}"
                                data-search="{{ strtolower($service->nama_pelanggan . ' ' . $service->service_id) }}">
                                <td class="px-4 py-3 hidden delete-col">
                                    <!-- Checkbox dikaitkan ke form bulk lewat atribut form -->
                                    <input type="checkbox" class="delete-checkbox" name="ids[]"
                                        value="{{ $service->id }}" form="bulkDeleteForm">
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $service->nama_pelanggan }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $service->service_id }}</td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $service->jenis_barang }} - {{ $service->nama_barang }}
                                    <p class="text-xs text-gray-500">{{ $service->kerusakan }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('service.updateProsesStatus') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $service->id }}">
                                        <select name="proses" onchange="this.form.submit()"
                                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-2"
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
                                        <span class="px-3 py-2 text-sm font-semibold text-red-600 bg-red-100 rounded">
                                            Ditolak
                                        </span>
                                        @if ($service->catatan)
                                            <p class="text-xs text-gray-500 mt-1">Catatan: {{ $service->catatan }}</p>
                                        @endif
                                    @else
                                        <form method="POST" action="{{ route('service.updateProsesStatus') }}"
                                            id="status-form-{{ $service->id }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $service->id }}">
                                            <input type="hidden" name="catatan"
                                                id="catatan-input-{{ $service->id }}">
                                            <select name="status" id="status-select-{{ $service->id }}"
                                                class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-2"
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    @include('komponen.footer')

    <!-- Modal Catatan -->
    <div id="catatan-modal" class="modal fixed inset-0 bg-transparent justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 class="text-lg font-semibold mb-4">Masukkan Catatan Penolakan</h2>
            <textarea id="catatan-textarea"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 px-3 py-2 text-sm"
                rows="3" placeholder="Tuliskan alasan penolakan..."></textarea>
            <div class="mt-4 flex justify-end gap-2">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
                <button onclick="submitCatatan()"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Script ChartJS + Filter + Delete -->
    <script>
        const ctx = document.getElementById('servisChart').getContext('2d');
        const rawData = @json(
            $services->map(function ($s) {
                return \Carbon\Carbon::parse($s->created_at)->format('Y-m-d');
            }));

        const counts = {};
        rawData.forEach(date => {
            counts[date] = (counts[date] || 0) + 1;
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(counts),
                datasets: [{
                    label: 'Jumlah Servis',
                    data: Object.values(counts),
                    borderWidth: 1,
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: 11,
                                weight: 'bold'
                            },
                            color: '#1f2937'
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
                        }
                    }
                }
            }
        });

        let currentServiceId = null;

        function checkStatus(select, id) {
            if (select.value === 'ditolak') {
                currentServiceId = id;
                document.getElementById('catatan-modal').classList.add('active');
            } else {
                document.getElementById(`status-form-${id}`).submit();
            }
        }

        function closeModal() {
            document.getElementById('catatan-modal').classList.remove('active');
            document.getElementById('catatan-textarea').value = '';
            if (currentServiceId) {
                document.getElementById(`status-select-${currentServiceId}`).value = 'diterima';
            }
        }

        function submitCatatan() {
            const note = document.getElementById('catatan-textarea').value.trim();
            if (!note) {
                alert("Catatan penolakan wajib diisi.");
                return;
            }
            document.getElementById(`catatan-input-${currentServiceId}`).value = note;
            document.getElementById(`status-form-${currentServiceId}`).submit();
            closeModal();
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

                const matchStatus = !status || rowStatus === status;
                const matchProses = !proses || rowProses === proses;
                const matchSearch = !search || rowSearch.includes(search);

                row.style.display = (matchStatus && matchProses && matchSearch) ? "" : "none";
            });
        }

        filterStatus.addEventListener("change", applyFilters);
        filterProses.addEventListener("change", applyFilters);
        searchInput.addEventListener("keyup", applyFilters);

        // Mode Hapus (toggle kolom checkbox + tombol submit bulk)
        const toggleDeleteMode = document.getElementById("toggleDeleteMode");
        const deleteSelectedBtn = document.getElementById("deleteSelectedBtn");
        const deleteCols = document.querySelectorAll(".delete-col");

        let deleteMode = false;
        toggleDeleteMode.addEventListener("click", () => {
            deleteMode = !deleteMode;
            deleteCols.forEach(col => col.classList.toggle("hidden", !deleteMode));
            deleteSelectedBtn.classList.toggle("hidden", !deleteMode);
        });

        // Select All untuk checkbox bulk
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.delete-checkbox').forEach(cb => cb.checked = selectAll.checked);
            });
        }

        // Validasi submit bulk delete (form method: DELETE via spoofing)
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');
        bulkDeleteForm.addEventListener('submit', function(e) {
            const checked = Array.from(document.querySelectorAll('.delete-checkbox:checked'));
            if (checked.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu data untuk dihapus!');
                return;
            }
            if (!confirm('Yakin hapus data terpilih?')) {
                e.preventDefault();
            }
        });
    </script>
</body>

</html>
