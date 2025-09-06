<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">

  <!-- Sidebar -->
    @include('komponen.sidebar')
  
      <!-- Konten Utama -->
  <div class="flex-1 flex flex-col items-center justify-center p-6 ml-20"> 
    <main class="w-full max-w-6xl space-y-6">

      <!-- Grid untuk Chart -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-">
        
        <!-- Chart Pendapatan -->
        <div class="col-span-2 bg-white rounded-xl shadow-md p-4">
          <h2 class="text-lg font-bold mb-2">Total Pendapatan Tahunan</h2>
          <p class="text-xl font-bold text-gray-800">
            Rp.18.760.000 
            <span class="text-green-600 text-sm">+5,1%</span> 
            <span class="text-gray-600 text-sm">daripada tahun lalu</span>
          </p>
          <canvas id="chartPendapatan" class="mt-4"></canvas>
        </div>

        <!-- Chart Review -->
        <div class="bg-white rounded-xl shadow-md p-4">
          <h2 class="text-lg font-bold mb-2">Total Review</h2>
          <p class="text-sm text-gray-600">Sebanyak 1.200 orang</p>
          <div class="flex">
            <div class="w-1/2">
              <canvas id="chartReview"></canvas>
            </div>
            <div class="w-1/2 pl-2 space-y-1 text-sm">
              <p><i class="fas fa-star text-yellow-400"></i> Sebanyak 1092 rating 5/5</p>
              <p><i class="fas fa-star text-yellow-400"></i> Sebanyak 60 rating 4/5</p>
              <p><i class="fas fa-star text-blue-400"></i> Sebanyak 36 rating 3/5</p>
              <p><i class="fas fa-star text-red-400"></i> Sebanyak 12 rating 2/5</p>
              <p><i class="fas fa-star text-gray-400"></i> Sebanyak 0 rating 1/5</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabel -->
      <div class="bg-white rounded-xl shadow-md p-4">
        <div class="flex justify-end mb-4 space-x-2">
          <button class="px-3 py-1 border rounded-lg flex items-center gap-1">
            <i class="fas fa-download"></i> Unduh
          </button>
          <button class="px-3 py-1 border rounded-lg flex items-center gap-1">
            <i class="fas fa-filter"></i> Filter
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full border-collapse">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-2"><input type="checkbox"></th>
                <th class="p-2 text-left">Pelanggan</th>
                <th class="p-2 text-left">Teknisi</th>
                <th class="p-2 text-left">ID Servis</th>
                <th class="p-2 text-left">Total</th>
                <th class="p-2 text-left">Proses</th>
                <th class="p-2 text-left">Status</th>
                <th class="p-2 text-left">Penilaian</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-t">
                <td class="p-2"><input type="checkbox"></td>
                <td class="p-2">Ryan</td>
                <td class="p-2">Arif</td>
                <td class="p-2">1506C7F52931</td>
                <td class="p-2">Rp.185.000</td>
                <td class="p-2">Sudah diambil</td>
                <td class="p-2">Selesai</td>
                <td class="p-2"><i class="fas fa-star text-yellow-400"></i> 4/5</td>
              </tr>
              <!-- Ulangi row sesuai kebutuhan -->
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center mt-4 space-x-2">
          <button class="px-2 py-1 border rounded">&lt;</button>
          <button class="px-3 py-1 border rounded bg-gray-200">1</button>
          <button class="px-3 py-1 border rounded">2</button>
          <button class="px-3 py-1 border rounded">3</button>
          <span>....</span>
          <button class="px-3 py-1 border rounded">17</button>
          <button class="px-3 py-1 border rounded">18</button>
          <button class="px-3 py-1 border rounded">19</button>
          <button class="px-2 py-1 border rounded">&gt;</button>
        </div>
      </div>

    </main>
  </div>

  <script>
    // Chart Pendapatan
    const ctxPendapatan = document.getElementById('chartPendapatan');
    new Chart(ctxPendapatan, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
          { label: 'this year', data: [2800,2000,3000,4000,3500,4200,3100,2900,3300,4100,3600,3900], backgroundColor: '#38bdf8' },
          { label: 'last year', data: [3000,2500,2700,3200,3100,3000,2900,2700,2800,3100,3000,3400], backgroundColor: '#1e40af' }
        ]
      },
      options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    // Chart Review
    const ctxReview = document.getElementById('chartReview');
    new Chart(ctxReview, {
      type: 'pie',
      data: {
        labels: ['5/5','4/5','3/5','2/5','1/5'],
        datasets: [{ 
          data: [1092,60,36,12,0], 
          backgroundColor: ['#22c55e','#facc15','#3b82f6','#ef4444','#9ca3af'] 
        }]
      },
      options: { responsive: true, plugins: { legend: { display: false } } }
    });
  </script>

    {{-- Footer --}}
    @include('komponen.footer')

</body>
</html>
