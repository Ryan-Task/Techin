<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.1.5/signature_pad.umd.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4 space-y-6">

    <!-- Nota -->
    <div id="nota" class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <div class="text-center border-b pb-4 mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Nota Pembayaran</h1>
            <p class="text-sm text-gray-500">Techin - Jasa Servis</p>
        </div>

        <div class="space-y-2 text-gray-700">
            <p><span class="font-semibold">Service ID:</span> {{ $serviceRequest->service_id ?? '-' }}</p>
            <p><span class="font-semibold">Nama Pelanggan:</span> {{ $serviceRequest->nama_pelanggan ?? '-' }}</p>
            <p><span class="font-semibold">No WA:</span> {{ $serviceRequest->no_wa ?? '-' }}</p>
            <p><span class="font-semibold">Nama Barang:</span> {{ $serviceRequest->nama_barang ?? '-' }}</p>
            <p><span class="font-semibold">Kerusakan:</span> {{ $serviceRequest->kerusakan ?? '-' }}</p>
            <p><span class="font-semibold">Total Biaya:</span> Rp
                {{ number_format($serviceRequest->detail->total_biaya ?? 0, 0, ',', '.') }}
            </p>
            <p><span class="font-semibold">Status Proses:</span> {{ $serviceRequest->proses ?? '-' }}</p>
            <p><span class="font-semibold">Tanggal:</span>
                {{ $serviceRequest->created_at->format('d-m-Y H:i') ?? now()->format('d-m-Y H:i') }}</p>
        </div>

        <!-- Tanda Tangan -->
        <div class="mt-6">
            <p class="font-semibold text-gray-700 mb-2">Tanda Tangan:</p>
            <canvas id="signature-pad" class="border border-gray-400 rounded w-full h-40"></canvas>
            <div class="flex justify-between mt-2">
                <button type="button" onclick="clearSignature()"
                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                <button type="button" onclick="saveSignature()"
                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Simpan</button>
            </div>
            <img id="signature-image" class="mt-3 hidden w-40" />
        </div>

        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">Terima kasih telah menggunakan layanan kami.</p>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-center gap-3">
        <button onclick="downloadNota()"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Download Nota
        </button>
        <button onclick="window.print()"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            Cetak
        </button>
    </div>

    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script>
        // Setup Signature Pad
        const canvas = document.getElementById("signature-pad");
        const signaturePad = new SignaturePad(canvas);

        function clearSignature() {
            signaturePad.clear();
            document.getElementById("signature-image").classList.add("hidden");
        }

        function saveSignature() {
            if (!signaturePad.isEmpty()) {
                const dataURL = signaturePad.toDataURL();
                const img = document.getElementById("signature-image");
                img.src = dataURL;
                img.classList.remove("hidden");
            } else {
                alert("Silakan tanda tangan dulu.");
            }
        }

        function downloadNota() {
            const element = document.getElementById("nota");
            const opt = {
                margin: 0.5,
                filename: 'nota_pembayaran_{{ $serviceRequest->service_id ?? 'unknown' }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>

</html>
