<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\ServiceDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    // ==================================================
    // Form servis oleh user
    // ==================================================
    public function create()
    {
        return view('page.user.servis');
    }

    // ==================================================
    // Simpan data servis dari user
    // ==================================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_wa'          => 'required|string|max:20',
            'email'          => 'nullable|email',
            'jenis_barang'   => 'required',
            'nama_barang'    => 'required|string|max:255',
            'kerusakan'      => 'required|string',
        ]);

        $serviceId = 'SV-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $service = ServiceRequest::create([
            'service_id'     => $serviceId,
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_wa'          => $request->no_wa,
            'email'          => $request->email,
            'jenis_barang'   => $request->jenis_barang,
            'nama_barang'    => $request->nama_barang,
            'kerusakan'      => $request->kerusakan,
        ]);

        return redirect()->route('service.sukses', $service->service_id);
    }

    // ==================================================
    // Halaman sukses setelah submit servis
    // ==================================================
    public function sukses($service_id)
    {
        return view('page.user.servis_sukses', compact('service_id'));
    }

    // ==================================================
    // Daftar servis (hanya untuk teknisi/owner)
    // ==================================================
    public function daftarServis()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if (!in_array($user->role, ['teknisi', 'owner'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $users    = User::all();
        $services = ServiceRequest::with('handledBy')->get();

        return view('page.teknisi.daftarservis', compact('users', 'services'));
    }

    // ==================================================
    // Update Proses atau Status per service (bisa satu-satu)
    // ==================================================
    public function updateProsesStatus(Request $request)
    {
        $request->validate([
            'id'             => 'required|integer|exists:service_requests,id',
            'proses'         => 'nullable|string',
            'status'         => 'nullable|string',
            'catatan'        => 'nullable|string|max:1000',
            'nama_sparepart' => 'nullable|string|max:255',
            'harga_sparepart'=> 'nullable|numeric|min:0',
            'harga_jasa'     => 'nullable|numeric|min:0',
        ]);

        $service = ServiceRequest::findOrFail($request->id);

        $validProses = [
            'barang diterima',
            'barang sedang diperbaiki',
            'barang sudah selesai diperbaiki',
            'barang sudah selesai dan terbayar'
        ];
        $validStatus = ['diterima', 'ditolak'];

        $service->proses  = in_array($request->proses, $validProses) ? $request->proses : $service->proses;
        $service->status  = in_array($request->status, $validStatus) ? $request->status : $service->status;
        $service->catatan = $request->catatan ?? $service->catatan;

        // ====== Simpan id user yang update status ======
        if ($request->status) {
            $service->handled_by = Auth::id();
        }

        $service->save();

        // ====== Simpan detail biaya ======
        if ($request->filled('harga_sparepart') || $request->filled('harga_jasa') || $request->filled('nama_sparepart')) {
            $total = ($request->harga_sparepart ?? 0) + ($request->harga_jasa ?? 0);

            // Pastikan kolom relasinya sesuai: kita menyimpan/lookup berdasarkan service_id string
            ServiceDetail::updateOrCreate(
                ['service_id' => $service->service_id],
                [
                    'nama_sparepart'  => $request->nama_sparepart,
                    'harga_sparepart' => $request->harga_sparepart ?? 0,
                    'harga_jasa'      => $request->harga_jasa ?? 0,
                    'total_biaya'     => $total,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    // ==================================================
    // Hapus satu service
    // ==================================================
    public function destroy($id)
    {
        $service = ServiceRequest::findOrFail($id);
        $service->delete();

        return redirect()->back()->with('success', 'Data servis berhasil dihapus.');
    }

    // ==================================================
    // Hapus banyak service sekaligus
    // ==================================================
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            \App\Models\ServiceRequest::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Data servis terpilih berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
    }

    // ==================================================
    // Form untuk cek servis
    // ==================================================
    public function checkForm()
    {
        return view('page.user.check');
    }

    // ==================================================
    // Proses cek servis berdasarkan service_id atau no_wa
    // ==================================================
    public function check(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
        ]);

        $keyword = $request->input('keyword');

        // ambil service beserta relasi detail, user, teknisi, handledBy
        $service = ServiceRequest::with(['detail', 'user', 'teknisi', 'handledBy'])
            ->where('service_id', $keyword)
            ->orWhere('no_wa', $keyword)
            ->first();

        if (! $service) {
            return redirect()->back()->with('error', 'Data servis tidak ditemukan.');
        }

        // pastikan $detail tersedia untuk view agar tidak undefined
        $detail = $service->detail ?? null;

        return view('page.user.check_result', compact('service', 'detail'));
    }

    // ==================================================
    // Beri rating ke teknisi
    // ==================================================
   public function giveRating(Request $request, $id)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'ulasan' => 'nullable|string|max:1000',
    ]);

    // Ambil servis
    $service = ServiceRequest::findOrFail($id);

    // Simpan rating dan ulasan di service_requests
    $service->rating = $request->rating;
    $service->ulasan = $request->ulasan;
    $service->save();

    // Opsional: update rating rata-rata teknisi di tabel users
    if ($service->handled_by) {
        $teknisi = User::find($service->handled_by);
        if ($teknisi) {
            $totalServis = ServiceRequest::where('handled_by', $teknisi->id)
                ->whereNotNull('rating')
                ->count();
            $avgRating = ServiceRequest::where('handled_by', $teknisi->id)
                ->whereNotNull('rating')
                ->avg('rating');
            $teknisi->rating = $avgRating;
            $teknisi->total_servis = $totalServis;
            $teknisi->save();
        }
    }

    return redirect()->back()->with('success', 'Terima kasih, rating berhasil dikirim!');
}


    // ==================================================
    // History servis sesuai teknisi login
    // ==================================================
  public function history()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil servis yang sudah selesai & dibayar (status diterima) + servis yang ditolak
        $services = DB::table('service_requests as sr')
            ->join('service_details as sd', 'sr.service_id', '=', 'sd.service_id')
            ->where('sr.handled_by', $user->id)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('sr.status', 'diterima')
                      ->where('sr.proses', 'barang sudah selesai dan terbayar');
                })
                ->orWhere('sr.status', 'ditolak');
            })
            ->orderBy('sr.updated_at', 'desc')
            ->select(
                'sr.*',
                'sd.harga_jasa',
                'sd.harga_sparepart',
                'sd.total_biaya'
            )
            ->paginate(10);

        // Hitung total pendapatan dari servis diterima & selesai dibayar
        $totalPendapatan = DB::table('service_requests as sr')
            ->join('service_details as sd', 'sr.service_id', '=', 'sd.service_id')
            ->where('sr.handled_by', $user->id)
            ->where('sr.status', 'diterima')
            ->where('sr.proses', 'barang sudah selesai dan terbayar')
            ->sum('sd.total_biaya');

        // Pendapatan per bulan (hanya servis diterima & selesai dibayar)
        $incomePerMonth = DB::table('service_requests as sr')
    ->join('service_details as sd', 'sr.service_id', '=', 'sd.service_id')
    ->where('sr.handled_by', $user->id)
    ->where('sr.proses', 'barang sudah selesai dan terbayar')
    ->where('sr.status', 'diterima')
    ->selectRaw("
        EXTRACT(MONTH FROM sr.updated_at) as month,
        EXTRACT(YEAR FROM sr.updated_at) as year,
        SUM(sd.total_biaya) as total
    ")
    ->groupByRaw("EXTRACT(YEAR FROM sr.updated_at), EXTRACT(MONTH FROM sr.updated_at)")
    ->orderByRaw("EXTRACT(YEAR FROM sr.updated_at), EXTRACT(MONTH FROM sr.updated_at)")
    ->get();


        $grandTotal = $incomePerMonth->sum('total');

        // Hitung total servis diterima & selesai dibayar
        $totalDiterima = DB::table('service_requests')
            ->where('handled_by', $user->id)
            ->where('status', 'diterima')
            ->where('proses', 'barang sudah selesai dan terbayar')
            ->count();

        // Hitung total servis ditolak
        $totalDitolak = DB::table('service_requests')
            ->where('handled_by', $user->id)
            ->where('status', 'ditolak')
            ->count();

        return view('page.teknisi.history', compact(
            'services',
            'incomePerMonth',
            'grandTotal',
            'totalPendapatan',
            'totalDiterima',
            'totalDitolak'
        ));
    }
// ==================================================
// History servis khusus untuk Owner
// ==================================================
public function historyOwner(Request $request)
{
    $user = Auth::user();
    if (! $user) {
        return redirect()->route('login');
    }

    // Pastikan hanya role owner yang bisa akses
    if ($user->role !== 'owner') {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
    

    // Inisialisasi agar variabel selalu ada
    $selesai = collect();
    $tidakSelesai = collect();
    $incomePerMonth = collect();
    $users = collect(); // daftar teknisi untuk filter

    // daftar teknisi
    $users = User::where('role', 'teknisi')->get();

    $querySelesai = ServiceRequest::with(['detail', 'handledBy'])
        ->where('status', 'diterima')
        ->where('proses', 'barang sudah selesai dan terbayar');

    $queryTidak = ServiceRequest::with(['detail', 'handledBy'])
        ->where('status', 'ditolak');

    // cek filter teknisi
    if ($request->filled('teknisi_id')) {
        $querySelesai->where('handled_by', $request->teknisi_id);
        $queryTidak->where('handled_by', $request->teknisi_id);
    }

    $selesai = $querySelesai->orderBy('updated_at', 'desc')->get();
    $tidakSelesai = $queryTidak->orderBy('updated_at', 'desc')->get();

    $incomeQuery = DB::table('service_requests as sr')
        ->leftJoin('service_details as sd', 'sr.service_id', '=', 'sd.service_id')
        ->where('sr.status', 'diterima')
        ->where('sr.proses', 'barang sudah selesai dan terbayar');

    if ($request->filled('teknisi_id')) {
        $incomeQuery->where('sr.handled_by', $request->teknisi_id);
    }

    $incomePerMonth = $incomeQuery
        ->selectRaw("
            EXTRACT(MONTH FROM sr.updated_at) as month,
            EXTRACT(YEAR FROM sr.updated_at) as year,
            SUM(sd.total_biaya) as total,
            MAX(sr.rating) as rating,
            MAX(sr.ulasan) as ulasan
        ")
        ->groupByRaw("EXTRACT(YEAR FROM sr.updated_at), EXTRACT(MONTH FROM sr.updated_at)")
        ->orderByRaw("EXTRACT(YEAR FROM sr.updated_at), EXTRACT(MONTH FROM sr.updated_at)")
        ->get();

    return view('page.pemilik.riwayat', compact('selesai', 'tidakSelesai', 'incomePerMonth', 'users'));
}
public function ringkasanOwner(Request $request)
{
    $user = Auth::user();
    if (! $user) {
        return redirect()->route('login');
    }

    // Batasi hanya untuk owner
    if ($user->role !== 'owner') {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    // Tahun untuk perbandingan
    $currentYear = now()->year;
    $lastYear    = $currentYear - 1;

    // Ambil daftar teknisi (untuk dropdown)
    $users = User::where('role', 'teknisi')->orderBy('name')->get();

    // Query dasar untuk tabel Selesai
    $querySelesai = ServiceRequest::with(['detail', 'handledBy'])
        ->join('service_details as sd', 'service_requests.service_id', '=', 'sd.service_id')
        ->where('service_requests.status', 'diterima')
        ->where('service_requests.proses', 'barang sudah selesai dan terbayar')
        ->select('service_requests.*', 'sd.harga_jasa', 'sd.harga_sparepart', 'sd.total_biaya');

    // Query dasar untuk tabel Tidak Selesai
    $queryTidak = ServiceRequest::with(['detail', 'handledBy'])
        ->leftJoin('service_details as sd', 'service_requests.service_id', '=', 'sd.service_id')
        ->where('service_requests.status', 'ditolak')
        ->select('service_requests.*', 'sd.harga_jasa', 'sd.harga_sparepart', 'sd.total_biaya');

    // Jika ada filter teknisi dari query string
    $teknisiId = null;
    if ($request->filled('teknisi_id')) {
        $teknisiId = (int) $request->input('teknisi_id');
        $querySelesai->where('service_requests.handled_by', $teknisiId);
        $queryTidak->where('service_requests.handled_by', $teknisiId);
    }

    // Ambil koleksi untuk tampilan tabel
    $selesai = $querySelesai->orderBy('service_requests.updated_at', 'desc')->get();
    $tidakSelesai = $queryTidak->orderBy('service_requests.updated_at', 'desc')->get();

    // Totals untuk cards
    $totalSelesai = $selesai->count();
    $totalTidakSelesai = $tidakSelesai->count();
    $totalTeknisi = $users->count();

    // ==========================
    // Chart data: total biaya per bulan tahun ini & tahun lalu
    // ==========================
    $thisYearQuery = DB::table('service_requests as sr')
        ->join('service_details as sd', 'sr.service_id', '=', 'sd.service_id')
        ->where('sr.status', 'diterima')
        ->where('sr.proses', 'barang sudah selesai dan terbayar')
        ->whereYear('sr.updated_at', $currentYear);

    $lastYearQuery = DB::table('service_requests as sr')
        ->join('service_details as sd', 'sr.service_id', '=', 'sd.service_id')
        ->where('sr.status', 'diterima')
        ->where('sr.proses', 'barang sudah selesai dan terbayar')
        ->whereYear('sr.updated_at', $lastYear);

    if ($teknisiId) {
        $thisYearQuery->where('sr.handled_by', $teknisiId);
        $lastYearQuery->where('sr.handled_by', $teknisiId);
    }

    $thisYearData = $thisYearQuery
        ->selectRaw("EXTRACT(MONTH FROM sr.updated_at)::int as month, COALESCE(SUM(sd.total_biaya),0) as total")
        ->groupByRaw("EXTRACT(MONTH FROM sr.updated_at)")
        ->pluck('total', 'month');

    $lastYearData = $lastYearQuery
        ->selectRaw("EXTRACT(MONTH FROM sr.updated_at)::int as month, COALESCE(SUM(sd.total_biaya),0) as total")
        ->groupByRaw("EXTRACT(MONTH FROM sr.updated_at)")
        ->pluck('total', 'month');

    // Susun array 12 bulan
    $months = range(1, 12);
    $thisYearArr = [];
    $lastYearArr = [];
    foreach ($months as $m) {
        $thisYearArr[] = isset($thisYearData[$m]) ? (float) $thisYearData[$m] : 0;
        $lastYearArr[] = isset($lastYearData[$m]) ? (float) $lastYearData[$m] : 0;
    }

    // ==========================
    // Pie Chart: total biaya per teknisi
    // ==========================
    $pieQuery = DB::table('service_requests as sr')
        ->join('service_details as sd', 'sr.service_id', '=', 'sd.service_id')
        ->join('users as u', 'sr.handled_by', '=', 'u.id')
        ->where('sr.status', 'diterima')
        ->where('sr.proses', 'barang sudah selesai dan terbayar')
        ->select('u.name as teknisi', DB::raw('SUM(sd.total_biaya) as total'))
        ->groupBy('u.name');

    if ($teknisiId) {
        $pieQuery->where('sr.handled_by', $teknisiId);
    }

    $pieRaw = $pieQuery->get();
    $pieLabels = $pieRaw->pluck('teknisi')->toArray();
    $pieValues = $pieRaw->pluck('total')->map(fn($val) => (float) $val)->toArray();

    // ==========================
    // Bar Chart Horizontal: Distribusi rating (1–5)
    // ==========================
    $ratingQuery = DB::table('service_requests as sr')
        ->whereNotNull('sr.rating');

    if ($teknisiId) {
        $ratingQuery->where('sr.handled_by', $teknisiId);
    }

    $ratingCounts = $ratingQuery
        ->select('sr.rating', DB::raw('COUNT(*) as total'))
        ->groupBy('sr.rating')
        ->pluck('total', 'sr.rating');

    // susun array [1,2,3,4,5]
    $ratingArr = [];
    for ($i = 1; $i <= 5; $i++) {
        $ratingArr[] = $ratingCounts[$i] ?? 0;
    }
    

    // ==========================
    // Tambahan: Pendapatan Bersih
    // ==========================
    $pendapatanBersihQuery = DB::table('service_requests as sr')
        ->join('service_details as sd', 'sr.service_id', '=', 'sd.service_id')
        ->where('sr.status', 'diterima')
        ->where('sr.proses', 'barang sudah selesai dan terbayar');

    if ($teknisiId) {
        $pendapatanBersihQuery->where('sr.handled_by', $teknisiId);
    }

    $pendapatanBersih = $pendapatanBersihQuery
        ->select(
            DB::raw('COALESCE(SUM(sd.total_biaya),0) as total_biaya'),
            DB::raw('COALESCE(SUM(sd.harga_sparepart),0) as total_sparepart')
        )
        ->first();

    // pastikan hasil bukan stdClass saat dikurangi
    $totalBiaya = (float) ($pendapatanBersih->total_biaya ?? 0);
    $totalSparepart = (float) ($pendapatanBersih->total_sparepart ?? 0);
    $pendapatanBersihVal = $totalBiaya - $totalSparepart;

    // Kirim ke view
    return view('page.pemilik.ringkasan', [
        'users' => $users,
        'selesai' => $selesai,
        'tidakSelesai' => $tidakSelesai,
        'totalSelesai' => $totalSelesai,
        'totalTidakSelesai' => $totalTidakSelesai,
        'totalTeknisi' => $totalTeknisi,
        'currentYear' => $currentYear,
        'lastYearVal' => $lastYear,
        'thisYear' => json_encode($thisYearArr),
        'lastYear' => json_encode($lastYearArr),
        'pieLabels' => json_encode($pieLabels),
        'pieValues' => json_encode($pieValues),
        'ratingCounts' => $ratingArr,
        'pendapatanBersih' => $pendapatanBersihVal,
    ]);
}



}