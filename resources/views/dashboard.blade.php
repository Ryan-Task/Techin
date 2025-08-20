<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techin - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Include Sidebar Component -->
    @include('komponen.sidebar')


    <div x-data="{
        currentCarousel: 0,
        paymentMethods: [
            { name: 'Bank Transfer', icon: 'fas fa-university', desc: 'Transfer ke rekening resmi' },
            { name: 'E-Wallet', icon: 'fas fa-wallet', desc: 'OVO, GoPay, Dana' },
            { name: 'Cash', icon: 'fas fa-money-bill-wave', desc: 'Pembayaran tunai' },
            { name: 'Credit Card', icon: 'fas fa-credit-card', desc: 'Visa, Mastercard' }
        ],
        testimonials: [
            { name: 'Ahmad Suharto', rating: 5, text: 'Pelayanan sangat memuaskan! Laptop saya yang rusak total bisa diperbaiki dengan sempurna.', device: 'Laptop Asus' },
            { name: 'Siti Nurhaliza', rating: 5, text: 'Teknisi profesional dan harga terjangkau. HP saya kembali normal seperti baru.', device: 'Samsung Galaxy' },
            { name: 'Budi Santoso', rating: 5, text: 'Proses cepat, hasil memuaskan. Recommended banget untuk perbaikan elektronik!', device: 'iPhone 12' }
        ],
        currentTestimonial: 0
    }" x-init="setInterval(() => {
        currentCarousel = (currentCarousel + 1) % paymentMethods.length;
        currentTestimonial = (currentTestimonial + 1) % testimonials.length;
    }, 4000)">

        <!-- Main Content -->
        <main class="lg:ml-20 transition-all duration-300">

            <!-- Hero Section dengan Satu Foto Full -->
            <section id="beranda"
                class="gradient-bg text-white min-h-screen flex items-center relative overflow-hidden">
                <!-- Background animasi tetap dipertahankan -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-20 left-10 w-20 h-20 bg-white rounded-full float-animation"></div>
                    <div class="absolute top-40 right-20 w-16 h-16 bg-white rounded-full float-animation"
                        style="animation-delay: 1s;"></div>
                    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white rounded-full float-animation"
                        style="animation-delay: 2s;"></div>
                </div>

                <div class="container mx-auto px-6 lg:px-12 relative z-10 pb-20">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Bagian teks tetap sama -->
                        <div>
                            <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                                Solusi <span class="text-teal-200">Perbaikan Elektronik</span> Terpercaya
                            </h1>
                            <p class="text-xl mb-8 text-teal-100">
                                Melayani perbaikan laptop, smartphone, TV, dan perangkat elektronik lainnya dengan
                                teknisi berpengalaman.
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <a href="#layanan"
                                    class="bg-white text-teal-700 px-8 py-3 rounded-full font-semibold hover:bg-teal-50 transition-all">
                                    Lihat Layanan
                                </a>
                                <a href="https://wa.me/6281234567890"
                                    class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-teal-700 transition-all">
                                    Hubungi Kami
                                </a>
                            </div>
                        </div>

                        <!-- Bagian foto full -->
                        <div
                            class="relative h-full min-h-[400px] rounded-3xl overflow-hidden shadow-2xl border-4 border-white border-opacity-20 ">
                            <!-- Foto utama -->
                            <img src="/beranda2.jpg" alt="Teknisi Profesional"
                                class="w-full h-full object-cover absolute inset-0 ">

                            <!-- Overlay gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-teal-900 to-transparent opacity-70">
                            </div>

                            <!-- Text overlay di bagian bawah foto -->
                            <div class="absolute bottom-0 left-0 right-0 p-8 text-center">
                                <p class="text-xl font-semibold text-white drop-shadow-lg">
                                    Tim Teknisi Bersertifikat Siap Membantu
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Quick Services Overview -->
            <section class="py-16 bg-white">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Unggulan</h2>
                        <p class="text-lg text-gray-600">Solusi cepat untuk kebutuhan perbaikan Anda</p>
                    </div>

                    <div class="grid md:grid-cols-4 gap-6">
                        <div class="group text-center p-6 rounded-xl hover:bg-teal-50 transition-all">
                            <div
                                class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-teal-200 transition-colors">
                                <i class="fas fa-laptop text-2xl text-teal-600"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Laptop</h3>
                            <p class="text-sm text-gray-600">Motherboard, LCD, Keyboard</p>
                        </div>

                        <div class="group text-center p-6 rounded-xl hover:bg-blue-50 transition-all">
                            <div
                                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors">
                                <i class="fas fa-mobile-alt text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Smartphone</h3>
                            <p class="text-sm text-gray-600">Layar, Battery, Camera</p>
                        </div>

                        <div class="group text-center p-6 rounded-xl hover:bg-purple-50 transition-all">
                            <div
                                class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition-colors">
                                <i class="fas fa-tv text-2xl text-purple-600"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">TV & Monitor</h3>
                            <p class="text-sm text-gray-600">LED, LCD, Smart TV</p>
                        </div>

                        <div class="group text-center p-6 rounded-xl hover:bg-orange-50 transition-all">
                            <div
                                class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-200 transition-colors">
                                <i class="fas fa-tools text-2xl text-orange-600"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Home Service</h3>
                            <p class="text-sm text-gray-600">Servis di rumah Anda</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Services Section -->
            <section id="layanan" class="py-20 bg-white">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-800 mb-4">Layanan Kami</h2>
                        <p class="text-xl text-gray-600">Solusi lengkap untuk semua kebutuhan perbaikan elektronik</p>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div
                            class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl p-8 hover:shadow-xl transition-all transform hover:-translate-y-2">
                            <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-laptop text-2xl text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Perbaikan Laptop</h3>
                            <p class="text-gray-600 mb-4">Servis motherboard, ganti LCD, keyboard, battery, dan upgrade
                                hardware</p>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-teal-600 mr-2"></i>Diagnosa gratis
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-teal-600 mr-2"></i>Garansi 30 hari
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 hover:shadow-xl transition-all transform hover:-translate-y-2">
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-mobile-alt text-2xl text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Perbaikan Smartphone</h3>
                            <p class="text-gray-600 mb-4">Ganti layar, battery, speaker, camera, dan perbaikan software
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-blue-600 mr-2"></i>Spare part original
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-blue-600 mr-2"></i>Selesai dalam 1 hari
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 hover:shadow-xl transition-all transform hover:-translate-y-2">
                            <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-tv text-2xl text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Perbaikan TV & Monitor</h3>
                            <p class="text-gray-600 mb-4">Servis LED, LCD, Smart TV, dan monitor komputer semua merk
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-purple-600 mr-2"></i>Perbaikan dirumah anda
                                    gratis
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-purple-600 mr-2"></i>Teknisi berpengalaman
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- About Section (Visi Misi & Sejarah) -->
            <section id="tentang" class="py-20 bg-gray-50">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Image Section -->
                        <div class="relative">
                            <div
                                class="bg-gradient-to-br from-teal-100 to-teal-200 rounded-3xl p-8 h-96 flex items-center justify-center">
                                <div class="text-center">
                                    <div
                                        class="w-32 h-32 bg-teal-600 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="fas fa-microchip text-4xl text-white"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-teal-800 mb-2">TECHIN</h3>
                                    <p class="text-teal-700">Professional Tech Repair</p>
                                    <div class="flex justify-center mt-4 space-x-4">
                                        <div class="w-8 h-8 bg-teal-500 rounded-full opacity-80"></div>
                                        <div class="w-6 h-6 bg-teal-400 rounded-full opacity-60 mt-1"></div>
                                        <div class="w-4 h-4 bg-teal-300 rounded-full opacity-40 mt-2"></div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="absolute -bottom-4 -right-4 w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                                <i class="fas fa-award text-3xl text-teal-600"></i>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div>
                            <h2 class="text-4xl font-bold text-gray-800 mb-8">Tentang Techin</h2>
                            <div class="mb-8">
                                <h3 class="text-2xl font-bold text-teal-600 mb-4">Visi</h3>
                                <p class="text-gray-600 mb-6">Menjadi pusat layanan perbaikan elektronik terdepan di
                                    Indonesia yang memberikan solusi terbaik dan terpercaya.</p>

                                <h3 class="text-2xl font-bold text-teal-600 mb-4">Misi</h3>
                                <div class="space-y-2">
                                    <div class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-600 mr-3 mt-1"></i>
                                        <span class="text-gray-600">Memberikan layanan perbaikan berkualitas
                                            tinggi</span>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-600 mr-3 mt-1"></i>
                                        <span class="text-gray-600">Membangun kepercayaan pelanggan</span>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-600 mr-3 mt-1"></i>
                                        <span class="text-gray-600">Mengembangkan SDM yang kompeten</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company History -->
                    <div class="mt-16">
                        <div class="bg-white rounded-2xl p-8 shadow-lg">
                            <h3 class="text-2xl font-bold text-teal-600 mb-8 text-center">Sejarah Perusahaan</h3>
                            <div class="grid md:grid-cols-3 gap-8">
                                <div class="text-center">
                                    <div class="w-4 h-4 bg-teal-600 rounded-full mx-auto mb-4"></div>
                                    <h4 class="font-bold text-gray-800 mb-2">2018 - Awal Berdiri</h4>
                                    <p class="text-gray-600 text-sm">Techin didirikan sebagai usaha perbaikan
                                        elektronik</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-4 h-4 bg-teal-600 rounded-full mx-auto mb-4"></div>
                                    <h4 class="font-bold text-gray-800 mb-2">2020 - Ekspansi</h4>
                                    <p class="text-gray-600 text-sm">Menambah layanan TV, monitor, dan elektronik
                                        lainnya</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-4 h-4 bg-teal-600 rounded-full mx-auto mb-4"></div>
                                    <h4 class="font-bold text-gray-800 mb-2">2024 - Multi Branch</h4>
                                    <p class="text-gray-600 text-sm">Membuka cabang di berbagai kota</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Payment Methods Carousel -->
            <section id="pembayaran" class="py-20 bg-white">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-800 mb-4">Metode Pembayaran</h2>
                        <p class="text-xl text-gray-600">Pilih metode pembayaran yang nyaman untuk Anda</p>
                    </div>

                    <div class="relative max-w-4xl mx-auto">
                        <div class="overflow-hidden rounded-2xl">
                            <div class="flex transition-transform duration-500 ease-in-out"
                                :style="{ transform: `translateX(-${currentCarousel * 100}%)` }">
                                <template x-for="(method, index) in paymentMethods" :key="index">
                                    <div class="w-full flex-shrink-0">
                                        <div
                                            class="bg-gradient-to-br from-teal-500 to-teal-700 text-white p-12 text-center">
                                            <i :class="method.icon" class="text-6xl mb-6"></i>
                                            <h3 class="text-3xl font-bold mb-4" x-text="method.name"></h3>
                                            <p class="text-xl text-teal-100" x-text="method.desc"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex justify-center mt-8 space-x-2">
                            <template x-for="(method, index) in paymentMethods" :key="index">
                                <button @click="currentCarousel = index"
                                    class="w-3 h-3 rounded-full transition-colors duration-300"
                                    :class="currentCarousel === index ? 'bg-teal-600' : 'bg-gray-300'">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Location & Service Process -->
            <section id="lokasi" class="py-20 bg-gray-50">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="grid lg:grid-cols-2 gap-16">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-8">Lokasi Servis</h2>
                            <div class="bg-white rounded-2xl p-8 shadow-lg">
                                <h3 class="text-xl font-bold text-teal-600 mb-4">Kantor Pusat</h3>
                                <div class="space-y-3 mb-6">
                                    <p class="text-gray-600 flex items-center">
                                        <i class="fas fa-map-marker-alt text-teal-600 mr-3"></i>
                                        Jl. Sidokare Asri
                                    </p>
                                    <p class="text-gray-600 flex items-center">
                                        <i class="fas fa-phone text-teal-600 mr-3"></i>
                                        (031) 1234-5678
                                    </p>
                                    <p class="text-gray-600 flex items-center">
                                        <i class="fas fa-clock text-teal-600 mr-3"></i>
                                        Senin - Sabtu: 09:00 - 21:00
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-4 bg-teal-50 rounded-lg">
                                        <i class="fas fa-car text-teal-600 text-2xl mb-2"></i>
                                        <p class="text-sm font-semibold">Antar Jemput</p>
                                    </div>
                                    <div class="text-center p-4 bg-teal-50 rounded-lg">
                                        <i class="fas fa-home text-teal-600 text-2xl mb-2"></i>
                                        <p class="text-sm font-semibold">Home Service</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-8">Proses Servis</h2>
                            <div class="space-y-4">
                                <div class="flex items-start bg-white rounded-xl p-6 shadow-lg">
                                    <div
                                        class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center mr-4 text-white font-bold">
                                        1</div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 mb-1">Diagnosa Kerusakan</h3>
                                        <p class="text-gray-600 text-sm">Analisis Barang</p>
                                    </div>
                                </div>
                                <div class="flex items-start bg-white rounded-xl p-6 shadow-lg">
                                    <div
                                        class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center mr-4 text-white font-bold">
                                        2</div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 mb-1">Perbaikan</h3>
                                        <p class="text-gray-600 text-sm">Proses perbaikan oleh teknisi ahli</p>
                                    </div>
                                </div>
                                <div class="flex items-start bg-white rounded-xl p-6 shadow-lg">
                                    <div
                                        class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center mr-4 text-white font-bold">
                                        3</div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 mb-1">Testing</h3>
                                        <p class="text-gray-600 text-sm">Pengujian untuk memastikan optimal</p>
                                    </div>
                                </div>
                                <div class="flex items-start bg-white rounded-xl p-6 shadow-lg">
                                    <div
                                        class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center mr-4 text-white font-bold">
                                        4</div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 mb-1">Pengambilan</h3>
                                        <p class="text-gray-600 text-sm">Pengambilan Barang Ke Lokasi Kami</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials Carousel -->
            <section id="testimoni" class="py-20 bg-white">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-800 mb-4">Testimoni Pelanggan</h2>
                        <p class="text-xl text-gray-600">Apa kata pelanggan yang telah mempercayai layanan kami</p>
                    </div>

                    <div class="max-w-4xl mx-auto">
                        <div class="relative overflow-hidden">
                            <div class="flex transition-transform duration-500 ease-in-out"
                                :style="{ transform: `translateX(-${currentTestimonial * 100}%)` }">
                                <template x-for="(testimonial, index) in testimonials" :key="index">
                                    <div class="w-full flex-shrink-0">
                                        <div
                                            class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-3xl p-12 text-center">
                                            <div
                                                class="w-20 h-20 bg-teal-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                                                <i class="fas fa-user text-white text-2xl"></i>
                                            </div>
                                            <div class="flex justify-center mb-4">
                                                <template x-for="star in testimonial.rating">
                                                    <i class="fas fa-star text-yellow-400 text-xl"></i>
                                                </template>
                                            </div>
                                            <p class="text-lg text-gray-700 italic mb-6" x-text="testimonial.text">
                                            </p>
                                            <h3 class="text-xl font-bold text-gray-800" x-text="testimonial.name">
                                            </h3>
                                            <p class="text-teal-600 font-semibold" x-text="testimonial.device"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex justify-center mt-6 space-x-2">
                            <template x-for="(testimonial, index) in testimonials" :key="index">
                                <button @click="currentTestimonial = index"
                                    class="w-3 h-3 rounded-full transition-colors"
                                    :class="currentTestimonial === index ? 'bg-teal-600' : 'bg-gray-300'">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Documents Section -->
            <section id="dokumen" class="py-20 bg-gray-50">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-800 mb-4">Dokumen & Panduan</h2>
                        <p class="text-xl text-gray-600">Download panduan dan informasi penting</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Tata Cara Servis -->
                        <div
                            class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-teal-500 to-teal-600">
                            </div>
                            <div class="p-8">
                                <div class="relative mb-6">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg">
                                        <i class="fas fa-clipboard-list text-3xl text-white"></i>
                                    </div>
                                    <div
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-star text-white text-sm"></i>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Tata Cara Servis</h3>
                                <p class="text-gray-600 text-center mb-6 text-sm">Panduan lengkap prosedur servis di
                                    Techin dari awal hingga selesai</p>
                                <div class="space-y-2 mb-6">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>Format PDF
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-download mr-2"></i>2.3 MB
                                    </div>
                                </div>
                                <button onclick="downloadFile('tata-cara-servis-techin.pdf')"
                                    class="w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white py-3 rounded-xl font-semibold hover:from-teal-600 hover:to-teal-700 transition-all duration-300 flex items-center justify-center group-hover:shadow-lg">
                                    <i class="fas fa-download mr-2"></i>Download Panduan
                                </button>
                            </div>
                        </div>

                        <!-- Syarat & Ketentuan -->
                        <div
                            class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-blue-600">
                            </div>
                            <div class="p-8">
                                <div class="relative mb-6">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg">
                                        <i class="fas fa-gavel text-3xl text-white"></i>
                                    </div>
                                    <div
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-exclamation text-white text-sm"></i>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Syarat & Ketentuan</h3>
                                <p class="text-gray-600 text-center mb-6 text-sm">Ketentuan layanan, garansi, dan
                                    kebijakan yang berlaku di Techin</p>
                                <div class="space-y-2 mb-6">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>Format PDF
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-download mr-2"></i>1.8 MB
                                    </div>
                                </div>
                                <button onclick="downloadFile('syarat-ketentuan-techin.pdf')"
                                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center justify-center group-hover:shadow-lg">
                                    <i class="fas fa-download mr-2"></i>Download S&K
                                </button>
                            </div>
                        </div>

                        <!-- Brosur Layanan -->
                        <div
                            class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div
                                class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-purple-500 to-purple-600">
                            </div>
                            <div class="p-8">
                                <div class="relative mb-6">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg">
                                        <i class="fas fa-braille text-3xl text-white"></i>
                                    </div>
                                    <div
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-sparkles text-white text-sm"></i>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Brosur Layanan</h3>
                                <p class="text-gray-600 text-center mb-6 text-sm">Katalog lengkap semua layanan dan
                                    paket perbaikan yang tersedia</p>
                                <div class="space-y-2 mb-6">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>Format PDF
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-download mr-2"></i>4.1 MB
                                    </div>
                                </div>
                                <button onclick="downloadFile('brosur-layanan-techin.pdf')"
                                    class="w-full bg-gradient-to-r from-purple-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-purple-600 hover:to-purple-700 transition-all duration-300 flex items-center justify-center group-hover:shadow-lg">
                                    <i class="fas fa-download mr-2"></i>Download Brosur
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-12 text-center">
                        <div class="bg-white rounded-2xl p-6 shadow-lg inline-block">
                            <h4 class="font-bold text-gray-800 mb-2">Butuh Bantuan?</h4>
                            <p class="text-gray-600 text-sm mb-4">Hubungi customer service kami untuk bantuan lebih
                                lanjut</p>
                            <a href="https://wa.me/6281234567890?text=Halo%20Techin,%20saya%20butuh%20bantuan%20terkait%20dokumen"
                                target="_blank"
                                class="inline-flex items-center bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors">
                                <i class="fab fa-whatsapp mr-2"></i>Chat Admin
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section id="kontak" class="py-20 bg-white">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-800 mb-4">Hubungi Kami</h2>
                        <p class="text-xl text-gray-600">Siap membantu Anda 24/7 untuk perbaikan elektronik</p>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-12">
                        <div class="space-y-6">
                            <div class="flex items-center space-x-6 p-6 bg-gray-50 rounded-2xl">
                                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fab fa-whatsapp text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">WhatsApp</h3>
                                    <p class="text-gray-600">+62 812-3456-7890</p>
                                    <a href="https://wa.me/6281234567890?text=Halo%20Techin,%20saya%20ingin%20konsultasi"
                                        target="_blank"
                                        class="inline-flex items-center mt-2 text-green-500 font-semibold hover:text-green-600">
                                        <i class="fas fa-external-link-alt mr-2"></i>Chat Sekarang
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center space-x-6 p-6 bg-gray-50 rounded-2xl">
                                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-phone text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Telepon</h3>
                                    <p class="text-gray-600">(031) 1234-5678</p>
                                    <p class="text-sm text-gray-500">Senin - Sabtu: 09:00 - 21:00</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-6 p-6 bg-gray-50 rounded-2xl">
                                <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-envelope text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Email</h3>
                                    <p class="text-gray-600">info@techin.co.id</p>
                                    <p class="text-sm text-gray-500">Respons dalam 24 jam</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-3xl p-8 text-white">
                            <h3 class="text-2xl font-bold mb-6">Konsultasi Gratis</h3>
                            <p class="mb-8 text-teal-100">Dapatkan konsultasi gratis untuk mengetahui permasalahan
                                perangkat elektronik Anda</p>

                            <div class="space-y-4 mb-8">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-xl text-teal-200"></i>
                                    <span>Diagnosa gratis tanpa biaya</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-xl text-teal-200"></i>
                                    <span>Estimasi waktu dan biaya</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-xl text-teal-200"></i>
                                    <span>Saran perawatan preventif</span>
                                </div>
                            </div>

                            <a href="https://wa.me/6281234567890?text=Halo%20Techin,%20saya%20ingin%20konsultasi%20gratis"
                                target="_blank"
                                class="inline-block w-full bg-white text-teal-700 py-4 rounded-xl text-center font-bold text-lg hover:bg-teal-50 transition-colors">
                                <i class="fab fa-whatsapp mr-2"></i>Mulai Konsultasi
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Floating WhatsApp Button -->
        <div class="fixed bottom-6 left-6 z-40">
            <a href="https://wa.me/6281234567890?text=Halo%20Techin,%20saya%20ingin%20berkonsultasi" target="_blank"
                class="bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-all transform hover:scale-110 float-animation flex items-center">
                <i class="fab fa-whatsapp text-2xl"></i>
            </a>
        </div>
        @include('komponen.footer')
    </div>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Download file function
        function downloadFile(filename) {
            showNotification(`Downloading ${filename}...`, 'success');
        }

        // Notification function
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className =
                `fixed top-4 right-4 z-50 p-4 rounded-lg text-white font-semibold transform transition-all duration-300 translate-x-full`;
            notification.className += type === 'success' ? ' bg-green-500' : ' bg-red-500';
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    </script>
</body>

</html>
