<!DOCTYPE html>
<html lang="id" x-data="{
    sidebarOpen: window.innerWidth >= 1024,
    currentPayment: 0,
    payments: [
        { name: 'Bank Transfer', icon: 'university', banks: ['BCA', 'Mandiri', 'BRI', 'BNI'] },
        { name: 'E-Wallet', icon: 'mobile-alt', wallets: ['Dana', 'OVO', 'Gopay', 'ShopeePay'] },
        { name: 'Retail', icon: 'store', outlets: ['Alfamart', 'Indomaret'] },
        { name: 'Tunai', icon: 'money-bill-wave', desc: 'Bayar langsung di lokasi servis' }
    ],
    init() {
        // Auto-scroll payments
        setInterval(() => {
            this.currentPayment = (this.currentPayment + 1) % this.payments.length;
        }, 3000);
    }
}" @resize.window="sidebarOpen = window.innerWidth >= 1024">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .content-height {
            min-height: calc(100vh - 120px);
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .payment-slide {
            transition: all 0.5s ease;
        }

        .map-container {
            height: 300px;
            background-color: #eee;
            background-image: url('https://maps.googleapis.com/maps/api/staticmap?center=-6.175110,106.865036&zoom=15&size=600x300&maptype=roadmap&markers=color:red%7C-6.175110,106.865036&key=YOUR_API_KEY');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar Component -->
        @include('komponen.sidebar')

        <!-- Main Content -->
        <main class="flex-1 min-h-screen transition-all duration-300 ml-0 lg:ml-20"
            :class="{ 'lg:ml-34': sidebarOpen }">

            <!-- Header -->
            <div class="bg-white shadow-sm p-4">
                <h2 class="text-xl font-bold text-gray-800">Dashboard Utama</h2>
            </div>

            <div class="p-6 content-height">
                <!-- Welcome Banner -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Text Card -->
                    <div
                        class="bg-gradient-to-r from-[#063C3C] to-[#085555] text-white p-6 rounded-lg shadow-lg lg:col-span-1 flex flex-col">
                        <div class="flex-1">
                            <h1 class="text-xl font-bold mb-3">Keahlian Teknologi</h1>
                            <p class="mb-2 text-sm flex items-center">
                                <i class="fas fa-check-circle mr-2 text-teal-300"></i> Performa kami adalah kepuasan
                                Anda
                            </p>
                            <p class="mb-2 text-sm flex items-center">
                                <i class="fas fa-lightbulb mr-2 text-teal-300"></i> Inovasi adalah semangat kami
                            </p>
                            <p class="mb-4 text-sm flex items-center">
                                <i class="fas fa-trophy mr-2 text-teal-300"></i> Keahlian kami tak tertandingi
                            </p>
                        </div>
                        <button
                            class="bg-white text-[#063C3C] font-medium px-3 py-2 rounded hover:bg-gray-100 transition text-sm w-full">
                            JELAJAHI <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>

                    <!-- Image -->
                    <div class="rounded-lg shadow-lg overflow-hidden lg:col-span-2 h-64 relative">
                        <img src="/beranda.png" alt="Teknisi" class="w-full h-full object-cover" />
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <h3 class="text-white text-lg font-bold">Layanan Servis Elektronik Profesional</h3>
                            <p class="text-white/80 text-sm">Perbaikan cepat dan berkualitas untuk semua perangkat
                                elektronik</p>
                        </div>
                    </div>
                </div>

                <!-- Services Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Layanan Kami</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Service 1 -->
                        <div class="bg-white rounded-lg shadow p-4 service-card transition duration-300">
                            <div
                                class="bg-[#063C3C]/10 text-[#063C3C] w-10 h-10 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-tv text-lg"></i>
                            </div>
                            <h3 class="font-bold mb-2">Servis TV</h3>
                            <p class="text-gray-600 text-sm">Perbaikan berbagai merk TV mulai dari kerusakan gambar,
                                suara, hingga masalah power supply.</p>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500"><i class="fas fa-clock mr-1"></i> 1-3 hari kerja</p>
                                <p class="text-xs text-gray-500"><i class="fas fa-tag mr-1"></i> Mulai dari Rp 150.000
                                </p>
                            </div>
                        </div>

                        <!-- Service 2 -->
                        <div class="bg-white rounded-lg shadow p-4 service-card transition duration-300">
                            <div
                                class="bg-[#063C3C]/10 text-[#063C3C] w-10 h-10 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-laptop text-lg"></i>
                            </div>
                            <h3 class="font-bold mb-2">Servis Laptop</h3>
                            <p class="text-gray-600 text-sm">Perbaikan hardware dan software laptop termasuk ganti
                                komponen, install ulang, dan upgrade.</p>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500"><i class="fas fa-clock mr-1"></i> 2-5 hari kerja</p>
                                <p class="text-xs text-gray-500"><i class="fas fa-tag mr-1"></i> Mulai dari Rp 250.000
                                </p>
                            </div>
                        </div>

                        <!-- Service 3 -->
                        <div class="bg-white rounded-lg shadow p-4 service-card transition duration-300">
                            <div
                                class="bg-[#063C3C]/10 text-[#063C3C] w-10 h-10 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-mobile-alt text-lg"></i>
                            </div>
                            <h3 class="font-bold mb-2">Servis HP</h3>
                            <p class="text-gray-600 text-sm">Perbaikan ponsel mulai dari ganti layar, baterai, hingga
                                masalah software dengan garansi resmi.</p>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500"><i class="fas fa-clock mr-1"></i> 1-2 hari kerja</p>
                                <p class="text-xs text-gray-500"><i class="fas fa-tag mr-1"></i> Mulai dari Rp 100.000
                                </p>
                            </div>
                        </div>

                        <!-- Service 4 -->
                        <div class="bg-white rounded-lg shadow p-4 service-card transition duration-300">
                            <div
                                class="bg-[#063C3C]/10 text-[#063C3C] w-10 h-10 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-plug text-lg"></i>
                            </div>
                            <h3 class="font-bold mb-2">Servis Peralatan Rumah</h3>
                            <p class="text-gray-600 text-sm">Perbaikan peralatan elektronik rumah tangga seperti kulkas,
                                mesin cuci, AC, dan lainnya.</p>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500"><i class="fas fa-clock mr-1"></i> 3-7 hari kerja</p>
                                <p class="text-xs text-gray-500"><i class="fas fa-tag mr-1"></i> Mulai dari Rp 300.000
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Carousel -->
                <div class="mb-8 bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Metode Pembayaran</h3>
                    </div>
                    <div class="relative h-40 overflow-hidden">
                        <template x-for="(payment, index) in payments" :key="index">
                            <div x-show="currentPayment === index" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-x-full"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 translate-x-0"
                                x-transition:leave-end="opacity-0 -translate-x-full"
                                class="payment-slide absolute inset-0 p-6 flex items-center">
                                <div
                                    class="bg-[#063C3C]/10 text-[#063C3C] w-16 h-16 rounded-full flex items-center justify-center mr-6">
                                    <i class="fas" :class="'fa-' + payment.icon" class="text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg mb-2" x-text="payment.name"></h4>
                                    <template x-if="payment.banks">
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="bank in payment.banks">
                                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm"
                                                    x-text="bank"></span>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="payment.wallets">
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="wallet in payment.wallets">
                                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm"
                                                    x-text="wallet"></span>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="payment.outlets">
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="outlet in payment.outlets">
                                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm"
                                                    x-text="outlet"></span>
                                            </template>
                                        </div>
                                    </template>
                                    <p x-text="payment.desc" class="text-gray-600 mt-2" x-show="payment.desc"></p>
                                </div>
                            </div>
                        </template>
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                            <template x-for="(_, index) in payments.length">
                                <button @click="currentPayment = index" class="w-2 h-2 rounded-full transition"
                                    :class="{
                                        'bg-[#063C3C]': currentPayment === index,
                                        'bg-gray-300': currentPayment !==
                                            index
                                    }"></button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Service Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Location Map -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-4 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800">Lokasi Servis</h3>
                        </div>
                        <div class="map-container">
                            <!-- Replace with actual Google Maps embed -->
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.800714761054!2d107.61877031537317!3d-6.908203395012287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64a1e6a109d%3A0x301e8f1fc28b8e0!2sBandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1621234567890!5m2!1sen!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                class="rounded-b-lg"></iframe>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold mb-2">Techin Service Center</h4>
                            <p class="text-gray-600 text-sm mb-2"><i
                                    class="fas fa-map-marker-alt mr-2 text-[#063C3C]"></i> Jl. Teknologi No. 123,
                                Bandung</p>
                            <p class="text-gray-600 text-sm mb-2"><i class="fas fa-clock mr-2 text-[#063C3C]"></i>
                                Senin-Minggu: 08.00-17.00 WIB</p>
                            <p class="text-gray-600 text-sm"><i class="fas fa-phone mr-2 text-[#063C3C]"></i> (022)
                                1234567</p>
                        </div>
                    </div>

                    <!-- Service Process -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-4 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800">Proses Servis</h3>
                        </div>
                        <div class="p-4">
                            <div class="space-y-4">
                                <div class="flex">
                                    <div
                                        class="bg-[#063C3C] text-white w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        1</div>
                                    <div>
                                        <h4 class="font-bold">Diagnosa Awal</h4>
                                        <p class="text-gray-600 text-sm">Teknisi akan melakukan pemeriksaan awal untuk
                                            menentukan kerusakan</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div
                                        class="bg-[#063C3C] text-white w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        2</div>
                                    <div>
                                        <h4 class="font-bold">Penawaran Biaya</h4>
                                        <p class="text-gray-600 text-sm">Anda akan menerima estimasi biaya perbaikan
                                            sebelum pekerjaan dimulai</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div
                                        class="bg-[#063C3C] text-white w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        3</div>
                                    <div>
                                        <h4 class="font-bold">Perbaikan</h4>
                                        <p class="text-gray-600 text-sm">Proses perbaikan dilakukan oleh teknisi
                                            bersertifikat</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div
                                        class="bg-[#063C3C] text-white w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        4</div>
                                    <div>
                                        <h4 class="font-bold">Pengujian</h4>
                                        <p class="text-gray-600 text-sm">Perangkat diuji untuk memastikan berfungsi
                                            dengan baik</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div
                                        class="bg-[#063C3C] text-white w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        5</div>
                                    <div>
                                        <h4 class="font-bold">Penyerahan</h4>
                                        <p class="text-gray-600 text-sm">Perangkat siap diambil dengan garansi servis
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WA Button -->
                <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center justify-center mb-8">
                    <div
                        class="bg-green-100 text-green-800 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fab fa-whatsapp text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Butuh Bantuan Cepat?</h3>
                    <p class="text-gray-600 text-sm text-center mb-4">Hubungi teknisi kami via WhatsApp untuk
                        konsultasi gratis</p>
                    <a href="https://wa.me/6281234567890?text=Halo%20Techin%2C%20saya%20membutuhkan%20bantuan%20servis%20elektronik"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full transition flex items-center">
                        <i class="fab fa-whatsapp mr-2"></i> Chat WhatsApp Sekarang
                    </a>
                </div>

                <!-- Download Section -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Dokumen & Panduan</h3>
                    <div class="flex flex-wrap gap-4">
                        <button
                            class="bg-[#063C3C] hover:bg-[#085555] text-white px-6 py-3 rounded transition flex items-center">
                            <i class="fas fa-file-pdf mr-2"></i> Panduan Servis
                        </button>
                        <button
                            class="bg-[#063C3C] hover:bg-[#085555] text-white px-6 py-3 rounded transition flex items-center">
                            <i class="fas fa-file-alt mr-2"></i> Syarat & Ketentuan
                        </button>
                        <button
                            class="bg-[#063C3C] hover:bg-[#085555] text-white px-6 py-3 rounded transition flex items-center">
                            <i class="fas fa-download mr-2"></i> Brosur Layanan
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
