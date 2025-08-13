<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class ServiceController extends Controller
{
    public function create()
    {
        return view('page.user.servis');

    }

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

    public function sukses($service_id)
    {
        return view('page.user.servis_sukses', compact('service_id'));
    }
}