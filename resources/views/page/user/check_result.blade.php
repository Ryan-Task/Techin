<!-- resources/views/page/user/check_result.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hasil Cek Servis - {{ $service->service_id }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Status & Deskripsi -->
        <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-600">
            <div class="flex items-center gap-3 mb-2">
                <i class="fa-solid fa-screwdriver-wrench text-blue-600 text-2xl"></i>
                <h2 class="text-lg font-semibold capitalize">{{ $service->proses ?? 'Belum ada proses' }}</h2>
            </div>
            @php
                $descriptions = [
                    'barang diterima' =>
                        'Nantikan informasinya selanjutnya melalui WhatsApp maupun notifikasi jika barang sudah selesai',
                    'barang sedang diperbaiki' =>
                        'Nantikan informasinya selanjutnya melalui WhatsApp maupun notifikasi jika barang sudah selesai',
                    'barang sudah selesai diperbaiki' =>
                        'Silahkan Ambil Barang Ke Tempat Kami, Sesuai Dengan Alamat/Lokasi Yang Sudah Tertera. Bila Ada Kendala Bisa Hubungi Teknisi Kami Untuk Share Lokasi',
                    'barang sudah selesai dan terbayar' =>
                        'Silahkan Memberikan Rating Pelayanan Dan Juga Hubungi Jika Ada Kendala',
                ];
                $deskripsiProses = $descriptions[strtolower($service->proses ?? '')] ?? null;
            @endphp
            @if ($deskripsiProses)
                <p class="text-gray-600">{{ $deskripsiProses }}</p>
            @endif
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Left: Rincian Transaksi -->
            <div class="md:col-span-2 space-y-6">

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Rincian Transaksi</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Tanggal Diterima</p>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($service->created_at)->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500">ID Servis</p>
                            <p class="font-medium">{{ $service->service_id }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Nama Pelanggan</p>
                            <p class="font-medium">{{ $service->nama_pelanggan }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Detail Barang</p>
                            <p class="font-medium">{{ $service->jenis_barang }} - {{ $service->nama_barang }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-500">Kerusakan</p>
                            <p class="font-medium">{{ $service->kerusakan }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Teknisi</h3>
                    <div class="space-y-2 text-sm">
                        <p><span class="text-gray-500">Nama Teknisi:</span> {{ $service->teknisi ?? '-' }}</p>
                        <p><span class="text-gray-500">No. WA Teknisi:</span> {{ $service->wa_teknisi ?? '-' }}</p>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500">Rata-rata Rating:</span>
                            @php
                                $rating = $service->rating ?? (optional($service->user)->rating ?? 0);
                                $filled = floor($rating);
                                $half = $rating - $filled >= 0.5;
                                $empty = 5 - $filled - ($half ? 1 : 0);
                            @endphp
                            <div class="flex text-yellow-400">
                                @for ($i = 0; $i < $filled; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @if ($half)
                                    <i class="fas fa-star-half-alt"></i>
                                @endif
                                @for ($i = 0; $i < $empty; $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                            </div>
                            <span class="text-gray-600">{{ number_format($rating, 1) }}/5</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Biaya & Timeline -->
            <div class="space-y-6">

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-gray-700 mb-3">Detail Biaya</h3>
                    @if ($detail)
                        <div class="text-sm space-y-2">
                            <p><span class="text-gray-500">Nama Sparepart:</span> {{ $detail->nama_sparepart ?? '-' }}
                            </p>
                            <p><span class="text-gray-500">Harga Sparepart:</span> Rp
                                {{ number_format($detail->harga_sparepart ?? 0, 0, ',', '.') }}</p>
                            <p><span class="text-gray-500">Harga Jasa:</span> Rp
                                {{ number_format($detail->harga_jasa ?? 0, 0, ',', '.') }}</p>
                            <div class="border-t pt-2 mt-2 flex justify-between font-semibold">
                                <span>Total Biaya</span>
                                <span>Rp {{ number_format($detail->total_biaya ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Detail pembayaran belum diinputkan.</p>
                    @endif
                </div>

                <!-- Timeline -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-gray-700 mb-3">Runtutan Proses</h3>
                    @php
                        $steps = [
                            'barang diterima' => 'Barang Diterima',
                            'barang sedang diperbaiki' => 'Barang Sedang Diperbaiki',
                            'barang sudah selesai diperbaiki' => 'Barang Selesai Diperbaiki',
                            'barang sudah selesai dan terbayar' => 'Selesai',
                        ];
                        $current = strtolower($service->proses ?? '');
                        $passed = true;
                    @endphp
                    <div class="relative border-l-2 border-gray-200 ml-2">
                        @foreach ($steps as $key => $label)
                            @php
                                $active = $passed;
                                if ($key === $current) {
                                    $active = true;
                                    $passed = false;
                                }
                            @endphp
                            <div class="mb-6 ml-4">
                                <div class="w-3 h-3 rounded-full mb-1 {{ $active ? 'bg-green-500' : 'bg-gray-300' }}">
                                </div>
                                <p class="{{ $active ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                                    {{ $label }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        Perkiraan Barang Selesai:
                        <span class="font-medium">
                            {{ \Carbon\Carbon::parse($service->created_at)->addDays(3)->translatedFormat('d M Y, H:i') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center">
            <a href="{{ route('service.check.form') }}"
                class="inline-block px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">Cek Lainnya</a>
        </div>

    </div>
</body>

</html>
