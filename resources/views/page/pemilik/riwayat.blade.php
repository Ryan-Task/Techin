<!DOCTYPE html>
<html lang="id" x-data="{ activeTab: 'selesai' }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Riwayat Servis - Pemilik</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="">
    @include('komponen.sidebar')
    <div class="bg-gray-100 min-h-screen p-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold mb-4">Riwayat Servis</h1>

            <!-- Diagram + Filter teknisi -->
            <div class="flex items-start justify-between mb-6">
                <!-- Diagram bulat di kiri -->
                <div class="w-64 h-64 bg-white p-4 rounded shadow">
                    <canvas id="statusChart"></canvas>
                </div>

                <!-- Filter teknisi -->
                <form method="GET" class="flex items-center gap-3">
                    <label for="teknisi" class="font-medium">Pilih Teknisi:</label>
                    <select name="teknisi_id" id="teknisi" class="border rounded px-3 py-2">
                        <option value="">Semua Teknisi</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ request('teknisi_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Terapkan</button>
                </form>
            </div>

            <div class="mb-4 flex gap-3">
                <button @click="activeTab = 'selesai'"
                    :class="activeTab === 'selesai' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-800'"
                    class="px-4 py-2 rounded">Selesai</button>

                <button @click="activeTab = 'tidak'"
                    :class="activeTab === 'tidak' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800'"
                    class="px-4 py-2 rounded">Tidak Selesai / Ditolak</button>
            </div>

            <!-- Selesai -->
            <div x-show="activeTab === 'selesai'">
                @if ($selesai->isEmpty())
                    <div class="bg-white p-6 rounded shadow">
                        <p class="text-gray-600">Belum ada riwayat servis selesai.</p>
                    </div>
                @else
                    <div class="bg-white rounded shadow p-4 overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-2 text-left">ID Servis</th>
                                    <th class="p-2 text-left">Pelanggan</th>
                                    <th class="p-2 text-left">Barang</th>
                                    <th class="p-2 text-left">Harga Sparepart</th>
                                    <th class="p-2 text-left">Harga Jasa</th>
                                    <th class="p-2 text-left">Total Biaya</th>
                                    <th class="p-2 text-left">Teknisi</th>
                                    <th class="p-2 text-left">Rating</th>
                                    <th class="p-2 text-left">Ulasan</th>
                                    <th class="p-2 text-left">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selesai as $srv)
                                    <tr class="border-t">
                                        <td class="p-2">{{ $srv->service_id }}</td>
                                        <td class="p-2">{{ $srv->nama_pelanggan }}</td>
                                        <td class="p-2">{{ $srv->jenis_barang }} — {{ $srv->nama_barang }}</td>
                                        <td class="p-2">
                                            @if ($srv->detail && isset($srv->detail->harga_sparepart))
                                                Rp{{ number_format($srv->detail->harga_sparepart, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="p-2">
                                            @if ($srv->detail && isset($srv->detail->harga_jasa))
                                                Rp{{ number_format($srv->detail->harga_jasa, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="p-2">
                                            @if ($srv->detail)
                                                Rp{{ number_format($srv->detail->total_biaya, 0, ',', '.') }}
                                            @elseif(!empty($srv->biaya))
                                                Rp{{ number_format($srv->biaya, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="p-2">{{ $srv->handledBy->name ?? '-' }}</td>
                                        <td class="p-2">
                                            @if (!empty($srv->rating))
                                                {{ $srv->rating }} / 5
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="p-2">
                                            {{ $srv->ulasan ?? '-' }}
                                        </td>
                                        <td class="p-2">
                                            {{ \Carbon\Carbon::parse($srv->updated_at)->translatedFormat('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Tidak Selesai / Ditolak -->
            <div x-show="activeTab === 'tidak'" x-cloak class="mt-6">
                @if ($tidakSelesai->isEmpty())
                    <div class="bg-white p-6 rounded shadow">
                        <p class="text-gray-600">Belum ada riwayat servis ditolak / tidak selesai.</p>
                    </div>
                @else
                    <div class="bg-white rounded shadow p-4 overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-2 text-left">ID Servis</th>
                                    <th class="p-2 text-left">Pelanggan</th>
                                    <th class="p-2 text-left">Barang</th>
                                    <th class="p-2 text-left">Teknisi</th>
                                    <th class="p-2 text-left">Catatan</th>
                                    <th class="p-2 text-left">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tidakSelesai as $srv)
                                    <tr class="border-t">
                                        <td class="p-2">{{ $srv->service_id }}</td>
                                        <td class="p-2">{{ $srv->nama_pelanggan }}</td>
                                        <td class="p-2">{{ $srv->jenis_barang }} — {{ $srv->nama_barang }}</td>
                                        <td class="p-2">{{ $srv->handledBy->name ?? '-' }}</td>
                                        <td class="p-2">{{ $srv->catatan ?? '-' }}</td>
                                        <td class="p-2">
                                            {{ \Carbon\Carbon::parse($srv->updated_at)->translatedFormat('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <script>
            const selesaiCount = {{ $selesai->count() }};
            const tidakCount = {{ $tidakSelesai->count() }};

            const ctx = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Selesai', 'Ditolak'],
                    datasets: [{
                        data: [selesaiCount, tidakCount],
                        backgroundColor: ['#16a34a', '#dc2626'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        </script>
    </div>
</body>

</html>
