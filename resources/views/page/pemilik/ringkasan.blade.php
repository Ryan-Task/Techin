<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Servis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Ringkasan Servis</h1>

        <!-- Filter Teknisi -->
        <form method="GET" class="mb-4 flex space-x-2">
            <select name="teknisi_id" class="border rounded px-3 py-2">
                <option value="">-- Semua Teknisi --</option>
                @foreach ($users as $u)
                    <option value="{{ $u->id }}" {{ request('teknisi_id') == $u->id ? 'selected' : '' }}>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Filter</button>
        </form>

        <!-- Ringkasan Card -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold">Total Selesai</h2>
                <p class="text-3xl font-bold text-green-600">{{ $totalSelesai }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold">Total Tidak Selesai</h2>
                <p class="text-3xl font-bold text-red-600">{{ $totalTidakSelesai }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold">Total Teknisi</h2>
                <p class="text-3xl font-bold text-blue-600">{{ $totalTeknisi }}</p>
            </div>
        </div>

        <!-- Tabel Selesai -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <h2 class="text-lg font-semibold mb-4">Servis Selesai</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Nama Pelanggan</th>
                        <th class="border px-4 py-2">Barang</th>
                        <th class="border px-4 py-2">Teknisi</th>
                        <th class="border px-4 py-2">Update</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($selesai as $s)
                        <tr>
                            <td class="border px-4 py-2">{{ $s->service_id }}</td>
                            <td class="border px-4 py-2">{{ $s->nama_pelanggan }}</td>
                            <td class="border px-4 py-2">{{ $s->nama_barang }}</td>
                            <td class="border px-4 py-2">{{ $s->handledBy->name ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $s->updated_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-2">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel Tidak Selesai -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-4">Servis Tidak Selesai</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Nama Pelanggan</th>
                        <th class="border px-4 py-2">Barang</th>
                        <th class="border px-4 py-2">Teknisi</th>
                        <th class="border px-4 py-2">Update</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tidakSelesai as $t)
                        <tr>
                            <td class="border px-4 py-2">{{ $t->service_id }}</td>
                            <td class="border px-4 py-2">{{ $t->nama_pelanggan }}</td>
                            <td class="border px-4 py-2">{{ $t->nama_barang }}</td>
                            <td class="border px-4 py-2">{{ $t->handledBy->name ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $t->updated_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-2">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
