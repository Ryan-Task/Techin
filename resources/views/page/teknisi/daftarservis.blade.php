<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Servis</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

  <!-- Sidebar -->
  @include('komponen.sidebar')

  <!-- Konten + Footer -->
  <div class="flex-1 flex flex-col">

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-start p-6">

      <!-- Bungkus konten agar lebih kecil dan center -->
      <div class="w-full max-w-6xl space-y-6">

        <!-- 3 Card Atas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Card Profil -->
          <div class="bg-white rounded-xl shadow-md p-4 flex justify-between items-center">
            <div>
              <h2 class="font-semibold text-lg">Nama Akun: Arif</h2>
              <p class="text-gray-600">Email: rif@gmail.com</p>
            </div>
            <div class="text-4xl text-gray-500">
              <i class="fas fa-user-circle"></i>
            </div>
          </div>

          <!-- Card Rating -->
          <div class="bg-white rounded-xl shadow-md p-4">
            <h2 class="font-semibold text-lg mb-2">Rata Rata Rating</h2>
            <div class="flex items-center space-x-2">
              <span class="text-yellow-400 text-2xl">★★★★☆</span>
            </div>
            <p class="mt-2 font-bold">4.0/5</p>
          </div>

          <!-- Card Total Servis -->
          <div class="bg-white rounded-xl shadow-md p-4 flex justify-between items-center">
            <div>
              <h2 class="font-semibold text-lg">Total Servis</h2>
              <p class="text-3xl font-bold">129</p>
              <p class="text-gray-600 text-sm">Rata Rata 20/bln</p>
            </div>
            <div class="text-4xl text-blue-500">
              <i class="fas fa-chart-line"></i>
            </div>
          </div>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-md p-4">
          <!-- Search Bar -->
          <div class="mb-4">
            <input type="text" placeholder="Search..."
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
          </div>

          <!-- Tabel -->
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-gray-100 text-gray-700">
                  <th class="p-3"><input type="checkbox"></th>
                  <th class="p-3">Pelanggan</th>
                  <th class="p-3">ID Servis</th>
                  <th class="p-3">Informasi Pelanggan</th>
                  <th class="p-3">Proses</th>
                  <th class="p-3">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-b hover:bg-gray-50">
                  <td class="p-3"><input type="checkbox"></td>
                  <td class="p-3">Ryan</td>
                  <td class="p-3">1506C7F52931</td>
                  <td class="p-3 text-blue-500">Informasi Pelanggan</td>
                  <td class="p-3">Menunggu Diambil</td>
                  <td class="p-3">
                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-sm font-semibold">Ditolak ✖</span>
                  </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                  <td class="p-3"><input type="checkbox"></td>
                  <td class="p-3">Bagus</td>
                  <td class="p-3">1506C89E3272</td>
                  <td class="p-3 text-blue-500">Informasi Pelanggan</td>
                  <td class="p-3">Diperiksa</td>
                  <td class="p-3">
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-sm font-semibold">Diterima ✔</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="flex justify-center items-center mt-4 space-x-2">
            <button class="px-3 py-1 bg-gray-200 rounded-lg">&lt;</button>
            <button class="px-3 py-1 bg-gray-200 rounded-lg">1</button>
            <button class="px-3 py-1 bg-gray-300 rounded-lg font-bold">2</button>
            <button class="px-3 py-1 bg-gray-200 rounded-lg">3</button>
            <span>...</span>
            <button class="px-3 py-1 bg-gray-200 rounded-lg">17</button>
            <button class="px-3 py-1 bg-gray-200 rounded-lg">18</button>
            <button class="px-3 py-1 bg-gray-200 rounded-lg">19</button>
            <button class="px-3 py-1 bg-gray-200 rounded-lg">&gt;</button>
          </div>
        </div>

      </div>
    </main>

    <!-- Footer -->
    @include('komponen.footer')

  </div>
</body>
</html>
