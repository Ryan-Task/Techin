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
    <style>
        .fade-enter {
            opacity: 0;
            transform: translateY(10px);
        }

        .fade-enter-active {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans min-h-screen">
    @include('komponen.sidebar')

    <div class="lg:ml-30 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Servis</h1>
                <p class="text-gray-600">Lihat analisis dan riwayat performa servis</p>
            </div>

            <!-- Diagram + Filter Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                    <!-- Diagram Status -->
                    <div class="w-64 h-64 bg-white rounded-lg p-4">
                        <canvas id="statusChart"></canvas>
                    </div>

                    <!-- Filter Teknisi -->
                    <div class="flex-1 max-w-md">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Teknisi</h3>
                        <form method="GET" class="flex gap-4">
                            <select name="teknisi_id"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Teknisi</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('teknisi_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                Terapkan
                            </button>
                            @if (request('teknisi_id'))
                                <a href="{{ url()->current() }}"
                                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="mb-6">
                <div class="flex gap-3">
                    <button @click="activeTab = 'selesai'"
                        :class="activeTab === 'selesai' ? 'bg-blue-500 text-white' :
                            'bg-gray-200 text-gray-800 hover:bg-gray-300'"
                        class="px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-check-circle mr-2"></i>Servis Selesai
                    </button>

                    <button @click="activeTab = 'tidak'"
                        :class="activeTab === 'tidak' ? 'bg-red-500 text-white' :
                            'bg-gray-200 text-gray-800 hover:bg-gray-300'"
                        class="px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-times-circle mr-2"></i>Tidak Selesai / Ditolak
                    </button>
                </div>
            </div>

            <!-- Tab Content Selesai -->
            <div x-show="activeTab === 'selesai'" x-transition:enter="fade-enter"
                x-transition:enter-active="fade-enter-active">
                @if ($selesai->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="mx-auto w-24 h-24 mb-4 text-gray-300">
                            <i class="fas fa-check-circle text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada riwayat servis selesai</h3>
                        <p class="text-gray-500">Servis yang telah selesai akan muncul di sini.</p>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID Servis
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pelanggan
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Barang
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga Sparepart
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga Jasa
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Biaya
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Teknisi
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rating
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ulasan
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($selesai as $srv)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $srv->service_id }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $srv->nama_pelanggan }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $srv->jenis_barang }}</div>
                                                <div class="text-sm text-gray-500">{{ $srv->nama_barang }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if ($srv->detail && isset($srv->detail->harga_sparepart))
                                                    Rp{{ number_format($srv->detail->harga_sparepart, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if ($srv->detail && isset($srv->detail->harga_jasa))
                                                    Rp{{ number_format($srv->detail->harga_jasa, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    @if ($srv->detail)
                                                        Rp{{ number_format($srv->detail->total_biaya, 0, ',', '.') }}
                                                    @elseif(!empty($srv->biaya))
                                                        Rp{{ number_format($srv->biaya, 0, ',', '.') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $srv->handledBy->name ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if (!empty($srv->rating))
                                                    <div class="flex items-center">
                                                        <span class="text-yellow-400">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="fas fa-star{{ $i <= $srv->rating ? '' : '-empty' }} text-sm"></i>
                                                            @endfor
                                                        </span>
                                                        <span
                                                            class="ml-1 text-xs text-gray-600">{{ $srv->rating }}/5</span>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                                    {{ $srv->ulasan ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($srv->updated_at)->translatedFormat('d M Y, H:i') }}
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
            <div x-show="activeTab === 'tidak'" x-transition:enter="fade-enter"
                x-transition:enter-active="fade-enter-active" x-cloak>
                @if ($tidakSelesai->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="mx-auto w-24 h-24 mb-4 text-gray-300">
                            <i class="fas fa-times-circle text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada riwayat servis ditolak / tidak
                            selesai</h3>
                        <p class="text-gray-500">Servis yang tidak selesai akan muncul di sini.</p>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID Servis
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pelanggan
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Barang
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Teknisi
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Catatan
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($tidakSelesai as $srv)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $srv->service_id }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $srv->nama_pelanggan }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $srv->jenis_barang }}</div>
                                                <div class="text-sm text-gray-500">{{ $srv->nama_barang }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $srv->handledBy->name ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                                    {{ $srv->catatan ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($srv->updated_at)->translatedFormat('d M Y, H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                        borderColor: ['#15803d', '#b91c1c'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
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
