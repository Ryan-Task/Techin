{{-- resources/views/user/service_success.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servis Berhasil</title>
    <style>
        /* Animasi masuk */
        @keyframes fadeSlideUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-card {
            animation: fadeSlideUp 0.6s ease-out;
        }

        /* Animasi ikon centang */
        @keyframes pop {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            80% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        .checkmark {
            animation: pop 0.5s ease forwards;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen flex flex-col lg:flex-row">

    {{-- Sidebar --}}
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 flex flex-col">
        @include('komponen.sidebar')
    </div>

    {{-- Konten Utama --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-8">
        <div class="max-w-lg w-full bg-white p-8 rounded-2xl shadow-lg animate-card text-center">

            <!-- Ikon sukses -->
            <div
                class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4 shadow-sm checkmark">
                <i class="fas fa-check text-green-600 text-3xl"></i>
            </div>

            <h1 class="text-2xl font-bold text-green-600 mb-2">Form Berhasil Dikirim!</h1>
            <p class="text-gray-600 mb-6">Terima kasih telah mengisi form. Berikut adalah ID Servis Anda:</p>

            <!-- ID Servis -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-6">
                <span id="serviceId" class="bg-gray-50 border px-4 py-2 rounded-lg font-mono shadow-sm">
                    {{ $service_id }}
                </span>
                <button onclick="copyId()"
                    class="bg-blue-500 hover:bg-blue-600 active:scale-95 transition px-4 py-2 rounded-lg text-white shadow">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>

            <!-- Tombol kembali -->
            <a href="{{ route('service.form') }}"
                class="inline-block bg-gray-500 hover:bg-gray-600 active:scale-95 transition px-5 py-2.5 rounded-lg text-white shadow">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Form
            </a>
        </div>
    </div>

    <script>
        function copyId() {
            let id = document.getElementById('serviceId').textContent;
            navigator.clipboard.writeText(id).then(() => {
                alert('ID Servis berhasil disalin!');
            });
        }
    </script>

</body>

</html>
