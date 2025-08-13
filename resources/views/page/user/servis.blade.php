<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Servis</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media (max-width: 768px) {
            .form-container {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }

            .sidebar~.content-area {
                margin-left: 0;
            }
        }

        /* Animasi masuk */
        @keyframes fadeSlideUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-form {
            animation: fadeSlideUp 0.6s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col">

    @include('komponen.sidebar')

    <div class="content-area min-h-screen flex items-center justify-center lg:p-20 sm:pt-5 sm:pb-5">
        <div
            class="form-container w-full max-w-md bg-white rounded-2xl shadow-lg border border-gray-200 p-6 animate-form">

            <div class="mb-6 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-3 shadow-md">
                    <i class="fas fa-tools text-blue-500 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Form Servis Elektronik</h1>
                <p class="text-gray-500 mt-1 text-sm">Isi form berikut untuk mengajukan servis perangkat Anda</p>
            </div>

            <form action="{{ route('service.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Input dengan animasi hover -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Pelanggan</label>
                    <div class="relative group">
                        <input type="text" name="nama_pelanggan" required
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition-all duration-200 group-hover:shadow-md"
                            placeholder="Nama lengkap">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nomor WhatsApp</label>
                    <div class="relative group">
                        <input type="text" name="no_wa" required
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-300 focus:border-green-300 transition-all duration-200 group-hover:shadow-md"
                            placeholder="08xxxxxxxxxx">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fab fa-whatsapp text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                    <div class="relative group">
                        <input type="email" name="email"
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-300 transition-all duration-200 group-hover:shadow-md"
                            placeholder="email@contoh.com">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Barang</label>
                    <div class="relative group">
                        <select name="jenis_barang" required
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-300 focus:border-yellow-300 appearance-none transition-all duration-200 group-hover:shadow-md">
                            <option value="">Pilih jenis barang</option>
                            <option value="HP">Smartphone</option>
                            <option value="Laptop">Laptop</option>
                            <option value="PC">Komputer PC</option>
                            <option value="Tablet">Tablet</option>
                            <option value="TV">Televisi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-boxes text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Barang</label>
                    <div class="relative group">
                        <input type="text" name="nama_barang" required
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition-all duration-200 group-hover:shadow-md"
                            placeholder="Merk dan model">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-tag text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kerusakan</label>
                    <div class="relative group">
                        <textarea name="kerusakan" required rows="3"
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-300 focus:border-red-300 transition-all duration-200 group-hover:shadow-md"
                            placeholder="Jelaskan gejala kerusakan"></textarea>
                        <div class="absolute top-3 left-3">
                            <i class="fas fa-exclamation-triangle text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full mt-4 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2.5 px-4 rounded-lg transition-transform transform hover:scale-105 shadow-md">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Permintaan Servis
                </button>
            </form>
        </div>
    </div>

</body>
<br>
@include('komponen.footer')
</html>
