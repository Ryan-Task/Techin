<div x-data="{ sidebarOpen: false }" class="relative">
    <!-- Mobile Toggle Button - Arrow on Sidebar Edge -->
    <div class="fixed lg:hidden z-50 top-4 left-0" :class="{ 'left-64': sidebarOpen }"
        x-transition:enter="transition-all duration-300 ease-in-out" x-transition:enter-start="left-0"
        x-transition:enter-end="left-64" x-transition:leave="transition-all duration-300 ease-in-out"
        x-transition:leave-start="left-64" x-transition:leave-end="left-0">

        <button @click="sidebarOpen = !sidebarOpen"
            class="bg-teal-700 text-white p-3 rounded-r-full shadow-lg hover:bg-teal-600 transition-all duration-200 transform
                   border-l-2 border-teal-600"
            :class="{ 'rotate-180': sidebarOpen }">
            <i class="fas fa-chevron-right text-lg"></i>
        </button>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed h-screen bg-teal-700 text-white flex flex-col w-64 lg:w-20 lg:hover:w-64 transition-all duration-300 ease-in-out shadow-xl z-40 group"
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
            <button @click="sidebarOpen = false" class="lg:hidden text-teal-200 hover:text-white">
                <i class="fas fa-times text-xl"></i>
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
        <nav class="flex-1 flex flex-col px-2 py-4 overflow-y-auto scrollbar-none">
            <!-- General Section - Always Visible -->
            <div class="mb-4">
                <p
                    class="uppercase text-xs text-teal-200 mb-2 pl-1 lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">
                    Umum
                </p>
                <ul class="space-y-1">
                    <li>
                        <a href="/beranda"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-home text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="/servis"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-wrench text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Servis</span>
                        </a>
                    </li>
                    <li>
                        <a href="/check-pembayaran"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-money-bill text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Pembayaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="/service/check"
                            class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                            <i class="fas fa-tasks text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Check
                                Status</span>
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Technician Section - Visible for Technician and Owner -->
            @auth
                @if (auth()->user()->role === 'teknisi' || auth()->user()->role === 'owner')
                    <div class="mb-4">
                        <p
                            class="uppercase text-xs text-teal-200 mb-2 pl-1 lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">
                            Teknisi
                        </p>
                        <ul class="space-y-1">
                            <li>
                                <a href="/daftar-servis"
                                    class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                                    <i class="fas fa-list text-lg w-6 text-center text-teal-300"></i>
                                    <span
                                        class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Daftar
                                        Servis</span>
                                </a>
                            </li>
                            <li>
                                <a href="/check-pembayaran"
                                    class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                                    <i class="fas fa-money-bill text-lg w-6 text-center text-teal-300"></i>
                                    <span
                                        class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Pembayaran</span>
                                </a>
                            </li>
                            <li>
                                <a href="/history"
                                    class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                                    <i class="fas fa-history text-lg w-6 text-center text-teal-300"></i>
                                    <span
                                        class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Riwayat</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

                <!-- Owner Section - Visible Only for Owner -->
                @if (auth()->user()->role === 'owner')
                    <div class="mb-4">
                        <p
                            class="uppercase text-xs text-teal-200 mb-2 pl-1 lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">
                            Pemilik
                        </p>
                        <ul class="space-y-1">
                            <li>
                                <a href="ringkasan-owner"
                                    class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                                    <i class="fas fa-chart-line text-lg w-6 text-center text-teal-300"></i>
                                    <span
                                        class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Ringkasan</span>
                                </a>
                            </li>
                            <li>
                                <a href="riwayat-owner"
                                    class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                                    <i class="fas fa-history text-lg w-6 text-center text-teal-300"></i>
                                    <span
                                        class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Riwayat</span>
                                </a>
                            </li>
                            <li>
                                <a href="/akun-owner"
                                    class="flex items-center gap-2 px-5 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200">
                                    <i class="fas fa-user-cog text-lg w-6 text-center text-teal-300"></i>
                                    <span
                                        class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Kelola
                                        Akun</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

                <!-- User Info Section -->
                <div class="mt-auto pt-4 border-t border-teal-600">
                    <div class="px-3 py-2">
                        <p
                            class="text-xs text-teal-200 lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">
                            Logged in as
                        </p>
                        <p
                            class="font-medium text-sm lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">
                            {{ auth()->user()->name }}
                        </p>
                        <p
                            class="text-xs text-teal-300 lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300 capitalize">
                            {{ auth()->user()->role }}
                        </p>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded hover:bg-teal-600 text-sm transition-colors duration-200 text-left">
                            <i class="fas fa-sign-out-alt text-lg w-6 text-center text-teal-300"></i>
                            <span
                                class="lg:opacity-0 lg:group-hover:opacity-100 lg:transition-opacity duration-300">Logout</span>
                        </button>
                    </form>
                </div>
            @else
                <!-- Login/Register Section for Guests -->
            @endauth
        </nav>

        <!-- Mobile Close Button at Bottom -->
        <div class="p-4 border-t border-teal-600 lg:hidden">
            <button @click="sidebarOpen = false"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-teal-600 rounded hover:bg-teal-500 text-sm transition-colors duration-200">
                <i class="fas fa-chevron-left"></i>
                <span>Tutup Menu</span>
            </button>
        </div>
    </aside>

    <!-- Mobile Overlay -->
    <div class="fixed inset-0 z-30 lg:hidden" x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>
</div>

<style>
    /* Scrollbar hiding */
    .scrollbar-none {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    /* Arrow button animations */
    .rotate-180 {
        transform: rotate(180deg);
    }
</style>

<script>
    (function() {
        if (!window.chatbase || window.chatbase("getState") !== "initialized") {
            window.chatbase = (...arguments) => {
                if (!window.chatbase.q) {
                    window.chatbase.q = []
                }
                window.chatbase.q.push(arguments)
            };
            window.chatbase = new Proxy(window.chatbase, {
                get(target, prop) {
                    if (prop === "q") {
                        return target.q
                    }
                    return (...args) => target(prop, ...args)
                }
            })
        }
        const onLoad = function() {
            const script = document.createElement("script");
            script.src = "https://www.chatbase.co/embed.min.js";
            script.id = "BXVXbfs9A4GQFnP9SI9v4";
            script.domain = "www.chatbase.co";
            document.body.appendChild(script)
        };
        if (document.readyState === "complete") {
            onLoad()
        } else {
            window.addEventListener("load", onLoad)
        }
    })();
</script>
