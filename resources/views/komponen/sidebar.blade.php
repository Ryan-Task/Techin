<div x-data="{ sidebarOpen: false }" class="relative">
    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed h-screen bg-teal-700 text-white flex flex-col w-64 lg:w-20 lg:hover:w-64 transition-all duration-300 ease-in-out shadow-xl z-50 group"
        :class="{ '-translate-x-full lg:translate-x-0': !sidebarOpen, 'translate-x-0': sidebarOpen }">

        <!-- Header with Logo -->
        <div class="flex items-center justify-between p-4 h-16 border-b border-teal-600">
            <div class="flex items-center min-w-[40px]">
                <img src="/logo.png" alt="Techin" class="w-8 h-8 ml-2" />
                <span
                    class="ml-2 font-semibold text-lg whitespace-nowrap lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">
                    Techin
                </span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-teal-200 hover:text-white">
                <i x-show="!sidebarOpen" class="fas fa-bars text-xl"></i>
                <i x-show="sidebarOpen" class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Search Box -->
        <div class="px-3 py-4 border-b border-teal-600">
            <div class="relative flex items-center">
                <i
                    class="fas fa-search text-teal-300 absolute left-3 transition-all duration-300 lg:left-1/2 lg:-translate-x-1/2 lg:group-hover:left-3 lg:group-hover:translate-x-0"></i>
                <input type="text" placeholder="Search"
                    class="w-full pl-10 pr-2 py-2 rounded bg-teal-50 text-teal-900 focus:outline-none text-xs
                           transition-all duration-300
                           lg:opacity-0 lg:group-hover:opacity-100
                           lg:w-0 lg:group-hover:w-full lg:group-hover:pl-10" />
            </div>
        </div>

        <!-- Main Menu - Scrollable Area -->
        <nav class="flex-1 flex flex-col px-2 py-4 overflow-y-auto 
                   scrollbar-none">
            <!-- Custom class to hide scrollbar -->

            <!-- General Section -->
            <div class="mb-4">
                <p
                    class="uppercase text-xs text-teal-200 mb-2 pl-1 lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">
                    Umum
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-home text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-wrench text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Servis</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-tasks text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Check
                                Status</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Technician Section -->
            <div class="mb-4">
                <p
                    class="uppercase text-xs text-teal-200 mb-2 pl-1 lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">
                    Teknisi
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-list text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Daftar
                                Servis</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-money-bill text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Pembayaran</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Owner Section -->
            <div class="mb-4">
                <p
                    class="uppercase text-xs text-teal-200 mb-2 pl-1 lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">
                    Pemilik
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-chart-line text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Ringkasan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-history text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Riwayat</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-user-cog text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Kelola
                                Akun</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>

    <!-- Mobile Toggle Button -->
    <div class="fixed lg:hidden bottom-4 right-4 z-40">
        <button @click="sidebarOpen = !sidebarOpen"
            class="bg-teal-700 text-white p-3 rounded-full shadow-lg hover:bg-teal-600 transition-colors duration-200">
            <i x-show="!sidebarOpen" class="fas fa-bars text-xl"></i>
            <i x-show="sidebarOpen" class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Mobile Overlay -->
    <div class="fixed inset-0 z-30 lg:hidden" x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>
</div>

<style>
    /* Add this to your main CSS file */
    .scrollbar-none {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    .scrollbar-none::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari and Opera */
    }
</style>
