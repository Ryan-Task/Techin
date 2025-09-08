<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
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
            'no_wa' => 'required|string|max:20',
            'email' => 'nullable|email',
            'jenis_barang' => 'required',
            'nama_barang' => 'required|string|max:255',
            'kerusakan' => 'required|string',
        ]);

        $serviceId = 'SV-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $service = ServiceRequest::create([
            'service_id' => $serviceId,
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_wa' => $request->no_wa,
            'email' => $request->email,
            'jenis_barang' => $request->jenis_barang,
            'nama_barang' => $request->nama_barang,
            'kerusakan' => $request->kerusakan,
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

        $users = User::all();
        $services = ServiceRequest::all();

        return view('page.teknisi.daftarservis', compact('users', 'services'));
    }

    
    // ==================================================
    // Update Proses atau Status per service (bisa satu-satu)
    // ==================================================
// ==================================================
// Update Proses atau Status per service (bisa satu-satu)
// ==================================================
public function updateProsesStatus(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:service_requests,id',
        'proses' => 'nullable|string',
        'status' => 'nullable|string',
        'catatan' => 'nullable|string|max:1000', // tambahkan validasi catatan
    ]);

    $service = ServiceRequest::findOrFail($request->id);

    $validProses = ['barang diterima','barang sedang diperbaiki','barang sudah selesai diperbaiki','barang sudah selesai dan terbayar'];
    $validStatus = ['diterima','ditolak'];

    // set field yang valid
    $service->proses = in_array($request->proses, $validProses) ? $request->proses : $service->proses;
    $service->status = in_array($request->status, $validStatus) ? $request->status : $service->status;
    $service->catatan = $request->catatan ?? $service->catatan; // tambahkan catatan

    $service->save(); // simpan semua perubahan

    return redirect()->back()->with('success', 'Data berhasil diperbarui');

}
// Hapus satu service
public function destroy($id)
{
    $service = ServiceRequest::findOrFail($id);
    $service->delete();

    return redirect()->back()->with('success', 'Data servis berhasil dihapus.');
}

// Hapus banyak service sekaligus
public function bulkDelete(Request $request)
{
    $ids = $request->input('ids', []);

    if (!empty($ids)) {
        \App\Models\ServiceRequest::whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', 'Data servis terpilih berhasil dihapus.');
    }

    return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
}




}