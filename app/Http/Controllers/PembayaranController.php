<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceDetail;

class PembayaranController extends Controller
{
    // Halaman form input ID
    public function index()
    {
        return view('page.teknisi.pembayaran');
    }

    // Proses cek ID servis
    public function check(Request $request)
{
    $request->validate([
        'input_id' => 'required|string',
    ]);

    $serviceDetail = ServiceDetail::where('service_id', $request->input_id)->first();

    if (!$serviceDetail) {
        return back()->with('error', 'ID Servis tidak ditemukan, silakan coba lagi.');
    }

    return view('page.teknisi.checkPembayaran', compact('serviceDetail'));
}

}