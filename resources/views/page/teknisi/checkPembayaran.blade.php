<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Pembayaran Servis</h1>

    <div class="border p-4 rounded mb-4">
        <p><strong>ID Servis:</strong> {{ $serviceDetail->service_id }}</p>

        <p><strong>Nama Sparepart:</strong> {{ $serviceDetail->nama_sparepart }}</p>
        <p><strong>Harga Sparepart:</strong> Rp{{ number_format($serviceDetail->harga_sparepart, 0, ',', '.') }}</p>
        <p><strong>Harga Jasa:</strong> Rp{{ number_format($serviceDetail->harga_jasa, 0, ',', '.') }}</p>
        <p><strong>Total Biaya:</strong> Rp{{ number_format($serviceDetail->total_biaya, 0, ',', '.') }}</p>
    </div>

    <h2 class="text-xl font-semibold mb-2">Pilih Metode Pembayaran:</h2>
    <form action="#" method="POST" class="space-y-3">
        @csrf
        <label class="block">
            <input type="radio" name="metode_pembayaran" value="cod" required>
            Bayar di Tempat (COD)
        </label>
        <label class="block">
            <input type="radio" name="metode_pembayaran" value="transfer" required>
            Transfer Bank
        </label>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
            Konfirmasi Pembayaran
        </button>
    </form>
</body>

</html>
