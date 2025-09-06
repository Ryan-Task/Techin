<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col">

  <div class="flex flex-1">
    <!-- Sidebar -->
    @include('komponen.sidebar')

    <!-- Konten Utama -->
    <main class="flex-1 p-6 flex items-center justify-center">
      <div class="max-w-5xl w-full bg-white rounded-2xl shadow-xl p-8 grid md:grid-cols-2 gap-8">
        
        <!-- Bagian Kiri: ID Pesanan -->
        <div class="space-y-6">
          <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">Cek Pesanan</h2>
          
          <div class="space-y-4">
            <label class="block text-gray-700 font-medium">Masukkan ID Pesanan / No. Whatsapp</label>
            <div class="flex gap-2">
              <input type="text" placeholder="Contoh: 1506C7F52931" 
                     class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
              <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Periksa</button>
            </div>
          </div>

          <!-- Detail Pesanan -->
          <div class="bg-gray-50 border rounded-lg p-5">
            <h3 class="font-semibold text-gray-700 mb-2">Detail Pesanan</h3>
            <p class="text-gray-500 text-sm">Data pesanan akan muncul di sini setelah ID diperiksa.</p>
          </div>
        </div>

        <!-- Bagian Kanan: Pembayaran -->
        <div class="space-y-6">
          <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">Metode Pembayaran</h2>
          
          <!-- Dropdown -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Pilih Metode</label>
            <select class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-400 outline-none">
              <option value="">-- Pilih Metode Pembayaran --</option>
              <option value="ewallet">E-Wallet</option>
              <option value="bank">Transfer Bank</option>
              <option value="cod">COD (Bayar di Tempat)</option>
            </select>
          </div>

          <!-- Detail Pembayaran -->
          <div class="bg-gray-50 border rounded-lg p-5">
            <h3 class="font-semibold text-gray-700 mb-2">Detail Pembayaran</h3>
            <ul class="text-gray-600 text-sm space-y-1">
              <li>info: <span class="font-medium">Mohon masukan id pesanan/nomor whatsapp untuk melihat total harga</span></li>
            </ul>
          </div>

          <!-- Tombol Bayar -->
          <button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition text-lg shadow-md">
            Bayar Sekarang
          </button>
        </div>

      </div>
    </main>
  </div>

  <!-- Footer sticky -->
  @include('komponen.footer')

</body>
</html>
