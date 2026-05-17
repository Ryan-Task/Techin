<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="w-full max-w-lg bg-white rounded-xl shadow p-6">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center shrink-0">
                <span class="text-teal-700 font-bold">403</span>
            </div>
            <div class="flex-1">
                <h1 class="text-xl font-semibold text-gray-800">Anda bukan role yang diizinkan</h1>
                <p class="text-gray-600 mt-1">
                    Anda tidak memiliki akses ke halaman ini. Silakan login dengan akun yang sesuai.
                </p>

                @if ($message)
                    <p class="text-sm text-gray-500 mt-3">{{ $message }}</p>
                @endif

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('teknisi.owner.login.form') }}"
                        class="px-4 py-2 rounded-lg bg-teal-700 text-white hover:bg-teal-600 transition">
                        Login
                    </a>
                    <a href="{{ url()->previous() }}"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
