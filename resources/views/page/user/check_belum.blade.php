<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Belum Dikonfirmasi</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-yellow-50 to-yellow-100 min-h-screen flex flex-col">

@include('komponen.sidebar')

<main class="lg:ml-20 p-6 min-h-screen">
  <!-- Wrapper -->
  <div class="grid lg:grid-cols-3 gap-4">
    
    <!-- Kolom Kiri -->
    <div class="lg:col-span-2 space-y-4">
      
      <!-- Status -->
      <div class="border rounded-md p-4 bg-white shadow-sm">
        <div class="flex items-center gap-2 border-b pb-2 mb-3">
          <div class="bg-yellow-100 text-yellow-700 p-2 rounded-full">
            <!-- Icon Jam -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h2 class="font-semibold text-gray-800">Barang Belum Dikonfirmasi</h2>
        </div>
        <p class="text-sm text-gray-600">
          Barang Anda sudah diterima, tetapi masih menunggu konfirmasi dari admin/teknisi.
        </p>
      </div>

      <!-- Rincian Transaksi -->
      <div class="border rounded-md p-4 bg-white shadow-sm grid md:grid-cols-2 gap-4">
        <div>
          <h3 class="font-semibold mb-2">Rincian Transaksi</h3>
          <p><span class="font-medium">Status:</span> <span class="text-yellow-700">Belum Dikonfirmasi</span></p>
          <p><span class="font-medium">Tanggal Diterima:</span> - </p>
          <p><span class="font-medium">Tanggal Estimasi Konfirmasi:</span> - </p>
          <p><span class="font-medium">ID Servis:</span> 1506C7F52931</p>
          <p><span class="font-medium">Detail Barang:</span> Laptop Lenovo</p>
          <p><span class="font-medium">Nama Pelanggan:</span> RYAN</p>
        </div>
        <div>
          <h3 class="font-semibold mb-2">Detail Biaya</h3>
          <p class="text-gray-500 text-sm">Biaya akan muncul setelah barang dikonfirmasi.</p>
        </div>
      </div>

      <!-- Info Teknisi -->
      <div class="border rounded-md p-4 bg-white shadow-sm">
        <h3 class="font-semibold mb-2">Teknisi</h3>
        <p class="text-sm text-gray-500">Belum ada teknisi yang ditugaskan.</p>
      </div>

      <!-- Ucapan -->
      <div class="border rounded-md p-4 bg-yellow-50 shadow-sm">
        <h3 class="font-semibold mb-2 text-yellow-700">Mohon Tunggu</h3>
        <p class="text-sm text-gray-700">Barang Anda sedang menunggu proses konfirmasi oleh admin/teknisi.</p>
      </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="space-y-4">
      <div class="border rounded-md p-4 bg-white shadow-sm">
        <h3 class="font-semibold mb-2">Runtutan Proses</h3>
        <div class="space-y-4">
          <div class="flex items-center gap-2 font-semibold text-yellow-700">
            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
            <span>Menunggu Konfirmasi</span>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@include('komponen.footer')

</body>
</html>
