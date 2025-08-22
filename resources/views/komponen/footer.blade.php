<footer class="w-full bg-gradient-to-b from-[#013a3a] to-[#002929] text-white px-4 py-6 font-sans"
    x-data="{ year: new Date().getFullYear() }">
    <div class="max-w-7xl mx-auto">
        <!-- Main Footer Content - Two Columns on Mobile -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">

            <!-- Brand Column -->
            <div class="col-span-2 md:col-span-1 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="bg-[#00a676] p-1.5 rounded-md">
                        <i class="fa-solid fa-robot text-white text-lg"></i>
                    </div>
                    <span class="text-lg font-bold text-white">Techin</span>
                </div>
                <p class="text-xs text-gray-300">Servis elektronik profesional</p>
                <p class="text-2xs text-gray-400">&copy; <span x-text="year"></span></p>
            </div>

            <!-- Navigation Section -->
            <div class="space-y-1">
                <h3 class="text-xs font-semibold text-white mb-1 pb-1 border-b border-[#00a676]">Navigasi</h3>
                <ul class="space-y-1">
                    <li><a href="beranda" class="compact-footer-link">Beranda</a></li>
                    <li><a href="/servis" class="compact-footer-link">Servis</a></li>
                    <li><a href="#" class="compact-footer-link">Status</a></li>
                </ul>
            </div>

            <!-- Services Section -->
            <div class="space-y-1">
                <h3 class="text-xs font-semibold text-white mb-1 pb-1 border-b border-[#00a676]">Layanan</h3>
                <ul class="space-y-1">
                    <li><a href="dashboard#layanan" class="compact-footer-link">Layanan</a></li>
                    <li><a href="dashboard#dokumen" class="compact-footer-link">Panduan</a></li>
                    <li><a href="dashboard#tentang" class="compact-footer-link">Tentang</a></li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="col-span-2 md:col-span-1 space-y-2 mt-2 md:mt-0">
                <h3 class="text-xs font-semibold text-white mb-1 pb-1 border-b border-[#00a676]">Hubungi Kami</h3>

                <!-- WhatsApp Button -->
                <a href="https://wa.me/6281234567890" target="_blank"
                    class="flex items-center justify-center gap-1 bg-[#25D366] hover:bg-[#128C7E] text-white px-2 py-1.5 rounded text-xs transition-colors">
                    <i class="fab fa-whatsapp text-sm"></i>
                    <span>Chat</span>
                </a>

                <!-- Social Media Icons -->
                <div class="flex justify-center gap-2 pt-1">
                    <a href="#"
                        class="w-6 h-6 rounded-full bg-[#015858] flex items-center justify-center text-white hover:bg-[#00a676] transition-colors text-xs">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#"
                        class="w-6 h-6 rounded-full bg-[#015858] flex items-center justify-center text-white hover:bg-[#00a676] transition-colors text-xs">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-700 my-3 opacity-20"></div>

        <!-- Bottom Footer -->
        <div class="flex flex-col xs:flex-row justify-between items-center gap-1 text-center">
            <p class="text-2xs text-gray-400">© <span x-text="year"></span> Techin</p>
            <div class="flex gap-2 text-2xs">
                <a href="#" class="text-gray-400 hover:text-[#00ff85] transition-colors">Privacy</a>
                <span class="text-gray-400">•</span>
                <a href="#" class="text-gray-400 hover:text-[#00ff85] transition-colors">Terms</a>
            </div>
        </div>
    </div>

    <style>
        /* Improved footer links */
        .compact-footer-link {
            @apply block text-xs text-gray-300 hover:text-[#00ff85] transition-colors;
            position: relative;
            padding-left: 12px;
            line-height: 1.3;
        }

        .compact-footer-link::before {
            @apply absolute left-0 top-1/2 transform -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-[#00a676] opacity-0;
            content: '';
            transition: all 0.2s ease;
        }

        .compact-footer-link:hover::before {
            @apply opacity-100;
        }

        /* Section title improvements */
        h3 {
            letter-spacing: 0.5px;
        }

        /* Responsive adjustments */
        @media (max-width: 380px) {
            .compact-footer-link {
                @apply text-2xs;
                padding-left: 10px;
            }
        }
    </style>
</footer>
