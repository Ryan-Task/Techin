@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Techin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-white font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#0F3C3C] text-white p-4 flex flex-col gap-4">
            <div class="flex items-center gap-2 text-xl font-bold">
                <img src="/logo.png" alt="Techin" class="w-6 h-6" />
                Techin
            </div>
            <input type="text" placeholder="Search..." class="p-2 rounded bg-white text-black focus:outline-none" />

            <!-- Menu -->
            <nav class="flex-1">
                <div class="mt-4">
                    <p class="uppercase text-sm text-gray-300 mb-2">Umum</p>
                    <ul class="space-y-2">
                        <li><a href="#" class="flex items-center gap-2 bg-white text-[#0F3C3C] px-4 py-2 rounded">
                                <i class="fas fa-home"></i> Beranda </a></li>
                        <li><a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-[#145353] rounded"> <i
                                    class="fas fa-wrench"></i> Servis </a></li>
                        <li><a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-[#145353] rounded"> <i
                                    class="fas fa-tasks"></i> Check Status </a></li>
                    </ul>
                </div>

                <div class="mt-6">
                    <p class="uppercase text-sm text-gray-300 mb-2">Teknisi</p>
                    <ul class="space-y-2">
                        <li><a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-[#145353] rounded"> <i
                                    class="fas fa-list"></i> Daftar Servis </a></li>
                        <li><a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-[#145353] rounded"> <i
                                    class="fas fa-money-bill"></i> Pembayaran </a></li>
                    </ul>
                </div>

                <div class="mt-6">
                    <p class="uppercase text-sm text-gray-300 mb-2">Pemilik</p>
                    <ul class="space-y-2">
                        <li><a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-[#145353] rounded"> <i
                                    class="fas fa-chart-line"></i> Ringkasan </a></li>
                        <li><a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-[#145353] rounded"> <i
                                    class="fas fa-history"></i> Riwayat </a></li>
                        <li><a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-[#145353] rounded"> <i
                                    class="fas fa-user-cog"></i> Kelola Akun </a></li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-white p-8 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                <!-- Text Box -->
                <div class="bg-[#063C3C] text-white p-6 rounded-lg shadow">
                    <h2 class="text-sm uppercase font-semibold mb-1">Selamat Datang Di Techin</h2>
                    <h1 class="text-2xl font-bold leading-snug mb-4">
                        Kami menyelesaikan masalah perangkat elektronik Anda dengan keahlian teknologi.
                    </h1>
                    <p class="text-sm mb-4">
                        Performa kami adalah kepuasan Anda. Inovasi adalah semangat kami. Keahlian kami tak tertandingi.
                        Kami memberikan lebih untuk Anda.
                    </p>
                    <button class="bg-white text-[#063C3C] font-semibold px-4 py-2 rounded flex items-center gap-2">
                        JELAJAHI <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                <!-- Gambar -->
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1605379399642-870262d3d051" alt="Teknisi"
                        class="rounded-lg shadow w-full h-full object-cover" />
                    <div class="absolute top-2 right-2 bg-white p-2 rounded-full">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>

            <!-- Tombol Unduh -->
            <div class="mt-6 flex gap-2">
                <button class="bg-[#063C3C] text-white px-4 py-2 rounded">Unduh Tata Cara Lengkap</button>
                <button class="bg-[#063C3C] text-white px-4 py-2 rounded flex items-center gap-2">
                    Unduh <i class="fas fa-download"></i>
                </button>
            </div>

            <!-- Wave & Bot -->
            <div class="absolute bottom-0 left-0 w-full">
                <svg viewBox="0 0 1440 150" class="w-full">
                    <path fill="#0F3C3C"
                        d="M0,64L48,74.7C96,85,192,107,288,117.3C384,128,480,128,576,112C672,96,768,64,864,74.7C960,85,1056,139,1152,138.7C1248,139,1344,85,1392,58.7L1440,32L1440,150L1392,150C1344,150,1248,150,1152,150C1056,150,960,150,864,150C768,150,672,150,576,150C480,150,384,150,288,150C192,150,96,150,48,150L0,150Z">
                    </path>
                </svg>
                <img src="/bot.png" alt="Bot" class="absolute bottom-4 right-8 w-32" />
            </div>
        </main>
    </div>
</body>

</html>
