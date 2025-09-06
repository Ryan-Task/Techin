<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bisa Diambil</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @media (max-width: 768px) {
      .form-container {
        margin-left: 0;
        width: 100%;
        padding: 1rem;
      }

      .sidebar~.content-area {
        margin-left: 0;
      }
    }

    /* Animasi masuk */
    @keyframes fadeSlideUp {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-form {
      animation: fadeSlideUp 0.6s ease-out;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col">

@include('komponen.sidebar')

<main class="lg:ml-20 p-6 min-h-screen">
  <div class="grid lg:grid-cols-3 gap-4">
    
    <!-- Kolom Kiri (Rincian Transaksi + Teknisi) -->
    <div class="lg:col-span-2 space-y-4">
      
      <!-- Status -->
      <div class="border rounded-md p-4 bg-white shadow-sm">
        <div class="flex items-center gap-2 border-b pb-2 mb-3">
          <!-- Icon dalam lingkaran sempurna -->
          <div class="w-9 h-9 flex items-center justify-center bg-blue-100 text-blue-700 rounded-full">
            <i class="fas fa-box-open text-lg"></i>
          </div>
          <h2 class="font-semibold text-gray-800">Barang Sudah Bisa Diambil</h2>
        </div>
        <p class="text-sm text-gray-600">
          Barang Anda sudah selesai diperbaiki dan dapat segera diambil di tempat servis.
          Silakan hubungi teknisi untuk konfirmasi waktu pengambilan.
        </p>
      </div>
      

      <!-- Rincian Transaksi -->
      <div class="border rounded-md p-4 bg-white shadow-sm grid md:grid-cols-2 gap-4">
        <div>
          <h3 class="font-semibold mb-2">Rincian Transaksi</h3>
          <p><span class="font-medium">Status:</span> <span class="text-blue-700">Sudah Bisa Diambil</span></p>
          <p><span class="font-medium">Tanggal Update:</span> 21 Juni 2025, 10:00 WIB</p>
          <p><span class="font-medium">ID Servis:</span> 1506C7F52931</p>
          <p><span class="font-medium">Detail Barang:</span> Laptop Lenovo</p>
          <p><span class="font-medium">Nama Pelanggan:</span> RYAN</p>
        </div>
        <div>
          <h3 class="font-semibold mb-2">Detail Biaya</h3>
          <p class="flex justify-between"><span>Biaya Jasa & Spare Part</span> <span>-</span></p>
          <p class="flex justify-between"><span>Biaya Tambahan</span> <span>-</span></p>
          <hr class="my-2">
          <p class="flex justify-between font-semibold"><span>Total</span> <span>-</span></p>
        </div>
      </div>

      <!-- Info Teknisi -->
      <div class="border rounded-md p-4 bg-white shadow-sm">
        <h3 class="font-semibold mb-2">Teknisi</h3>
        <p><span class="font-medium">Nama:</span> Aryanto Tri Nashrullah</p>
        <p><span class="font-medium">No. WA:</span> 0893251783</p>
        <div class="flex items-center mt-2">
          <span class="font-medium mr-2">Rating:</span>
          ⭐⭐⭐⭐☆
          <span class="ml-2 text-sm text-gray-600">4.0/5</span>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan (Runtutan Proses) -->
    <div class="space-y-4">
      <div class="border rounded-md p-4 bg-white shadow-sm">
        <h3 class="font-semibold mb-2">Runtutan Proses</h3>
        <div class="space-y-4">
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
            <span>18 Juni - Barang Diterima</span>
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
            <span>19 Juni - Barang Sedang Diperbaiki</span>
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
            <span>21 Juni - Barang Bisa Diambil</span>
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
            <span>21 Juni - Selesai</span>
          </div>
        </div>
        <div class="mt-4">
          <p class="font-medium">Batas Waktu Pengambilan</p>
          <p class="text-sm text-gray-600">24 Juni 2025, 17:00 WIB</p>
        </div>
      </div>
    </div>
  </div>
</main>

</html>
@include('komponen.footer')
