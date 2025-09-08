<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History Service</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

  <!-- Wrapper Sidebar + Konten -->
  <div class="flex flex-1">
    @include('komponen.sidebar')x

    <main class="flex-1 flex justify-center items-center p-6">
      <div class="bg-white rounded-xl shadow-md p-6 w-full max-w-5xl">
        <!-- Judul -->
        <h2 class="text-lg font-bold mb-4">History Service</h2>

        <!-- Search -->
        <div class="mb-3">
          <input type="text" placeholder="Search..."
            class="border rounded-md px-3 py-1 text-sm w-48 focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="w-full border-collapse">
            <thead>
              <tr class="bg-gray-100 text-left text-sm font-medium">
                <th class="p-2"><input type="checkbox"></th>
                <th class="p-2">Pelanggan</th>
                <th class="p-2">Teknisi</th>
                <th class="p-2">Status Pembayaran</th>
                <th class="p-2">ID Servis</th>
                <th class="p-2">Status</th>
              </tr>
            </thead>
            <tbody class="text-sm">
              <tr class="border-t">
                <td class="p-2"><input type="checkbox"></td>
                <td class="p-2">Ryan</td>
                <td class="p-2">Arif</td>
                <td class="p-2">Ditolak</td>
                <td class="p-2">1506C7F52931</td>
                <td class="p-2">
                  <span
                    class="bg-red-100 border border-red-400 text-red-600 px-3 py-1 rounded-lg inline-flex items-center gap-1">
                    Ditolak <i class="fa fa-times"></i>
                  </span>
                </td>
              </tr>
              <tr class="border-t">
                <td class="p-2"><input type="checkbox"></td>
                <td class="p-2">Bagus</td>
                <td class="p-2">Arif</td>
                <td class="p-2">Sudah Dibayarkan</td>
                <td class="p-2">1506C89E3272</td>
                <td class="p-2">
                  <span
                    class="bg-blue-100 border border-blue-400 text-blue-600 px-3 py-1 rounded-lg inline-flex items-center gap-1">
                    Diterima <i class="fa fa-check"></i>
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6 gap-2">
          <button class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200"><i class="fa fa-chevron-left"></i></button>
          <button class="px-3 py-1 rounded-md bg-gray-200 font-bold">1</button>
          <button class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200">2</button>
          <button class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200">3</button>
          <span class="px-3 py-1">...</span>
          <button class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200">18</button>
          <button class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200">19</button>
          <button class="px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200"><i class="fa fa-chevron-right"></i></button>
        </div>
      </div>
    </main>
  </div>

  <!-- Footer full width -->
  @include('komponen.footer')

</body>

</html>
