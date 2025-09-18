<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="p-6">
    <h1 class="text-2xl font-bold mb-4">Cek Pembayaran Servis</h1>

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('pembayaran.check') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="input_id" class="block">Masukkan ID Servis:</label>
            <input type="text" name="input_id" id="input_id" class="border rounded w-full p-2" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Cek Pembayaran
        </button>
    </form>

</body>

</html>
