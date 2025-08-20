<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Teknisi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-b from-cyan-500 to-white flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-2xl shadow-2xl flex overflow-hidden w-full max-w-6xl mx-4">
        
        <!-- Bagian Kiri (Robot) -->
        <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-cyan-400 to-teal-400 w-1/2 p-8">
            <img src="/robo.png" alt="Robot Teknisi" class="max-h-[660px]">
        </div>

        <!-- Bagian Kanan (Form) -->
        <div class="w-full md:w-1/2 p-14 flex flex-col justify-center">
            <!-- Logo + Judul -->
            <div class="flex items-center justify-center mb-8">
                <img src="/logo.png" alt="Techin Logo" class="h-12 mr-3">
                <span class="text-2xl font-bold text-gray-800">Techin</span>
            </div>

            <h1 class="text-3xl font-bold text-center mb-8">Login Teknisi</h1>

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('teknisi.owner.login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <input type="email" id="email" name="email"
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 text-lg"
                            placeholder="you@example.com" required>
                        <!-- Ikon Surat -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="absolute left-3 top-3 h-6 w-6 text-black"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 8l9 6 9-6M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                        </svg>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 text-lg"
                            placeholder="••••••••" required>
                        <!-- Ikon Kunci -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="absolute left-3 top-3 h-6 w-6 text-black"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c.667 0 2-.333 2-2V7a2 2 0 10-4 0v2c0 1.667 1.333 2 2 2zm-6 0h12v10H6V11z" />
                        </svg>
                        <!-- Tombol show/hide -->
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-3 text-black hover:text-gray-600">
                            
                            <!-- Ikon Mata Terbuka (hidden default) -->
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Ikon Mata Tertutup (default visible) -->
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.977-4.59M9.88 9.88a3 3 0 104.24 4.24M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    <a href="#" class="text-sm text-cyan-600 hover:underline float-right mt-2">Forgot password?</a>
                    <br>
                </div>

                <!-- Tombol -->
                <button type="submit"
                    class="w-full bg-cyan-500 text-white py-3 rounded-xl text-lg font-semibold hover:bg-cyan-600 transition">
                    Log in
                </button>
            </form>
        </div>
    </div>
    

    <script>
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden', !isPassword);
            eyeClosed.classList.toggle('hidden', isPassword);
        });
    </script>
</body>
</html>
