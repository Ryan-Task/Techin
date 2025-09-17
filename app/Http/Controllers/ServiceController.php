<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\ServiceDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        // ====== Tambahkan: simpan id user yang update status ======
        if ($request->status) {
            $service->handled_by = Auth::id();
        }

        $service->save();

        // ====== Simpan detail biaya ======
        if ($request->filled('harga_sparepart') || $request->filled('harga_jasa')) {
            $total = ($request->harga_sparepart ?? 0) + ($request->harga_jasa ?? 0);

            ServiceDetail::updateOrCreate(
                ['service_id' => $service->service_id], // relasi ke tabel detail
                [
                    'nama_sparepart'  => $request->nama_sparepart,
                    'harga_sparepart' => $request->harga_sparepart,
                    'harga_jasa'      => $request->harga_jasa,
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

}