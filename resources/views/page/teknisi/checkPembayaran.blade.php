<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 font-sans">
    @include('komponen.sidebar')

    <div class="p-8 min-h-screen flex items-center justify-center">
        <div class="w-full max-w-lg bg-white shadow-lg rounded-xl p-8" x-data="{ type: 'id' }">
            <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">
                <i class="fa-solid fa-money-check-dollar text-blue-700 mr-2"></i>
                Cek Pembayaran Servis
            </h1>

            <!-- Alert Error -->
            @if (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('pembayaran.check') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilih input pakai toggle -->
                <div class="flex justify-center space-x-4 mb-4">
                    <button type="button" @click="type = 'id'"
                        :class="type === 'id' ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-600'"
                        class="px-4 py-2 rounded-lg transition">
                        <i class="fa-solid fa-id-card mr-1"></i> ID Servis
                    </button>
                    <button type="button" @click="type = 'wa'"
                        :class="type === 'wa' ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-600'"
                        class="px-4 py-2 rounded-lg transition">
                        <i class="fa-brands fa-whatsapp mr-1"></i> No. WA
                    </button>
                </div>

                <!-- Input ID Servis -->
                <div x-show="type === 'id'">
                    <label for="service_id" class="block text-gray-700 font-medium mb-2">Masukkan ID Servis</label>
                    <input type="text" x-bind:name="type === 'id' ? 'keyword' : null"
                        placeholder="Contoh: SV-20250910-AB12"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300">
                </div>

                <!-- Input No. WA -->
                <div x-show="type === 'wa'">
                    <label for="no_wa" class="block text-gray-700 font-medium mb-2">Masukkan No. WA</label>
                    <input type="text" x-bind:name="type === 'wa' ? 'keyword' : null"
                        placeholder="Contoh: 081234567890"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300">
                </div>

                <!-- Tombol -->
                <div class="text-center">
                    <button type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
                        <i class="fa-solid fa-magnifying-glass mr-2"></i> Cek Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
<footer class="footer">
    @include('komponen.footer')
</footer>

</html>
