<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Servis</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col">

    {{-- Sidebar --}}
    <div>
        @include('komponen.sidebar')
    </div>

    <!-- Konten utama -->
    <main class="flex-1 flex items-center justify-center">
        <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6 border border-gray-300">
            <h2 class="text-lg font-semibold mb-4 text-center">Cek Status Servis</h2>
            
            <!-- Form -->
            <form class="flex gap-2">
                <input type="text" placeholder="Masukkan ID Pesanan / No. WhatsApp" 
                       class="flex-1 border border-gray-400 rounded px-3 py-2 focus:outline-none">
                <button type="submit" class="bg-teal-900 text-white px-5 py-2 rounded hover:bg-teal-700">
                    Periksa
                </button>
            </form>

            <!-- Info tambahan -->
            <p class="text-gray-600 text-sm mt-4 text-center">
                Masukkan ID Pesanan atau nomor WhatsApp Anda untuk melacak status servis barang.
            </p>

       <!-- Timeline servis -->
<div class="mt-6">
    <h3 class="font-semibold mb-2 text-sm">Tahapan Proses Servis:</h3>
    
    <div class="relative flex items-center justify-between">
        <!-- Garis lurus -->
        <div class="absolute left-0 right-0 top-5 h-[2px] bg-gray-300"></div>

        <!-- Step 1 -->
        <div class="flex flex-col items-center relative z-10 bg-white px-2">
            <i class="fa-solid fa-box text-blue-600 text-xl"></i>
            <p class="text-xs mt-1">Barang Masuk</p>
        </div>

    <!-- Step 2 -->
<div class="flex flex-col items-center relative z-10 bg-white px-2">
    <i class="fa-solid fa-handshake text-green-600 text-xl"></i>
    <p class="text-xs mt-1">Diterima</p>
</div>


        <!-- Step 3 -->
        <div class="flex flex-col items-center relative z-10 bg-white px-2">
            <i class="fa-solid fa-screwdriver-wrench text-yellow-500 text-xl"></i>
            <p class="text-xs mt-1">Perbaikan</p>
        </div>

        <!-- Step 4 -->
        <div class="flex flex-col items-center relative z-10 bg-white px-2">
            <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
            <p class="text-xs mt-1">Selesai</p>
        </div>
    </div>
</div>



            <!-- Kontak -->
            <div class="mt-6 text-sm text-gray-700 text-center">
                <p>Butuh bantuan? Hubungi admin di 
                    <a href="https://wa.me/628xxxxxx" target="_blank" class="text-teal-700 font-semibold">
                        WhatsApp
                    </a>
                </p>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer>
        @include('komponen.footer')
    </footer>

</body>
</html>
