<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    @include('komponen.sidebar')
    <div class="ml-32 p-8 min-h-screen">
        <h2 class="text-2xl font-bold mb-6">Detail Pembayaran</h2>

        <!-- Info Pelanggan & Teknisi -->
        <div class="bg-white p-6 rounded shadow mb-6 max-w-2xl">
            <h3 class="text-lg font-semibold mb-2">Informasi Pelanggan</h3>
            <p><strong>ID Servis:</strong> {{ $service->service->service_id ?? '-' }}</p>
            <p><strong>Nama Pelanggan:</strong> {{ $service->service->nama_pelanggan ?? '-' }}</p>
            <p><strong>No WA Pelanggan:</strong> {{ $service->service->no_wa ?? '-' }}</p>

            <h3 class="text-lg font-semibold mt-4 mb-2">Teknisi / Penangani</h3>
            <p><strong>Nama Teknisi:</strong>
                {{ $service->service->handledBy ? $service->service->handledBy->name : '-' }}
            </p>
            <p><strong>No WA Teknisi:</strong>
                {{ $service->service->handledBy ? $service->service->handledBy->no_wa : '-' }}</p>

            <h3 class="text-lg font-semibold mt-4 mb-2">Detail Biaya</h3>
            <p><strong>Nama Sparepart:</strong> {{ $service->nama_sparepart ?? '-' }}</p>
            <p><strong>Harga Sparepart:</strong> Rp {{ number_format($service->harga_sparepart ?? 0, 0, ',', '.') }}</p>
            <p><strong>Harga Jasa:</strong> Rp {{ number_format($service->harga_jasa ?? 0, 0, ',', '.') }}</p>
            <p class="font-bold"><strong>Total Biaya:</strong> Rp
                {{ number_format($service->total_biaya ?? 0, 0, ',', '.') }}</p>
        </div>

        <!-- Pilihan Metode Pembayaran -->
        <div class="bg-white p-6 rounded shadow max-w-2xl">
            <h3 class="text-lg font-semibold mb-4">Pilih Metode Pembayaran</h3>

            <label class="inline-flex items-center mr-6">
                <input type="radio" name="payment_method" value="cod" class="form-radio" checked>
                <span class="ml-2">Cash on Delivery (COD)</span>
            </label>

            <label class="inline-flex items-center">
                <input type="radio" name="payment_method" value="ewallet" class="form-radio">
                <span class="ml-2">E-Wallet / Midtrans</span>
            </label>

            <div class="mt-6 flex gap-4">
                <!-- COD Button -->
                <form method="POST" action="{{ route('pembayaran.cod') }}">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->service->service_id }}">
                    <button type="submit" id="cod-button" class="bg-gray-600 text-white px-4 py-2 rounded">
                        Konfirmasi COD
                    </button>
                </form>

                <!-- E-Wallet Button -->
                <button id="ewallet-button" class="bg-green-600 text-white px-4 py-2 rounded hidden">
                    Bayar Sekarang
                </button>
            </div>
        </div>

        <!-- Midtrans Snap.js -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
        </script>

        <script>
            const codBtn = document.getElementById('cod-button');
            const ewalletBtn = document.getElementById('ewallet-button');
            const paymentRadios = document.getElementsByName('payment_method');

            Array.from(paymentRadios).forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.value === 'ewallet' && radio.checked) {
                        ewalletBtn.classList.remove('hidden');
                        codBtn.closest('form').classList.add('hidden');
                    } else {
                        ewalletBtn.classList.add('hidden');
                        codBtn.closest('form').classList.remove('hidden');
                    }
                });
            });

            ewalletBtn.addEventListener('click', () => {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        console.log(result);
                        window.location.href =
                            "{{ route('pembayaran.success', $service->service->service_id) }}";
                    },
                    onPending: function(result) {
                        console.log(result);
                        alert('Pembayaran masih pending.');
                    },
                    onError: function(result) {
                        console.log(result);
                        alert('Terjadi kesalahan saat pembayaran.');
                    },
                    onClose: function() {
                        alert('Kamu menutup popup tanpa menyelesaikan pembayaran.');
                    }
                });
            });
        </script>
    </div>
</body>

</html>
