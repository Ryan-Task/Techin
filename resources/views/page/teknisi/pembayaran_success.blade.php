<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

@include('komponen.sidebar')

<body class="p-8 bg-green-50 min-h-screen">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow text-center">
        <h2 class="text-2xl font-bold text-green-600 mb-4">Pembayaran Berhasil!</h2>
        <p class="mb-2">Terima kasih, pembayaran untuk servis dengan ID:</p>
        <p class="font-bold text-lg mb-4">{{ $service->service_id }}</p>

        <p>Status proses sudah diperbarui menjadi:</p>
        <p class="font-semibold text-blue-600">Selesai dan Terbayar</p>

        <a href="/beranda" class="mt-6 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            Kembali ke Beranda
        </a>
    </div>
</body>

</html>
