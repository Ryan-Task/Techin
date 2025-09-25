<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceDetail;
use App\Models\ServiceRequest;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function checkForm()
    {
        return view('page.teknisi.checkPembayaran');
    }

    public function check(Request $request)
    {
        // validasi sederhana
        $request->validate([
            'keyword' => 'required'
        ]);

        $keyword = $request->keyword;

        // Ambil service detail (eager load service request & handledBy)
        $service = ServiceDetail::with('service.handledBy')
            ->whereHas('service', function($q) use ($keyword) {
                $q->where('service_id', $keyword)
                  ->orWhere('no_wa', $keyword);
            })
            ->first();

        if (!$service) {
            return back()->with('error', 'ID Servis atau No. WA tidak ditemukan');
        }

        // Pastikan total_biaya valid
        $grossAmount = is_numeric($service->total_biaya) ? (float)$service->total_biaya : 0;
        if ($grossAmount <= 0) {
            return back()->with('error', 'Biaya servis tidak valid');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // sandbox
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Order id unik
        $orderId = 'SERV-' . $service->service->service_id . '-' . time();

        // Generate Snap token
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $service->service->nama_pelanggan ?? 'Pelanggan',
                'phone' => $service->service->no_wa ?? '-',
            ],
            'enabled_payments' => ['dana', 'gopay', 'shopeepay'],
            'callbacks' => [
                'finish'   => route('pembayaran.success', $service->service->service_id),
                'unfinish' => route('pembayaran.form'),
                'error'    => route('pembayaran.form'),
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate Snap token: ' . $e->getMessage());
        }

        return view('page.teknisi.pembayaran', compact('service', 'snapToken'));
    }

    // Konfirmasi COD
    public function cod(Request $request)
    {
        $serviceId = $request->input('service_id');
        $serviceRequest = ServiceRequest::where('service_id', $serviceId)->first();

        if (!$serviceRequest) {
            return back()->with('error', 'ID Servis tidak ditemukan.');
        }

        // Update status pembayaran manual (COD)
        $serviceRequest->update([
            'proses' => 'barang sudah selesai dan terbayar'
        ]);

        return view('page.teknisi.cod_sukses', [
            'serviceRequest' => $serviceRequest
        ]);
    }

    // Route sukses pembayaran
    public function success($service_id)
    {
        $service = ServiceRequest::where('service_id', $service_id)->firstOrFail();
        $service->proses = 'barang sudah selesai dan terbayar';
        $service->save();

        return view('page.teknisi.pembayaran_success', [
            'service' => $service
        ]);
    }

    // Optional: cek service sebelum pembayaran
    public function confirmCOD(Request $request)
    {
        $service = ServiceDetail::with('service')
            ->whereHas('service', function($q) use ($request) {
                $q->where('service_id', $request->service_id)
                  ->orWhere('no_wa', $request->service_id);
            })
            ->first();

        if (!$service) return back()->with('error', 'Service tidak ditemukan');

        $service->service->update(['status' => 'waiting_cod']);
        return back()->with('success', 'Konfirmasi COD tersimpan.');
    }
}