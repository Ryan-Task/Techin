<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

@include('komponen.sidebar')

<body class="">

    <div class="ml-32">
        <h2 class="text-2xl font-bold mb-6">Cek Pembayaran Servis</h2>

        <!-- Tampilkan error jika ada -->
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('pembayaran.check') }}" method="POST"
            class="space-y-4 bg-white p-6 rounded shadow-md max-w-md">
            @csrf

            <label class="block">
                <span class="font-medium">Masukkan ID Servis:</span>
                <input type="text" name="service_id" class="border rounded p-2 w-full mt-1"
                    placeholder="Contoh: 12345" required>
            </label>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                Lanjutkan
            </button>
        </form>
    </div>
</body>

</html>
