<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diterima</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen flex flex-col">

@include('komponen.sidebar')

<main class="lg:ml-20 p-6 min-h-screen">
  <!-- Wrapper -->
  <div class="grid lg:grid-cols-3 gap-4">
    
    <!-- Kolom Kiri -->
    <div class="lg:col-span-2 space-y-4">
      
    <!-- Status -->
      <div class="border rounded-md p-4 bg-white shadow-sm">
        <div class="flex items-center gap-2 border-b pb-2 mb-3">
          <div class="bg-teal-100 text-teal-700 p-2 rounded-full">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h2 class="font-semibold text-gray-800">Barang Diterima</h2>
        </div>
        <p class="text-sm text-gray-600">
          Nantikan informasi selanjutnya melalui WhatsApp maupun notifikasi jika barang sudah selesai
        </p>
      </div>


       <!-- Rincian Transaksi -->
      <div class="border rounded-md p-4 bg-white shadow-sm grid md:grid-cols-2 gap-4">
        <div>
          <h3 class="font-semibold mb-2">Rincian Transaksi</h3>
          <p><span class="font-medium">Status:</span> <span class="text-teal-700">Barang Diterima Oleh Teknisi</span></p>
          <p><span class="font-medium">Tanggal Diterima:</span> 18 Juni 2025, 23:14 WIB</p>
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
            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
            <span>19 Juni - Barang Sedang Diperbaiki</span>
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
            <span>21 Juni - Barang Diambil</span>
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
            <span>21 Juni - Selesai</span>
          </div>
        </div>
        <div class="mt-4">
          <p class="font-medium">Perkiraan Barang Selesai</p>
          <p class="text-sm text-gray-600">21 Juni 2025, 03:38 WIB</p>
        </div>
      </div>
    </div>
  </div>
</main>

@include('komponen.footer')

</body>
</html>
