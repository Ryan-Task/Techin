<!DOCTYPE html>
<html lang="id" x-data="{ signatureSaved: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.1.5/signature_pad.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .print-only {
            display: none;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            body {
                background: white !important;
                padding: 10px !important;
                margin: 0 !important;
            }

            #nota {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
                margin: 0 !important;
                max-width: 100% !important;
                padding: 15px !important;
                page-break-inside: avoid;
            }

            .page-break {
                page-break-before: always;
            }
        }

        .signature-canvas {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: white;
            cursor: crosshair;
        }

        .bg-gray-50-print {
            background-color: #f9fafb !important;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen p-4">
    <div class="max-w-md mx-auto">
        <!-- Header dengan tombol kembali -->
        <div class="text-center mb-6 no-print">
            <div class="flex justify-between items-center mb-4">
                <a href="{{ url('/beranda') }}"
                    class="flex items-center text-blue-500 hover:text-blue-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <h1 class="text-2xl font-bold text-gray-800 flex-1 text-center">Nota Pembayaran</h1>
                <div class="w-6"></div> <!-- Spacer untuk balance -->
            </div>
            <p class="text-gray-600">Techin Service</p>
        </div>

        <!-- Receipt Card -->
        <div id="nota" class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6"
            style="max-height: 90vh; overflow-y: auto;">
            <!-- Company Info -->
            <div class="text-center border-b border-gray-200 pb-4 mb-4">
                <div class="flex items-center justify-center mb-2">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-tools text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">TECHIN</h2>
                </div>
                <p class="text-gray-500 text-sm">Jasa Servis Elektronik</p>
                <p class="text-gray-400 text-xs mt-1">www.techin-service.com</p>
            </div>

            <!-- Service Information - Compact -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2 text-sm">Informasi Servis</h3>
                    <div class="space-y-1 text-xs">
                        <div>
                            <span class="text-gray-600">ID:</span>
                            <span class="font-medium block">{{ $serviceRequest->service_id ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Tanggal:</span>
                            <span
                                class="font-medium block">{{ $serviceRequest->created_at->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Status:</span>
                            <span
                                class="font-medium text-green-600 capitalize block">{{ $serviceRequest->proses ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-700 mb-2 text-sm">Pelanggan</h3>
                    <div class="space-y-1 text-xs">
                        <div>
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-medium block">{{ $serviceRequest->nama_pelanggan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">No WA:</span>
                            <span class="font-medium block">{{ $serviceRequest->no_wa ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Details -->
            <div class="mb-4">
                <h3 class="font-semibold text-gray-700 mb-2 text-sm">Detail Servis</h3>
                <div class="bg-gray-50 rounded p-3 text-xs print:bg-gray-50-print">
                    <div class="mb-2">
                        <span class="text-gray-600 font-medium">Barang:</span>
                        <span class="font-medium ml-1 block">{{ $serviceRequest->nama_barang ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Kerusakan:</span>
                        <span class="font-medium ml-1 block">{{ $serviceRequest->kerusakan ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Cost Breakdown -->
            <div class="mb-4">
                <h3 class="font-semibold text-gray-700 mb-2 text-sm">Rincian Biaya</h3>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Sparepart:</span>
                        <span class="font-medium">Rp
                            {{ number_format($serviceRequest->detail->harga_sparepart ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Jasa:</span>
                        <span class="font-medium">Rp
                            {{ number_format($serviceRequest->detail->harga_jasa ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-200 mt-2 pt-2">
                        <div class="flex justify-between font-bold text-sm">
                            <span>Total Biaya:</span>
                            <span class="text-blue-600">Rp
                                {{ number_format($serviceRequest->detail->total_biaya ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Signature Section -->
            <div x-data="{ isEmpty: true }" class="border-t border-gray-200 pt-4">
                <h3 class="font-semibold text-gray-700 mb-3 text-sm">Tanda Tangan</h3>

                <div class="bg-gray-50 rounded p-3 print:bg-gray-50-print">
                    <canvas id="signature-pad" x-on:click="isEmpty = signaturePad.isEmpty()"
                        class="signature-canvas w-full h-20 mb-2"></canvas>

                    <div class="flex justify-between items-center">
                        <p class="text-xs text-gray-500"
                            x-text="signatureSaved ? '✓ Tanda tangan tersimpan' : 'Gambar tanda tangan di atas'"></p>
                        <div class="flex gap-1 no-print">
                            <button type="button" x-on:click="clearSignature(); signatureSaved = false; isEmpty = true"
                                class="px-2 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                                <i class="fas fa-eraser mr-1"></i>Hapus
                            </button>
                            <button type="button" x-on:click="saveSignature(); signatureSaved = true"
                                class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                                <i class="fas fa-save mr-1"></i>Simpan
                            </button>
                        </div>
                    </div>

                    <img id="signature-image" class="mt-2 mx-auto max-w-32 hidden print-only" />
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 pt-4 mt-4 text-center">
                <p class="text-gray-500 text-xs mb-2">Terima kasih atas kepercayaan Anda menggunakan layanan kami</p>
                <p class="text-gray-400 text-xs">Techin Service - Melayani dengan Profesional</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col gap-3 no-print">
            <button onclick="downloadNota()"
                class="bg-blue-500 text-white px-4 py-2 rounded font-medium hover:bg-blue-600 transition-colors flex items-center justify-center">
                <i class="fas fa-download mr-2"></i>Download PDF
            </button>
            <button onclick="window.print()"
                class="bg-green-500 text-white px-4 py-2 rounded font-medium hover:bg-green-600 transition-colors flex items-center justify-center">
                <i class="fas fa-print mr-2"></i>Cetak Nota
            </button>
            <a href="{{ url('/beranda') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded font-medium hover:bg-gray-600 transition-colors flex items-center justify-center text-center">
                <i class="fas fa-home mr-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        // Initialize Signature Pad
        let signaturePad;

        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById("signature-pad");

            // Set canvas background to white for better PDF export
            canvas.style.background = 'white';

            signaturePad = new SignaturePad(canvas, {
                minWidth: 0.5,
                maxWidth: 1.5,
                penColor: "#000000", // Use black for better print visibility
                backgroundColor: "rgba(255, 255, 255, 0)" // Transparent background
            });

            // Adjust canvas for high DPI
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            canvas.getContext("2d").fillStyle = "white";
            canvas.getContext("2d").fillRect(0, 0, canvas.width, canvas.height);
        });

        function clearSignature() {
            signaturePad.clear();
            // Fill with white background
            const canvas = document.getElementById("signature-pad");
            const ctx = canvas.getContext("2d");
            ctx.fillStyle = "white";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            document.getElementById("signature-image").classList.add("hidden");
        }

        function saveSignature() {
            if (!signaturePad.isEmpty()) {
                const dataURL = signaturePad.toDataURL('image/png');
                const img = document.getElementById("signature-image");
                img.src = dataURL;
                img.classList.remove("hidden");

                // Show success message
                showNotification('Tanda tangan berhasil disimpan!', 'success');
            } else {
                showNotification('Silakan beri tanda tangan terlebih dahulu', 'warning');
            }
        }

        function downloadNota() {
            const element = document.getElementById("nota");
            const opt = {
                margin: [10, 10],
                filename: `nota_servis_{{ $serviceRequest->service_id ?? 'unknown' }}.pdf`,
                image: {
                    type: 'png',
                    quality: 1
                },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    logging: false,
                    backgroundColor: '#ffffff',
                    onclone: function(clonedDoc) {
                        // Ensure all elements have white background for PDF
                        const nota = clonedDoc.getElementById('nota');
                        if (nota) {
                            nota.style.backgroundColor = 'white';
                            nota.style.color = 'black';
                        }

                        // Hide buttons in PDF
                        const buttons = clonedDoc.querySelectorAll('.no-print');
                        buttons.forEach(btn => btn.style.display = 'none');

                        // Show signature image in PDF
                        const signatureImg = clonedDoc.getElementById('signature-image');
                        if (signatureImg && signatureImg.src) {
                            signatureImg.classList.remove('hidden');
                            signatureImg.classList.add('print-only');
                        }
                    }
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            const button = event.currentTarget;
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Membuat PDF...';
            button.disabled = true;

            html2pdf().set(opt).from(element).save().then(() => {
                button.innerHTML = originalHTML;
                button.disabled = false;
                showNotification('PDF berhasil diunduh!', 'success');
            }).catch(error => {
                console.error('PDF generation error:', error);
                button.innerHTML = originalHTML;
                button.disabled = false;
                showNotification('Gagal membuat PDF', 'error');
            });
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-3 rounded-lg shadow-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' :
                type === 'warning' ? 'bg-yellow-500' :
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;

            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation' : type === 'error' ? 'times' : 'info'}"></i>
                    <span class="text-sm">${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Handle print event
        window.addEventListener('beforeprint', function() {
            // Show signature image when printing
            const signatureImg = document.getElementById('signature-image');
            if (signatureImg && signatureImg.src) {
                signatureImg.classList.remove('hidden');
                signatureImg.classList.add('print-only');
            }
        });

        window.addEventListener('afterprint', function() {
            // Hide signature image after printing
            const signatureImg = document.getElementById('signature-image');
            if (signatureImg) {
                signatureImg.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
